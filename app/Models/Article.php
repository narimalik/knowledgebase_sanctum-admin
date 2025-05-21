<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_title',
        'article_sub_title',
        'detail',
        'added_by',
        'updated_by',
    ];


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
