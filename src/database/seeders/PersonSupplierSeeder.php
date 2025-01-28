<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PersonSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('person_supplier')->insert([
            [
                'person_id' => 1,
                'company_name' => 'Tech Supplies Inc.',
                'vat_number' => Str::random(10),
                'products_count' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'person_id' => 2,
                'company_name' => 'Global Traders Ltd.',
                'vat_number' => Str::random(10),
                'products_count' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
