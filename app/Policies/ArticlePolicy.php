<?php

namespace App\Policies;

use App\Models\Article;

use App\Models\User;
use App\Traits\Utilities;

class ArticlePolicy
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
        
       $need_permissoin = 'article:can-add';

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



    public function delete( User $user, Article $article)
    {
       $need_permissoin = 'article:can-delete';
       # is user Admin?
       # is this user added this category?
       if( $user->isadmin || $user->id === $article->added_by )
       {                 
         return true;
       }
       
       # is this user have permisson to delete?
       
       return $this->checkPermission($user,  $need_permissoin);
       return false;

    }



    public function update( User $user, Article $article)
    {
       

       $need_permissoin = 'article:can-edit';
       # is user Admin?
       # is this user added this article?
       
       if( $user->isadmin || $user->id === $article->added_by )
       {                 
         return true;
       }
       
       # is this user have permisson to delete?
       return $this->checkPermission($user,  $need_permissoin);
       return false;

    }




   

}
