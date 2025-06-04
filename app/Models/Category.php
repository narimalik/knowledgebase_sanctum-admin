<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'category_short_detail',
        'parent_category_id',
        'added_by',
        'updated_by',
        
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, "parent_category_id");
    }


    public function children()
    {
        return $this->belongsTo(Category::class, "parent_category_id");
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, "article_category", "category", "article")->withTimestamps();
    }

    public function user()
    {
        //return $this->belongsTo(User::class, "added_by");
        return $this->belongsTo(User::class, "added_by");
    }


    

}
