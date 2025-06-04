<?php

namespace App\View\Components;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class addCategory extends Component
{
    /**
     * Create a new component instance.
     */

     public $status;
     public $categories;
     public $url;



    public function __construct(  )
    {
          $this->status = [0 =>'Active', 1 => 'inActive'  ];
          $categories_table = Category::all()->toArray();
          $this->categories = array_combine( array_column($categories_table,'id') , array_column($categories_table,'category_name'));
          $this->url = 'category-save';
          
          
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
      
        return view('components.add-category');
    }
}

