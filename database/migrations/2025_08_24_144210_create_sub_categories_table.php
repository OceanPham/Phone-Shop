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
        Schema::create('tbl_danhmuc_phu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('iddm'); // parent category id
            $table->string('ten_danhmucphu', 255);
            $table->text('mo_ta')->nullable();
            $table->timestamps();

            $table->foreign('iddm')->references('ma_danhmuc')->on('tbl_danhmuc')->onDelete('cascade');
            $table->index(['iddm', 'ten_danhmucphu']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_danhmuc_phu');
    }
};
