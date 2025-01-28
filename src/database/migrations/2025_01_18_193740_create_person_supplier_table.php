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
        Schema::create('person_supplier', function (Blueprint $table) {
            $table->increments('personsupplier_id');
            $table->unsignedInteger('person_id')->index('perscust_person_id_idx');
            $table->string('company_name');
            $table->string('vat_number');
            $table->integer('products_count')->unsigned()->default(0);
            $table->timestamps();
            $table->foreign('person_id')->references('person_id')->on('person');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_supplier');
    }
};
