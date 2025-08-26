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
        Schema::create('tbl_order_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idsanpham');
            $table->unsignedBigInteger('iddonhang');
            $table->integer('soluong');
            $table->decimal('dongia', 10, 2);
            $table->string('tensp', 255); // Store product name at time of order
            $table->string('hinhanh', 255)->nullable(); // Store product image at time of order
            $table->unsignedBigInteger('ma_danhmuc')->nullable();
            $table->timestamps();

            $table->foreign('idsanpham')->references('masanpham')->on('tbl_sanpham');
            $table->foreign('iddonhang')->references('id')->on('tbl_order')->onDelete('cascade');
            $table->foreign('ma_danhmuc')->references('ma_danhmuc')->on('tbl_danhmuc');

            $table->index(['iddonhang', 'idsanpham']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_order_detail');
    }
};
