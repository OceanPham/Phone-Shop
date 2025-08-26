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
        Schema::create('tbl_danhgiasp', function (Blueprint $table) {
            $table->id('id_review');
            $table->unsignedBigInteger('iduser');
            $table->unsignedBigInteger('idsanpham');
            $table->text('images_review')->nullable();
            $table->text('noidung');
            $table->decimal('rating_star', 2, 1);
            $table->datetime('date_create');
            $table->unsignedBigInteger('iddonhang');
            $table->boolean('trangthai_review')->default(false);
            $table->timestamps();

            $table->foreign('iduser')->references('id')->on('tbl_nguoidung');
            $table->foreign('idsanpham')->references('masanpham')->on('tbl_sanpham')->onDelete('cascade');
            $table->foreign('iddonhang')->references('id')->on('tbl_order');
            $table->index(['idsanpham', 'rating_star']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_danhgiasp');
    }
};
