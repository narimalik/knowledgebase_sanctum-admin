<?php
namespace App\Traits;

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


