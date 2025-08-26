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
        Schema::create('tbl_blog_cate', function (Blueprint $table) {
            $table->id('blogcate_id');
            $table->string('catename', 255);
            $table->text('intro_cate')->nullable();
            $table->string('images', 255)->nullable();
            $table->datetime('date_create');
            $table->timestamps();

            $table->index('catename');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_blog_cate');
    }
};
