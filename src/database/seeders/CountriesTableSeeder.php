<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            ['code' => 'US', 'name' => 'United States'],
            ['code' => 'BR', 'name' => 'Brazil'],
            ['code' => 'CA', 'name' => 'Canada'],
            ['code' => 'FR', 'name' => 'France'],
            ['code' => 'DE', 'name' => 'Germany'],
        ];

        DB::table('countries')->insert($countries);
    }
}
