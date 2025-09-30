<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistered;
use App\Http\Resources\UserResource;
use App\Jobs\PasswordResetJob;
use App\Models\Role;
use App\Traits\Utilities;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use DB;
use Exception;
use PhpParser\Node\Expr\Cast\Object_;
use PhpParser\Node\Expr\New_;
use Str;
use Throwable;

class UserController extends Controller
{
    //
    use Utilities;

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
            
        }
        else{
           
            return redirect()->back()->withErrors(['Error'=> 'User Name or Password is Invalid!']);
        }

    }






    public function resetpasswordupdateform( Request $request){

        $request->validate([
            "email" => ["required", "email"]
        ]);
        
        return view("components.resetpasswordupdateform")->with(["data"=>$request]);

    }




    
    public function resetpasswordupdate( Request $request){

      
        try{

                // Token exist and valid in DB?
                $db_token = DB::table("password_reset_tokens")->where("email", $request->email )->first();
                if(!$db_token)
                {
                    return redirect()->back()->withErrors(["Errors" => "Invalid Request" ]);
                }


                $token_created = Carbon::parse($db_token->created_at);                 

                if(!$db_token || !Hash::check($request->token, $db_token->token ) || $token_created->diffInMinutes(now()) > 60  )
                {
                    return redirect()->back()->withErrors(["Errors" => "Expired Request" ]);
                }


                $request->validate([
                    "email" => ["required", "email"],
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
                    "token" => ["required"]
                ]);
         

                # Update user password
                $user = User::where("email", $request->email )->first();

                $user->password = Hash::make($request->password);

                $user->save();
        
            }catch(Throwable $exception){

                return redirect()->back()->withErrors(['Error'=> $exception->getMessage() ]);
            }

            DB::table("password_reset_tokens")->where("email", $request->email)->delete();
            return redirect()->route('login')->with(['success'=> "New Password has been updated please login with new passwrod!" ]);
    }





    public function sendForgotPasswordLink(Request $request){

        try{
        
            $request->validate([
                "email" => ["required", "email"]
            ]);

            # Check user exist
            $user = User::where("email", $request->email)->first();

            if(!$user){
                return redirect()->back()->withErrors(["Errors" => "Email not found" ]);
            }

            # Generate Token

            $db_token = DB::table("password_reset_tokens")->where("email", $request->email)->first();

            $token = Str::random(60);

            if($db_token)
            {        
                DB::table("password_reset_tokens")->where("email", $request->email)->delete();
            }

            DB::table("password_reset_tokens")->insert([
                "email"=> $request->email,
                "token"=> Hash::make($token),
                "created_at"=>Carbon::now()
            ]);

            # Send password link
            $extra_obj = new \stdClass();
            
            $extra_obj->respasswordurl = "resetpasswordupdateform/".$token.'?email='.$request->email;
            #$extra_obj->current_token = $token;            
           
            
            PasswordResetJob::dispatch($user, $extra_obj);
            

        }catch(Throwable $exception){

            return redirect()->back()->withErrors(['Error'=> $exception->getMessage() ]);
        }

        return redirect()->back()->with(['success'=> "Email will be sent on this email if its already registered with us." ]);

        


    }

    

    public function getToken(string $id){

        $user = User::findOrFail($id);
        $this->authorize('getToken', $user);
            
        $user->tokens()->delete();        
        
        $global_abilities = $this->getTokenGlobalAbilities();           

        $token = $user->createToken( $user->email, $global_abilities)->plainTextToken;
        echo $token; exit;
}





    public function showRegisteration(Request $request)
    {


        $user = new User();
        $this->authorize('create', $user);

        $roles = Role::all();
        
        return view("add-new-user")->with(["status"=>array( 1=> "Active",  0=>"inActive"), "roles"=>$roles ]);
    }




    public function editUser(string $id)
    {   
       
        $users = User::where("id", $id)->with("role")->first();        
        $this->authorize('update', $users);
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

        $this->authorize('update', $user);
        
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
        
        $user = new User();
        $this->authorize('create', $user);


        $request->validate([
            'name' => ['required', 'string', 'max:255'],            
            'username' => ['required', 'string', 'max:255','alpha_dash', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        # print_r( $request->all() ); exit;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            "isadmin" => $request->isadmin ?? 0,
            "status" => $request->status 
        ]);

        $roles = $request->roles;
        $user->role()->sync($roles);

        # Auth::login($user);
        // $token = $user->createToken($request->email)->plainTextToken;  // If you need token
         ## Create job to Send Welcom email         
        //  SendRegisteredEmailjob::dispatch($user);    //      
        
        return redirect()->back()->with(['success'=> "User Added sucessfully" ]);
    }




    public function usersList(){
        
        // $uses = User::all();
        $uses = User::with(["role"])->get();
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
            $user = null;
            $user = User::find($id);    

            $this->authorize('delete', $user);

            // Can't be delted if its admin.
            
            
            if( ($user->isadmin) || ($id == Auth::user()->id) )
            {
                return redirect()->back()->withErrors(['Error'=> "User can't be deleted!" ]);
            }


                   
            //Cant delete himself            
            if( $id == Auth::user()->id ){
              //  return redirect()->back()->withErrors(['Error'=> "User can't delete himself!" ]);
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
