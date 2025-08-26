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
        Schema::create('tbl_danhmuc', function (Blueprint $table) {
            $table->id('ma_danhmuc'); // Keep original field name for compatibility
            $table->string('ten_danhmuc', 255);
            $table->string('hinh_anh', 255)->nullable();
            $table->text('mo_ta')->nullable();
            $table->timestamps();

            $table->index('ten_danhmuc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_danhmuc');
    }
};
