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
            ],
            [
                'adress' => 'Jonkersaard 41',
                'title' => 'Park Romeinse Put',
                'postal_code' => 2650,
                'description' => 'Explore the natural beauty of Park Romeinse Put, a serene landscape ideal for leisurely walks and relaxation in Edegem.',
                'latitude' => 51.155,
                'longitude' => 4.437,
                'city' => 'Edegem',
            ],
            [
                'adress' => 'Gouverneur Verwilghensingel 15',
                'title' => 'Japanese Garden Hasselt',
                'postal_code' => 3500,
                'description' => 'Experience tranquility at the Japanese Garden in Hasselt, which offers a peaceful retreat with its traditional Japanese landscaping.',
                'latitude' => 50.9307,
                'longitude' => 5.3378,
                'city' => 'Hasselt',
            ],

            [
                'adress' => 'Opeindestraat 94',
                'title' => 'Haspengouw per fiets',
                'postal_code' => 3720,
                'description' => 'Cycle through the scenic routes of Haspengouw, enjoying the lush landscapes and vibrant local culture.',
                'latitude' => 50.8612,
                'longitude' => 5.3889,
                'city' => 'Kortessem',
            ],
            [
                'adress' => 'Oude Truierbaan 30',
                'title' => 'Hartig Haspengouw',
                'postal_code' => 3840,
                'description' => 'Savor the flavors of the region at Hartig Haspengouw, where local cuisine meets the rich agricultural heritage of Borgloon.',
                'latitude' => 50.8027,
                'longitude' => 5.3482,
                'city' => 'Borgloon',
            ],

            [
                'adress' => 'Avenue du Parc Royal 61',
                'title' => 'Royal Greenhouses of Laeken',
                'postal_code' => 1020,
                'description' => 'Discover a stunning collection of plants and flowers from around the world in the historic Royal Greenhouses of Laeken.',
                'latitude' => 50.8924,
                'longitude' => 4.3625,
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
            ], [
                'adress' => 'Zwarte Dreef 2',
                'title' => 'Château Cortewalle',
                'postal_code' => 9120,
                'description' => 'Visit Château Cortewalle for a serene and quiet experience amidst historical architecture surrounded by nature.',
                'latitude' => 51.2135,
                'longitude' => 4.256,
                'city' => 'Beveren',
            ],
            [
                'adress' => 'Hof ter Saksendreef 2',
                'title' => 'Hof ter Saksen',
                'postal_code' => 9120,
                'description' => 'Enjoy a beautiful view and adventurous experiences at Hof ter Saksen, a place that combines natural beauty with engaging activities.',
                'latitude' => 51.2135,
                'longitude' => 4.256,
                'city' => 'Beveren',
            ],
            [
                'adress' => '2880 Bornem',
                'title' => 'Buitenland',
                'postal_code' => 2880,
                'description' => 'Explore the charming and quaint atmosphere of Buitenland, a local favorite for relaxing outings and picturesque landscapes.',
                'latitude' => 51.0975,
                'longitude' => 4.234,
                'city' => 'Bornem',
            ],
            [
                'adress' => 'Kasteelstraat 34',
                'title' => 'Castle Marnix de Sainte-Aldegonde',
                'postal_code' => 2880,
                'description' => 'Step back in time at the Castle Marnix de Sainte-Aldegonde, where history and architecture blend to create a memorable visit.',
                'latitude' => 51.0975,
                'longitude' => 4.234,
                'city' => 'Bornem',
            ],
            [
                'adress' => '4960 Malmedy',
                'title' => 'Hautes Fagnes – Eifel Nature Park',
                'postal_code' => 4960,
                'description' => 'Experience the great outdoors at the Hautes Fagnes – Eifel Nature Park, a haven for walkers and photographers alike.',
                'latitude' => 50.4845,
                'longitude' => 6.0315,
                'city' => 'Malmedy',
            ],
            [
                'adress' => '4845 Jalhay',
                'title' => 'La Statte stream',
                'postal_code' => 4845,
                'description' => 'Discover the historical rocks and the vibrant stream at La Statte, a site filled with natural beauty and historical significance.',
                'latitude' => 50.5675,
                'longitude' => 5.9635,
                'city' => 'Jalhay',
            ],
            [
                'adress' => 'Hohe Mark',
                'title' => 'Le Rocher du Bieley',
                'postal_code' => 4750,
                'description' => 'Capture breathtaking views and explore the heights at Le Rocher du Bieley, perfect for photography enthusiasts and nature lovers.',
                'latitude' => 50.4331,
                'longitude' => 6.2289,
                'city' => 'Bütgenbach',
            ],
            [
                'adress' => 'Rue de Bosfagne 11-7',
                'title' => 'Reinstrand Waterfall',
                'postal_code' => 4950,
                'description' => 'Enjoy a scenic walk to the Reinstrand Waterfall, a captivating natural attraction where the river cascades beautifully into the basin below.',
                'latitude' => 50.4201,
                'longitude' => 6.1638,
                'city' => 'Waimes',
            ],
            [
                'adress' => '4950 Malmedy',
                'title' => 'Cascade du Bayehon',
                'postal_code' => 4950,
                'description' => 'Witness the stunning beauty of the Cascade du Bayehon, a waterfall that is a favorite among those who appreciate the tranquility of nature.',
                'latitude' => 50.4201,
                'longitude' => 6.1638,
                'city' => 'Malmedy',
            ],
            [
                'adress' => 'Boulevard de l Europe 100',
                'title' => 'Walibi',
                'postal_code' => 1300,
                'description' => 'Discover the  amusement park designed by Belgian businessman Eddy Meeùs and inaugurated on July 26, 1975',
                'latitude' => 51.201969,
                'longitude' => 4.774036,
                'city' => 'Wavre',
            ],

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
