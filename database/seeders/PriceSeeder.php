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
                // Tropical Spring
                $this->createPriceEntry(1, 12.50, 'adult', 'all', 'weekday', 1),
                $this->createPriceEntry(1, 8.00, 'child', 'all', 'weekday', 1),

                // Borrekens castle
                $this->createPriceEntry(2, 15.00, 'adult', 'all', 'weekend', 1),
                $this->createPriceEntry(2, 10.00, 'child', 'all', 'weekend', 1),

                // Hallerbos
                $this->createPriceEntry(3, 5.00, 'adult', 'spring', 'all', 1),
                $this->createPriceEntry(3, 0.00, 'child', 'spring', 'all', 1),

                // Royal greenhouses at Laeken
                $this->createPriceEntry(4, 18.00, 'adult', 'all', 'weekday', 1),
                $this->createPriceEntry(4, 10.00, 'child', 'all', 'weekday', 1),

                // Grand Bigard Castle
                $this->createPriceEntry(5, 20.00, 'adult', 'all', 'weekend', 1),
                $this->createPriceEntry(5, 12.00, 'child', 'all', 'weekend', 1),

                // Park Romeinse Put
                $this->createPriceEntry(6, 7.00, 'adult', 'all', 'all', 1),
                $this->createPriceEntry(6, 3.50, 'child', 'all', 'all', 1),

                // Japanese Garden Hasselt
                $this->createPriceEntry(7, 15.00, 'adult', 'all', 'all', 1),
                $this->createPriceEntry(7, 5.00, 'child', 'all', 'all', 1),

                // Haspengouw per fiets
                $this->createPriceEntry(8, 20.00, 'adult', 'summer', 'weekend', 1),
                $this->createPriceEntry(8, 15.00, 'child', 'summer', 'weekend', 1),

                // Hartig Haspengouw
                $this->createPriceEntry(9, 25.00, 'adult', 'all', 'all', 1),
                $this->createPriceEntry(9, 15.00, 'child', 'all', 'all', 1),

                // More places...
            ]
        );
    }

    private function createPriceEntry($placeId, $amount, $ageRang, $season, $dayType, $userId)
    {
        return [
            'amount' => $amount,
            'age_rang' => $ageRang,
            'status' => 'active',
            'season' => $season,
            'day_type' => $dayType,
            'place_id' => $placeId,
            'user_id' => $userId,
        ];
    }
}
