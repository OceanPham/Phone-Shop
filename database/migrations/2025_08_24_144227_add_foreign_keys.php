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
        // Add foreign key for blogs -> blog_categories
        Schema::table('tbl_blog', function (Blueprint $table) {
            $table->foreign('blogcate_id')->references('blogcate_id')->on('tbl_blog_cate');
        });

        // Add foreign key for blog_comments -> blogs
        Schema::table('tbl_blog_comment', function (Blueprint $table) {
            $table->foreign('id_blog')->references('blog_id')->on('tbl_blog');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_blog', function (Blueprint $table) {
            $table->dropForeign(['blogcate_id']);
        });

        Schema::table('tbl_blog_comment', function (Blueprint $table) {
            $table->dropForeign(['id_blog']);
        });
    }
};
