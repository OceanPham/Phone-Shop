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
        // Reply to blog comments
        Schema::create('tbl_reply_blog_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comment_id');
            $table->text('reply_content');
            $table->string('reply_author', 255);
            $table->string('reply_email', 255)->nullable();
            $table->datetime('reply_date');
            $table->boolean('approved')->default(false);
            $table->timestamps();

            $table->foreign('comment_id')->references('blogcomment_id')->on('tbl_blog_comment');
            $table->index(['comment_id', 'approved']);
        });

        // Reply to product comments
        Schema::create('tbl_reply_comments_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comment_id');
            $table->text('reply_content');
            $table->string('reply_author', 255);
            $table->string('reply_email', 255)->nullable();
            $table->datetime('reply_date');
            $table->boolean('approved')->default(false);
            $table->timestamps();

            $table->foreign('comment_id')->references('ma_binhluan')->on('tbl_comment');
            $table->index(['comment_id', 'approved']);
        });

        // Reply to reviews
        Schema::create('tbl_reply_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('review_id');
            $table->text('reply_content');
            $table->string('reply_author', 255);
            $table->string('reply_email', 255)->nullable();
            $table->datetime('reply_date');
            $table->boolean('approved')->default(false);
            $table->timestamps();

            $table->foreign('review_id')->references('id_review')->on('tbl_danhgiasp');
            $table->index(['review_id', 'approved']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_reply_reviews');
        Schema::dropIfExists('tbl_reply_comments_product');
        Schema::dropIfExists('tbl_reply_blog_comments');
    }
};
