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

}


