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
        Schema::create('person_customer', function (Blueprint $table) {
            $table->increments('personcustomer_id');
            $table->unsignedInteger('person_id')->index('perscust_person_id_idx');
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('order_count')->unsigned()->default(0);
            $table->timestamps();
            $table->foreign('person_id')->references('person_id')->on('person');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_customer');
    }
};
