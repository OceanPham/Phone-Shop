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
        Schema::create('tbl_banner', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->unsignedBigInteger('idsp')->nullable();
            $table->string('images', 255)->nullable();
            $table->text('noi_dung')->nullable();
            $table->datetime('date_create');
            $table->text('info')->nullable();
            $table->timestamps();

            $table->foreign('idsp')->references('masanpham')->on('tbl_sanpham');
            $table->index('idsp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_banner');
    }
};
