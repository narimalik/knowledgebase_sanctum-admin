<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\Utilities;

class UserPolicy
{

    use Utilities;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }



    public function create( User $user)
    {
        
       $need_permissoin = 'user:can-add';

       # is user Admin?
       # is this user added this category?
       if( $user->isadmin )
       {                 
         return true;
       }
       
       # is this user have permisson to delete?
       return $this->checkPermission($user,  $need_permissoin);
       return false;

    }




    public function update( User $user)
    {
       $need_permissoin = 'user:can-edit';
       # is user Admin?       
       
       if( $user->isadmin)
       {                 
         return true;
       }
       
       # is this user have permisson to delete?
       return $this->checkPermission($user,  $need_permissoin);
       return false;

    }



    public function delete( User $user)
    {
       $need_permissoin = 'user:can-delete';
       # is user Admin?
       # is this user added this category?
       if( $user->isadmin )
       {                 
         return true;
       }
       
       # is this user have permisson to delete?
       
       return $this->checkPermission($user,  $need_permissoin);
       return false;

    }




    public function getToken( User $user)
    {
       $need_permissoin = 'user:can-get-token';
       # is user Admin?
       # is this user added this category?
       if( $user->isadmin )
       {                 
         return true;
       }
       
       # is this user have permisson to delete?
       
       return $this->checkPermission($user,  $need_permissoin);
       return false;

    }

    






}
