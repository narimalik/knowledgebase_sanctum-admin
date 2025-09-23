<?php

namespace App\Http\Controllers;

use App\Events\ArticleEvent;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Category;
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
       
        // if($request->user()->cant('viewAny',$article)){ 
        //     return response([                
        //         "message"=>"unauthorized"
        //     ],403);
        // }

        //$this->authorize('viewAny',Article::class);
        //$articles = Article::with(['categories'])->where('category',1)->paginate(10);
        // $articles = Article::paginate(10);
        // return ArticleResource::collection($articles);


        $articles = Article::with(['categories'])->get();
        
        return view("article")->with(["articles"=>$articles] );
        
    }

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $status = [1 =>'Active', 0 => 'inActive' ];
        $categories_table = Category::all()->toArray();
        
        $categories = array_combine( array_column($categories_table,'id') , array_column($categories_table,'category_name'));
        return view("add-article")->with(["categories"=>$categories, "status"=>$status ] );
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        #print_r($request->all()); exit;
        $request->validate([
            "article_title" => ["required","max:100","min:5"],
            "description" => ["required","min:5"],
        ]);

        DB::beginTransaction();
        try{
            
            //1st argu: actionName of policy, 
            //2nd argu: Model class name to determine policy class
            #$this->authorize("create", Article::class); 

            $article = Article::create([
                'article_title'=>$request->article_title,
                'article_sub_title'=>$request->article_sub_title,
                'detail'=>$request->description,
                'detail'=> trim( strip_tags($request->description)),                
                'status'=>(int)$request->status,
                'added_by' =>Auth::user()->id,
                'updated_by'=>Auth::user()->id,
            ]);

            $categories = $request->categories;

            
            $article->categories()->sync($categories);
            DB::commit();

            return redirect()->back()->with(['success'=> "Article Added sucessfully" ]);


        }catch(Throwable $exception){
            DB::rollback();

            return redirect()->back()->withErrors(['Error'=> $exception->getMessage() ]);

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
        DB::beginTransaction();
        try{
                
            $status = [1 =>'Active', 0 => 'inActive'  ];
            $categories_table = Category::all()->toArray();
            $categories = array_combine( array_column($categories_table,'id') , array_column($categories_table,'category_name'));
            
            $article_detail = Article::with('categories:id')->where("id",$id)->get()->toArray();
            
            
            if ( is_null($article_detail) ) {
                return redirect()->route("edit-article")->withErrors(['Article not found!']);
            }

            $article_detail = (object)$article_detail[0];

            #print_r($article_detail); exit;

            $articles_categories_ids = array_column($article_detail->categories,'id');
           // print_r( $articles_categories_ids ); exit;

            return view('edit-article')->with(["article_detail" => $article_detail, "articles_categories_ids"=> $articles_categories_ids, "categories"=>$categories, "status"=>$status , 'url'=>'article-update'] );

            }catch(Throwable $exception){
               
                return redirect()->route("edit-article", ['id' => $article_detail->id])->withErrors([$exception->getMessage()]);
                    
            }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try{

            $article = Article::find($request->id);

           // $this->authorize('update', $article);

            //
            
            $request->validate([
                "article_title" => ["required","max:100","min:5"],
                "detail" => ["required","min:5"],
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

           return redirect()->back()->with(['success'=> "Article has been Updated" ]);


        }catch(Throwable $exception){
            DB::rollback();
            return redirect()->back()->withErrors(['Error'=> $exception->getMessage() ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        //
        DB::beginTransaction();
        try{
            $article = Article::find($id);
          
            
            $article->delete();
            DB::commit();
            return redirect()->back()->with(['success'=> "Article has been Deleted!" ]);


        }
        //catch( AuthorizationException $e ){ echo $e->getMessage(); }
        catch(Throwable $exception){
            DB::rollback();            
            return redirect()->back()->withErrors(['Error'=> $exception->getMessage() ]);
        }
        
            
      
    }

    public function upload(Request $request)
    {
        print_r($request->all()); exit;
    }




}
