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
        Schema::create('tbl_comment', function (Blueprint $table) {
            $table->id('ma_binhluan');
            $table->text('noi_dung');
            $table->unsignedBigInteger('ma_sanpham');
            $table->unsignedBigInteger('ma_nguoidung');
            $table->boolean('duyet')->default(false);
            $table->datetime('ngay_binhluan');
            $table->timestamps();

            $table->foreign('ma_sanpham')->references('masanpham')->on('tbl_sanpham')->onDelete('cascade');
            $table->foreign('ma_nguoidung')->references('id')->on('tbl_nguoidung');
            $table->index(['ma_sanpham', 'duyet']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_comment');
    }
};
