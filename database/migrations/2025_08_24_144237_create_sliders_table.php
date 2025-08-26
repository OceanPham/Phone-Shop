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
        Schema::create('tbl_slider', function (Blueprint $table) {
            $table->id('slider_id');
            $table->string('slider_name', 255);
            $table->string('slider_image', 255);
            $table->string('slider_url', 255)->nullable();
            $table->datetime('date_create');
            $table->boolean('slider_status')->default(true);
            $table->timestamps();

            $table->index(['slider_status', 'date_create']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_slider');
    }
};
