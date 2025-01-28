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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('order_id');
            $table->unsignedInteger('personcustomer_id')->index('orders_personcustomer_id_idx');
            $table->integer('status'); //1 - pending, 2 - Processing, 3 - Shipped, 4- completed, 5-canceled
            $table->decimal('total_price', 10, 2);
            $table->timestamps();

            $table->foreign('personcustomer_id')->references('personcustomer_id')->on('person_customer');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('orderitem_id');
            $table->unsignedInteger('order_id')->index('orderitems_order_id_idx');
            $table->unsignedInteger('product_id')->index('orderitems_prod_id_idx');
            $table->integer('quantity')->unsigned();
            $table->decimal('price', 10, 2);
            $table->timestamps();

            $table->foreign('order_id')->references('order_id')->on('orders');
            $table->foreign('product_id')->references('product_id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_payments');
        Schema::dropIfExists('orders_shipments');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
