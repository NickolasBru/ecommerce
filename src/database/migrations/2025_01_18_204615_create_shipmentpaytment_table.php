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
        // Create the shipments table
        Schema::create('order_shipments', function (Blueprint $table) {
            $table->increments('ordershipment_id');
            $table->unsignedInteger('order_id')->index('ordershipments_order_id_idx');
            $table->integer('status'); //1-Pending, 2-Processing, 3-sent, 4-delivered, 5-delayed;
            $table->string('carrier')->nullable();
            $table->string('tracking_number')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('order_id')->on('orders');
        });

        // Create the payments table
        Schema::create('order_payments', function (Blueprint $table) {
            $table->increments('orderpayment_id');
            $table->unsignedInteger('order_id')->index('orderpayments_order_id_idx');
            $table->integer('status'); //1-Pending, 2-Processing, 3-done, 4 - canceled;
            $table->string('method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('order_id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_payments');
        Schema::dropIfExists('orders_shipments');
    }
};
