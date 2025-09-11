<?php
namespace App\Libraries;
use DB;
use App\Models\Category;


Class CategoryCommons{


    public static function getCategories()
    {
        return Category::all();
    }

}