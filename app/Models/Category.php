<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class Category extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'category_name',
        'category_short_detail',
        'parent_category_id',
        'added_by',
        'updated_by',
        
    ];

    // Algolia
    public function toSearchableArray()
    {
        return [
            'category_name' => $this->category_name,
            'category_short_detail' => $this->category_short_detail,
        ];
    }



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
