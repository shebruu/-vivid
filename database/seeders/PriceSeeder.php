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
        DB::table('prices')->insert(
            [
                [
                    'amount' => 10.99,
                    'age_rang' => 'adult',
                    'status' => 'active',
                    'season' => 'summer',
                    'day_type' => 'weekday',

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

                    'place_id' => 2,
                    'user_id' => 2,

                ],

                [
                    'amount' => 35,
                    'age_rang' => 'student',
                    'status' => 'active',
                    'season' => 'all',
                    'day_type' => 'all',

                    'place_id' => 20,
                    'user_id' => 1,

                ],
                [
                    'amount' => 20,
                    'age_rang' => 'child',
                    'status' => 'active',
                    'season' => 'all',
                    'day_type' => 'all',

                    'place_id' => 20,
                    'user_id' => 1,

                ],
                [
                    'amount' => 10.99, // Prix de base pour adulte en semaine
                    'age_rang' => 'adult',
                    'status' => 'active',
                    'season' => 'summer',
                    'day_type' => 'weekday',

                    'place_id' => 20,
                    'user_id' => 1,

                ],
                [
                    'amount' => 20.99, // Prix augmenté pour le weekend
                    'age_rang' => 'adult',
                    'status' => 'active',
                    'season' => 'summer',
                    'day_type' => 'weekend',

                    'place_id' => 20,
                    'user_id' => 1,

                ],
            ]
        );
    }
}
