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
        Schema::create('tbl_coupon', function (Blueprint $table) {
            $table->id('coupon_id');
            $table->string('coupon_name', 255);
            $table->string('coupon_code', 50)->unique();
            $table->integer('coupon_number');
            $table->tinyInteger('coupon_condition'); // 1=fixed amount, 2=percentage
            $table->decimal('coupon_value', 10, 2);
            $table->datetime('coupon_start_time');
            $table->datetime('coupon_end_time');
            $table->boolean('coupon_status')->default(true);
            $table->text('coupon_desc')->nullable();
            $table->timestamps();

            $table->index(['coupon_code', 'coupon_status']);
            $table->index(['coupon_start_time', 'coupon_end_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_coupon');
    }
};
