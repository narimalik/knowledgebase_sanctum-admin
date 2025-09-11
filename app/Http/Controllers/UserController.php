<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistered;

use App\Events\RegisteredUser;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Jobs\SendRegisteredEmailjob;
use App\Models\Role;
use App\Traits\Utilities;
use Illuminate\Validation\Rule;
use DB;

class UserController extends Controller
{
    //
   ## use Utilities;

    public function login(Request $request){
        
        
        // It will through error if any
        $validated = $request->validate([
            'username'=> 'required',
            'password'=> 'required'
        ]);


        // User login
        $user_credentials = $request->only('username', 'password');
        
        if(Auth::attempt($user_credentials)){
            
            $request->session()->regenerate();
            return redirect()->route('dashboard');
            
        //     $user = Auth::user();
            
        //    $user->tokens()->delete();

        //    $request->session()->regenerate();
           
        //    $global_abilities = $this->getTokenGlobalAbilities();           

        //     $token = $user->createToken( $request->input('email'), $global_abilities)->plainTextToken;

        //     return response([ 
        //         "token"=>$token,
        //         "user"=>$user,
        //         'message'=>'Login successfull'
        //         ],
        //     200);


            
        }
        else{
            // return response([
            //     'message' => 'Invalid Login Details'
            // ], 401);
            return redirect()->back()->withErrors(['Error'=> 'User Name or Password is Invalid!']);
        }

    }

    public function showRegisteration(Request $request)
    {
        $roles = Role::all();
        return view("add-new-user")->with(["status"=>array( 1=> "Active",  0=>"inActive"), "roles"=>$roles ]);
    }




    public function editUser(string $id)
    {   
        $users = User::where("id", $id)->with("role")->first();
        
        $roles_list = Role::all();
        
        $roles = $users->role->toArray();
        $roles_currently_assigned =  array_column($roles,"id");

        return view("edit-new-user")->with(["users"=> $users, "status"=>array( 1=> "Active",  0=>"inActive") , "roles" => $roles, "roles_currently_assigned"=>$roles_currently_assigned, "roles_list"=>$roles_list ]);

    }   


public function userupdate( Request $request )
{

    DB::beginTransaction();
    try{

        $user = User::find($request->id);

      
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],            
            
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($request->id) ],
            
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
       
        $user->status = $request->status;

        # $user->updated_by=Auth::user()->id;
        
        $user->save();


        $roles = $request->roles;
        $user->role()->sync($roles);

        DB::commit();

       return redirect()->back()->with(['success'=> "User has been Updated" ]);


    }catch(Throwable $exception){
        DB::rollback();
        return redirect()->back()->withErrors(['Error'=> $exception->getMessage() ]);
    }

}

    
    


public function register(Request $request)
    {
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],            
            'username' => ['required', 'string', 'max:255','alpha_dash', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        $roles = $request->roles;
        $user->role()->sync($roles);

        #$categories = $request->categories;
        #$article->categories()->sync($categories);

       // event(new Registered($user));

        Auth::login($user);
        // $token = $user->createToken($request->email)->plainTextToken;  // If you need token
         ## Create job to Send Welcom email         
        //  SendRegisteredEmailjob::dispatch($user);    //      
        
        return redirect()->back()->with(['success'=> "User Added sucessfully" ]);
    }

    public function usersList(){
        
        $uses = User::all();
        return view("users")->with(["users"=>$uses]);
    }



    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        # $request->session()->invalidate();

       # $request->session()->regenerateToken();

        return redirect()->route('login');
    }






    public function isUserLoggedin(Request $request)
    {
        $message = '';
        $code = 0;

        if(Auth::check())
        {
            $message = 'User Still Logged In';
            $code = 200;
        }
        else{
            $message = 'User Logged Off';
            $code = 401;
        }

        return response([
            "message"=>$message
        ], $code);
    }

    public function getUsersAllData(Request $request)
    {
        // if( !$request->user()->tokenCan('article:can-view') ){
        //     return response([
                
        //     ],
        // 403);
        // }

        $data = User::with(["articles",  "articles.categories"])->get();
       // $data = User::find(25);  
        return UserResource::collection($data );
        // return response([
        //     "data"=> $data,            
        // ]);
    }


     /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        //
        DB::beginTransaction();
        try{
            
            $user = User::find($id);            
            //Cant delete himself            
            if( $id == Auth::user()->id ){
                return redirect()->back()->withErrors(['Error'=> "User can't delete himself!" ]);
            }

            $user->delete();
            DB::commit();
            return redirect()->back()->with(['success'=> "User has been Deleted!" ]);

        }
        //catch( AuthorizationException $e ){ echo $e->getMessage(); }
        catch(Throwable $exception){
            DB::rollback();            
            return redirect()->back()->withErrors(['Error'=> $exception->getMessage() ]);
        }
        
            
      
    }



}
