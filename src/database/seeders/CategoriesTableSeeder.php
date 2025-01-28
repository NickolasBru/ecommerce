<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Electronics', 'description' => 'Devices and gadgets'],
            ['name' => 'Books', 'description' => 'Books and literature'],
            ['name' => 'Clothing', 'description' => 'Apparel and fashion items'],
            ['name' => 'Home & Kitchen', 'description' => 'Home appliances and kitchenware'],
            ['name' => 'Sports', 'description' => 'Sports equipment and accessories'],
        ];

        DB::table('categories')->insert($categories);
    }
}
