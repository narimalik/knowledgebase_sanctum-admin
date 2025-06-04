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

use function PHPUnit\Framework\isNull;

class CategoryController extends Controller
{




    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     
        
        ## $categories_data = Category::select("category_name", "category_short_detail", "status")->get();
       
        $categories_data = Category::with("parent")->get();

        foreach( $categories_data as $categories )
        {        
            if( isset($categories->parent) )
            {                
                foreach( $categories->parent as $parent )
                {
                   #echo  $parent->category_name; exit;
                }
            }
           
        }
        
        return view('components.category')->with(["data" => $categories_data] );

     }







    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("addcategory");
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

           $cat_id =  Category::create([
                'category_name' => $request->category_name,
                'category_short_detail' => $request->category_detail,
                'parent_category_id' => $request->paraent_category,
                'added_by' => Auth::user()->id,
                'updated_by'=>Auth::user()->id,
            ]);
            

            DB::commit();
            return redirect()->back()->with(['success'=> "Category has been created" ]);

        }catch(Throwable $exception){
            DB::rollback();    

            // return response([
            //     "message"=> $exception->getMessage(),
            //     ],
            //     500
            // );

            return redirect()->back()->withErrors(['Error'=> $exception->getMessage() ]);
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
    public function edit( Request $request, $id)
    {
        

        DB::beginTransaction();
        try{
                
            $status = [1 =>'Active', 0 => 'inActive'  ];
            $categories_table = Category::all()->toArray();
            $categories = array_combine( array_column($categories_table,'id') , array_column($categories_table,'category_name'));


            $cateogry_detail = Category::find($id);
            

            if ( is_null($cateogry_detail) ) {
                
                return redirect()->route("add-category")->withErrors(['Category not found!']);
               
            }



               
            return view('components.add-category')->with(["cateogry_detail" => $cateogry_detail, "categories"=>$categories, "status"=>$status , 'url'=>'category-update'] );

            }catch(Throwable $exception){
               
                return redirect()->route("add-category")->withErrors([$exception->getMessage()]);
                    
            }



    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try{
                $validate = $request->validate([
                    "category_name" => ['required', 'min:5', 'max:100'],
                ]);

                $cateogry = Category::find($request->id);

                if ( is_null($cateogry) ) {                
                    return redirect()->route("add-category")->withErrors(['Category not found!']);                   
                }
    
                $cateogry->category_name = $request->category_name;

                $cateogry->category_short_detail = $request->category_detail;
                $cateogry->parent_category_id = $request->paraent_category;
                $cateogry->status = $request->status;

                $cateogry->updated_by=Auth::user()->id;
                $cateogry->save();
                DB::commit();

                return redirect()->back()->with(['success'=> "Category has been Updated" ]);

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
