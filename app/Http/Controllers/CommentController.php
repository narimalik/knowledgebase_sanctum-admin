<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Throwable;
use DB;
use Exception;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Comment $comment)
    {
        
        $this->authorize("viewAny", $comment);
        
        return CommentResource::collection(Comment::all());
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
        DB::beginTransaction();
        try{

            //1st argu: actionName of policy, 
            //2nd argu: Model class name to determine policy class
            $this->authorize("create", Comment::class);

            $request->validate([
                "comments_detail"=> ["required", "min:2", "max:100"],
                #"parent_comment_id"=> ["required"],
                "article_id"=> ["required"],
            ]);

            Comment::create([
                "comments_detail" => $request->comments_detail,
                "parent_comment_id"=>$request->parent_comment_id,
                "article_id"=>$request->article_id,
                'added_by' => Auth::user()->id,
                'updated_by'=>Auth::user()->id,
            ]);
            DB::commit();
            return response(
                [
                    'message'=>'Comments Has been created',
                ]
            , 200);
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
        //
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

            $comment = Comment::find($id);
            $this->authorize("update",$comment);

            $request->validate([
                "comments_detail"=> ["required", "min:2", "max:100"],                
                "article_id"=> ["required"],
            ]);

            $comment->comments_detail = $request->comments_detail;
            $comment->parent_comment_id = $request->parent_comment_id;
            $comment->article_id = $request->article_id;
            $comment->updated_by=Auth::user()->id;            
            $comment->save();
            
            DB::commit();
            return response([
                "message"=> "Comment Updated sucessfully",
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
            $comment = Comment::find($id);  
            
            $this->authorize("delete", $comment);            
            
            $comment->delete();
                        
            DB::commit();
            return response([
                "message"=> "Comment Deleted sucessfully",
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
