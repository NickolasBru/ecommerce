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
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('category_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create the products table
        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('cover_img_url');
            $table->string('sku')->unique();
            $table->decimal('price', 10, 2);
            $table->integer('stock_quantity')->unsigned()->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('category_id')->index('prod_category_id_idx');
            $table->timestamps();

            $table->foreign('category_id')->references('category_id')->on('categories');
        });

        //pivot table to connect products and suppliers
        Schema::create('product_supplier', function (Blueprint $table) {
            $table->increments('productsupp_id');
            $table->unsignedInteger('product_id')->index('prodsupp_product_id_idx');
            $table->unsignedInteger('personsupplier_id')->index('prodsupp_personsupplier_id_idx');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_supplier');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};
