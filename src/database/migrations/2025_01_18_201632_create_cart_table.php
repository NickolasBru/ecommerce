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
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('cart_id');
            $table->unsignedInteger('person_id')->index('cart_person_id_idx');
            $table->timestamps();

            $table->foreign('person_id')->references('person_id')->on('person');
        });

        Schema::create('cart_items', function (Blueprint $table) {
            $table->increments('cartitems_id');
            $table->unsignedInteger('cart_id')->index('cartite_cart_id_idx');
            $table->unsignedInteger('product_id')->index('cartite_prod_id_idx');
            $table->integer('quantity')->unsigned();
            $table->timestamps();

            $table->foreign('cart_id')->references('cart_id')->on('carts');
            $table->foreign('product_id')->references('product_id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
    }
};
