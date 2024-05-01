<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;
use App\Models\Place;
use App\Models\Locality;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {



        $places = [
            [
                'adress' => 'Nieuwelaan 38',
                'title' => 'Tropical spring',
                'postal_code' => 1860,
                'description' => 'Immerse yourself in the tropical atmosphere of the Jardin Botanique de Meise, where Tropical Spring awakens your senses. Discover an exotic and colorful collection of flora in a peaceful setting, ideal for a nature getaway or an inspiring photo shoot.',
                'latitude' => 50.935173,
                'longitude' => 4.326897,
                'city' => 'Meise',
            ],
            [
                'adress' => 'Vispluk 3',
                'title' => 'Borrekens castle',
                'postal_code' => 2290,
                'description' => 'Discover the historic splendor of Borrekens Castle, an architectural gem nestled in the Flemish landscape. Admiring the rhododendrons in bloom provides a spectacular backdrop for history and nature lovers in spring.',
                'latitude' => 51.201969,
                'longitude' => 4.774036,
                'city' => 'Vorselaar',
            ],
            [
                'adress' => 'Hogebermweg',
                'title' => 'Hallerbos',
                'postal_code' => 1500,
                'description' => 'Visit Hall Wood and witness the  Purple Magic as the undergrowth transforms into an enchanted carpet of wild hyacinths. This seasonal wonder attracts photographers and walkers in search of natural beauty in the heart of the Halle Forest.',
                'latitude' => 50.733847,
                'longitude' => 4.290785,
                'city' => 'Halle',
            ],
            [
                'adress' => 'Av. du Parc Royal 61',
                'title' => 'Royal greenhouses at Laeken',
                'postal_code' => 1020,
                'description' => 'Explore the Serres Royales de Laeken, a series of monumental greenhouses housing an impressive collection of rare plants and exotic flowers. A must-see for lovers of botany and historic architecture.',
                'latitude' => 50.883722,
                'longitude' => 4.360215,
                'city' => 'Brussels',
            ],
            [
                'adress' => 'Isidoor van Beverenstraat 5',
                'title' => 'Grand Bigard Castle',
                'postal_code' => 1702,
                'description' => 'Immerse yourself in medieval times at Château du Grand Bigard, where history meets tranquility. Explore its meticulously tended gardens and preserved architecture for an enriching cultural and visual experience.',
                'latitude' => 50.872775,
                'longitude' => 4.267495,
                'city' => 'Dilbeek',
            ]
        ];

        foreach ($places as $place) {

            $locality = Locality::firstWhere('city', $place['city']);

            if (!$locality) {
                //si aucune correspondance de localité
                //  $locality = Locality::create(['city' => $place['city']]);
                Log::warning("Localité non trouvée pour la ville : " . $place['city']);
                continue;
            }
            unset($place['city']);
            Place::updateOrCreate(
                ['adress' => $place['adress'], 'postal_code' => $place['postal_code']],
                array_merge($place, ['locality_id' => $locality->id])
            );
        }
    }
}
