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
        Schema::create('tbl_sanpham', function (Blueprint $table) {
            $table->id('masanpham'); // Keep original field name
            $table->string('tensp', 255);
            $table->decimal('don_gia', 10, 2);
            $table->integer('ton_kho')->default(0);
            $table->text('images')->nullable(); // Comma-separated images
            $table->decimal('giam_gia', 5, 2)->default(0); // Discount percentage
            $table->datetime('ngay_nhap');
            $table->text('mo_ta')->nullable(); // Short description
            $table->text('information')->nullable(); // Detailed specs
            $table->unsignedBigInteger('ma_danhmuc');
            $table->unsignedBigInteger('id_dmphu')->nullable();
            $table->boolean('promote')->default(false);
            $table->boolean('dac_biet')->default(false); // Featured product
            $table->integer('so_luot_xem')->default(0);
            $table->timestamps();

            $table->foreign('ma_danhmuc')->references('ma_danhmuc')->on('tbl_danhmuc');
            $table->foreign('id_dmphu')->references('id')->on('tbl_danhmuc_phu');

            $table->index(['ma_danhmuc', 'dac_biet']);
            $table->index(['tensp', 'don_gia']);
            $table->index('so_luot_xem');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_sanpham');
    }
};
