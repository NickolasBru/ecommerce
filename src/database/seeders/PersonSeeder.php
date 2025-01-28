<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('person')->insert([
            [
                'user_id' => 1,
                'tp_person' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'tp_person' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'tp_person' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
