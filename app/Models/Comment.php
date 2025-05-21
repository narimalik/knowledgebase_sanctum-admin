<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comments_detail',
        'parent_comment_id',
        'article_id',
        'added_by',
        'updated_by',
    ];


    public function article(){
        return $this->belongsTo(Article::class, "article_id");
    }


    public function user(){
        return $this->belongsTo(User::class, "added_by");
    }



}
