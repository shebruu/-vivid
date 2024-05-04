<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use Illuminate\Support\Facades\DB;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('prices')->insert([
            [
                'amount' => 10.99,
                'age_rang' => 'adult',
                'status' => 'active',
                'season' => 'summer',
                'day_type' => 'weekday',
                'activity_id' => 1,
                'place_id' => 1,
                'user_id' => 1,
                /*
                'created_at' => now(),
                'updated_at' => now()
                */
            ],
            [
                'amount' => 15.50,
                'age_rang' => 'adult',
                'status' => 'inactive',
                'season' => 'winter',
                'day_type' => 'weekend',
                'activity_id' => 2,
                'place_id' => 2,
                'user_id' => 2,

            ]

        ]);
    }
}
