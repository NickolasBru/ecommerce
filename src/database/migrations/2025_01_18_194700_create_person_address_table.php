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
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('country_id');
            $table->string('code', 2)->unique(); // ISO 3166-1 alpha-2 country code
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('person_address', function (Blueprint $table) {
            $table->increments('personaddress_id');
            $table->unsignedInteger('person_id')->index('pers_person_id_idx');
            $table->integer('tp_address'); //1-billing, 2-shipping, 3-other
            $table->string('street');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('postal_code');
            $table->unsignedInteger('country_id')->index('pers_contry_id_idx');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
            $table->foreign('person_id')->references('person_id')->on('person');
            $table->foreign('country_id')->references('country_id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_address');
        Schema::dropIfExists('countries');
    }
};
