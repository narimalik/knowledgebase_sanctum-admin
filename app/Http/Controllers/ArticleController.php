<?php

namespace App\Http\Controllers;

use App\Events\ArticleEvent;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;
use DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Article $article)
    {
       
        if($request->user()->cant('viewAny',$article)){ 
            return response([                
                "message"=>"unauthorized"
            ],403);
        }

        //$this->authorize('viewAny',Article::class);
        ##$articles = Article::with(['categories'])->where('category',1)->paginate(10);
        $articles = Article::paginate(10);
        return ArticleResource::collection($articles);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
       
        $request->validate([
            "article_title" => ["required","max:100","min:5"],
            "detail" => ["required","min:5"],
        ]);

        DB::beginTransaction();
        try{
            
            //1st argu: actionName of policy, 
            //2nd argu: Model class name to determine policy class
            $this->authorize("create", Article::class); 

            $article = Article::create([
                'article_title'=>$request->article_title,
                'article_sub_title'=>$request->article_sub_title,
                'detail'=>$request->detail,
                'status'=>$request->status,
                'added_by' =>Auth::user()->id,
                'updated_by'=>Auth::user()->id,
            ]);

            $categories = $request->categories;
            $article->categories()->sync($categories);
            DB::commit();
            return response([
                "message"=> "Article Added sucessfully",
                ],
                200
            );

        }catch(Throwable $exception){
            DB::rollback();
            return response([
                "message"=> $exception->getMessage(),
                ],
                500
            );

        }

       

    }







    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        
        $articles = Article::where('id', $id)->get();   /// Don't sue ->get() with find()               
        return ArticleResource::collection($articles);

    }







    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try{

            $article = Article::find($id);

            $this->authorize('update', $article);

            //
            
            $request->validate([
                "article_title" => ["required","max:100","min:5"],
                "detail" => ["required"],
            ]);

            $article->article_title = $request->article_title;
            $article->article_sub_title = $request->article_sub_title;
            $article->detail = $request->detail;
            $article->status = $request->status;

            $article->updated_by=Auth::user()->id;
            
            $article->save();


            $categories = $request->categories;
            $article->categories()->sync($categories);
            DB::commit();
            return response([
                "message"=> "Article Updated sucessfully",
                ],
                200
            );

        }catch(Throwable $exception){
            DB::rollback();
            return response([
                "message"=> $exception->getMessage(),
                ],
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        DB::beginTransaction();
        
        try{
            $article = Article::find($id);  
            
            $this->authorize("delete", $article);

            $article = Article::with("categories")->get()->find($id);
            
            $article->delete();
            
            ArticleEvent::dispatch($article); // Event
            DB::commit();
            return response([
                "message"=> "Article Deleted sucessfully",
                ],
                200
            );
        }        
        catch(Throwable $exception){
            DB::rollback();
            #echo get_class($exception); exit;
            $exception->getMessage();
            return response([
                "message"=> $exception->getMessage(),
                ],
                500
            );
        }
            
            
        
        

        
        
    }
}
