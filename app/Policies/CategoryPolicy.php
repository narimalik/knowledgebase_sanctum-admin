<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use App\Traits\Utilities;

class CategoryPolicy
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
        
       $need_permissoin = 'category:can-add';

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



    public function delete( User $user, Category $category)
    {
       $need_permissoin = 'category:can-delete';
       # is user Admin?
       # is this user added this category?
       if( $user->isadmin || $user->id === $category->added_by )
       {                 
         return true;
       }
       
       # is this user have permisson to delete?
       
       return $this->checkPermission($user,  $need_permissoin);
       return false;

    }



    public function update( User $user, Category $category)
    {
       
        $need_permissoin = 'category:can-edit';
       # is user Admin?
       # is this user added this category?
       if( $user->isadmin || $user->id === $category->added_by )
       {                 
         return true;
       }
       
       # is this user have permisson to delete?
       return $this->checkPermission($user,  $need_permissoin);
       return false;

    }




   

}
