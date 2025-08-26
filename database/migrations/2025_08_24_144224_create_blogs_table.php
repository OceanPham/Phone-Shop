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
        Schema::create('tbl_blog', function (Blueprint $table) {
            $table->id('blog_id');
            $table->string('blog_title', 255);
            $table->text('noi_dung');
            $table->string('images', 255)->nullable();
            $table->datetime('create_time');
            $table->unsignedBigInteger('blogcate_id')->nullable();
            $table->text('tags')->nullable();
            $table->boolean('duyet')->default(false);
            $table->timestamps();

            $table->index(['duyet', 'create_time']);
            $table->index('blogcate_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_blog');
    }
};
