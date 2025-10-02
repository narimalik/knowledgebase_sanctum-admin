<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('comments_detail')->nullable(true);
            $table->integer('parent_comment_id')->nullable(true)->default(0);         
            $table->integer('article_id');
            $table->tinyInteger('status')->default(0);
            $table->integer('added_by');
            $table->integer('updated_by');               
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
