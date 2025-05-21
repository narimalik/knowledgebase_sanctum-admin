<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;
use DB;

use Illuminate\Auth\Access\AuthorizationException;

class CategoryController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
             
       $categories = Category::with(['articles','user'])->get();           
        return  CategoryResource::collection($categories);


     }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        echo "I am in CategoryController:create() to show the Form"; exit;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $validate = $request->validate([
                "category_name" => ['required', 'min:5', 'max:100'],

            ]);
            Category::create([
                'category_name' => $request->category_name,
                'added_by' => Auth::user()->id,
                'updated_by'=>Auth::user()->id,
            ]);
            DB::commit();
            return response(
                [
                    'message'=>'Category Has been created',
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
        // return response([
        //     "message"=> "In category show()",
        //     ],
        //     500
        // );
        // exit;
        $categories = Category::with(['articles'])->where("id",$id)->get();           
        return  CategoryResource::collection($categories);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        echo "I am in CategoryController:edit()"; exit;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try{
                $validate = $request->validate([
                    "category_name" => ['required', 'min:5', 'max:100'],

                ]);
                //        echo "I am in CategoryController:update()"; exit;
                $cateogry = Category::find($id);
                $cateogry->category_name = $request->category_name;
                $cateogry->updated_by=Auth::user()->id;
                $cateogry->save();
                DB::commit();
                return response(
                    [
                        'message'=>'Category Has been updated',
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        DB::beginTransaction();
        try{
            $category = Category::find($id);
            $this->authorize("delete", $category);
            
            $category->delete();
            DB::commit();
            return response([
                "message"=>"Category Deleted Sucessfully",
            ],
            200);

        }
        //catch( AuthorizationException $e ){ echo $e->getMessage(); }
        catch(Throwable $exception){
            DB::rollback();            
            return response([
                "message"=> $exception->getMessage(),
                ],
                500
            );
        }
        

    }
}
