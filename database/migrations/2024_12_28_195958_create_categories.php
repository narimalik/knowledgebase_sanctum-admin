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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name')->nullable(false);
            $table->string('category_short_detail')->nullable(true);
            $table->integer('parent_category_id')->default(0);
            $table->integer('added_by');
            $table->integer('updated_by');
            $table->tinyInteger('status')->default(0);

           # $table->datetime('created_at');
           # $table->datetime('updated_at');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
