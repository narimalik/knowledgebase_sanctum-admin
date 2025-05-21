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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('article_title')->nullable(true);
            $table->string('article_sub_title')->nullable(true);
            $table->text('detail')->nullable(true);
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
        Schema::dropIfExists('articles');
    }
};
