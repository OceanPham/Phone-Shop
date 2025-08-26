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
        Schema::create('tbl_vnpay_transaction', function (Blueprint $table) {
            $table->id();
            $table->decimal('vnp_Amount', 15, 2);
            $table->string('vnp_BankCode', 20)->nullable();
            $table->string('vnp_BankTranNo', 255)->nullable();
            $table->string('vnp_CardType', 20)->nullable();
            $table->text('vnp_OrderInfo');
            $table->datetime('vnp_PayDate')->nullable();
            $table->string('vnp_ResponseCode', 10);
            $table->string('vnp_TmnCode', 20);
            $table->string('vnp_TransactionNo', 255)->nullable();
            $table->string('vnp_TransactionStatus', 10);
            $table->string('vnp_TxnRef', 255);
            $table->string('vnp_SecureHashType', 20)->nullable();
            $table->text('vnp_SecureHash')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('tbl_order');
            $table->index(['vnp_TxnRef', 'vnp_ResponseCode']);
            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_vnpay_transaction');
    }
};
