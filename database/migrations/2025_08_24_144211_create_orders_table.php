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
        Schema::create('tbl_order', function (Blueprint $table) {
            $table->id();
            $table->string('madonhang', 255)->unique();
            $table->decimal('tongdonhang', 10, 2);
            $table->string('pttt', 50); // Payment method
            $table->unsignedBigInteger('iduser');
            $table->string('name', 255);
            $table->string('dienThoai', 11);
            $table->text('address');
            $table->text('ghichu')->nullable();
            $table->datetime('timeorder');
            $table->tinyInteger('trangthai')->default(1); // 1-6 status
            $table->boolean('thanhtoan')->default(false);
            $table->string('coupon_code', 25)->nullable();
            $table->decimal('shipping_fee', 8, 2)->default(0);
            $table->decimal('vat_fee', 8, 2)->default(0);
            $table->string('email', 255)->nullable();
            $table->timestamps();

            $table->foreign('iduser')->references('id')->on('tbl_nguoidung');
            $table->index(['iduser', 'trangthai']);
            $table->index('madonhang');
            $table->index('timeorder');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_order');
    }
};
