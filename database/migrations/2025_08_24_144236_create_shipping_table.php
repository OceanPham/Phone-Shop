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
        Schema::create('tbl_shipping', function (Blueprint $table) {
            $table->id('shipping_id');
            $table->string('shipping_name', 255);
            $table->text('shipping_address');
            $table->string('shipping_phone', 20);
            $table->string('shipping_email', 255);
            $table->text('shipping_notes')->nullable();
            $table->unsignedBigInteger('iduser');
            $table->timestamps();

            $table->foreign('iduser')->references('id')->on('tbl_nguoidung');
            $table->index('iduser');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_shipping');
    }
};
