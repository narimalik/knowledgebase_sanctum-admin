<?php
namespace App\Traits;
use DB;
trait Utilities{


    public function getTokenGlobalAbilities()
    {

        
        return [
            'article:can-view',
            'category:can-view',
            'comment:can-view',            
        ];
    }



    public function checkPermission( $user, $permissoin ){

        $users_roles = $user->role;        
        $users_roles = $users_roles->toArray();
        $users_roles = array_column($users_roles,"role");
        
        return in_array( $permissoin , $users_roles );
 

    }

}


