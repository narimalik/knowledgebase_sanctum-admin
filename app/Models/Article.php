<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'article_title',
        'article_sub_title',
        'detail',
        'status',
        'added_by',
        'updated_by',
    ];

     // Algolia
     public function toSearchableArray()
     {
         return [
            'article_title'=> $this->article_title,
            'article_sub_title'=>$this->article_sub_title,
            'detail'=>$this->detail
         ];
     }


    public function categories()
    {
        return $this->belongsToMany(Category::class, "article_category","article","category")->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, "article_id"); // third argument will be id.
    }

    public function user()
    {
        return $this->belongsTo(User::class, "added_by");
    }

}
