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
        Schema::create('tbl_blog_comment', function (Blueprint $table) {
            $table->id('blogcomment_id');
            $table->unsignedBigInteger('id_blog');
            $table->text('noi_dung');
            $table->string('ten_user', 255);
            $table->string('email_user', 255);
            $table->datetime('ngay_comment');
            $table->boolean('duyet')->default(false);
            $table->timestamps();

            $table->index(['id_blog', 'duyet']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_blog_comment');
    }
};
