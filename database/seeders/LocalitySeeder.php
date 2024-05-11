<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use App\Models\Locality;

class LocalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $dataset = [
            [
                'postal_code' => 1860,
                'city' => 'Meise',
                'province' => 'Flemish Brabant',
                'population' => 19000,
                'adress' => 'Gemeenteplein, 1860 Meise, Belgique',
                'latitude' => 50.9359,
                'longitude' =>  4.3260,
                'description' => 'Meise is renowned for its National Botanic Garden, offering a tranquil escape with extensive plant collections and thematic gardens.',
                'language' =>  'Dutchh'

            ],
            [
                'postal_code' => 2290,
                'city' => 'Vorselaar',
                'province' => 'Antwerp',
                'population' => 8000,
                'adress' => 'Markt, 2290 Vorselaar, Belgium',
                'latitude' => 51.2021,
                'longitude' => 4.7775,
                'description' => 'Vorselaar, a small town in Antwerp, is notable for its Borrekens Castle surrounded by lush rhododendrons, especially vibrant in May.',
                'language' => 'Dutch'
            ],
            [
                'postal_code' => 1500,
                'city' => 'Halle',
                'province' => 'Flemish Brabant',
                'population' => 39000,
                'adress' => 'Leide, 1500 Halle, Belgium',
                'latitude' => 50.7338,
                'longitude' => 4.2345,
                'description' => 'Halle is renowned for the Hallerbos, also known as the Blue Forest, which attracts visitors with its enchanting bluebell bloom each April.',
                'language' => 'Dutch'
            ],
            [
                'postal_code' => 1000,
                'city' => 'Brussels',
                'province' => 'Brussels-Capital',
                'population' => 1200000,
                'adress' => 'Grand Place, 1000 Brussels, Belgium',
                'latitude' => 50.8467,
                'longitude' => 4.3524,
                'description' => 'Brussels, the capital of Belgium and the European Union, is a bustling metropolis with a rich history, vibrant cultural life, and numerous international institutions.',
                'language' => 'French, Dutch'
            ],
            [
                'postal_code' => 1700,
                'city' => 'Dilbeek',
                'province' => 'Flemish Brabant',
                'population' => 42000,
                'adress' => 'Gemeenteplein, 1700 Dilbeek, Belgium',
                'latitude' => 50.8476,
                'longitude' => 4.2597,
                'description' => 'Dilbeek, located just outside Brussels, is known for its green spaces and as a gateway for those commuting into the capital.',
                'language' => 'Dutch'
            ],
            [
                'postal_code' => 4750,
                'city' => 'Bütgenbach',
                'province' => 'Liege',
                'population' => 5500,
                'adress' => 'Marktplatz, 4750 Bütgenbach, Belgium',
                'latitude' => 50.4265,
                'longitude' => 6.2079,
                'description' => 'Bütgenbach is known for its reservoir lake, popular for water sports and surrounded by inviting hiking trails in the scenic Ardennes.',
                'language' => 'German'
            ],
            [
                'postal_code' => 4950,
                'city' => 'Waimes',
                'province' => 'Liege',
                'population' => 7000,
                'adress' => 'Rue du Centre, 4950 Waimes, Belgium',
                'latitude' => 50.4159,
                'longitude' => 6.1091,
                'description' => 'Waimes, located in the eastern part of Belgium, features beautiful landscapes of the High Fens and is a popular destination for outdoor enthusiasts.',
                'language' => 'French'
            ],
            [
                'postal_code' => 4845,
                'city' => 'Jalhay',
                'province' => 'Liege',
                'population' => 8000,
                'adress' => 'Place du Marché, 4845 Jalhay, Belgium',
                'latitude' => 50.5672,
                'longitude' => 5.9518,
                'description' => 'Jalhay is recognized for its rural charm and the surrounding natural landscapes, offering numerous outdoor recreational activities.',
                'language' => 'French'
            ],
            [
                "postal_code" => 1300,
                "city" => "Wavre",
                "province" => "Walloon Brabant",
                "population" => 34000,
                "adress" => "Place de l'Hôtel de Ville, 1300 Wavre, Belgium",
                "latitude" => 50.7172,
                "longitude" => 4.6121,
                "description" => "Wavre, the capital of the Walloon Brabant province, is known for its dynamic cultural life and historical sites, including the famous Walibi Belgium amusement park nearby, attracting visitors with thrilling rides and family-friendly attractions.",
                "language" => "French"
            ],
            [
                'postal_code' => 4960,
                'city' => 'Malmedy',
                'province' => 'Liege',
                'population' => 12000,
                'adress' => 'Place Albert 1er, 4960 Malmedy, Belgium',
                'latitude' => 50.4258,
                'longitude' => 6.0295,
                'description' => 'Malmedy, nestled in the High Fens region, is a vibrant cultural hub known for its folklore, music festivals, and stunning natural reserves.',
                'language' => 'French'
            ],
            [
                'postal_code' => 5561,
                'city' => 'Houyet',
                'province' => 'Namur',
                'population' => 4500,
                'adress' => 'Place de l Église, 5561 Houyet, Belgium',
                'latitude' => 50.1860,
                'longitude' => 5.0101,
                'description' => 'Houyet is a picturesque municipality in the province of Namur, known for its stunning natural beauty and opportunities for kayaking and hiking.',
                'language' => 'French'
            ],
            [
                'postal_code' => 6833,
                'city' => 'Bouillon',
                'province' => 'Luxembourg',
                'population' => 5400,
                'adress' => 'Esplanade Godefroy, 6833 Bouillon, Belgium',
                'latitude' => 49.7939,
                'longitude' => 5.0675,
                'description' => 'Bouillon is a historic town in Wallonia, famous for its medieval castle which was once home to Godefroy de Bouillon, a leader of the First Crusade.',
                'language' => 'French'
            ],
            [
                'postal_code' => 9120,
                'city' => 'Beveren',
                'province' => 'East Flanders',
                'population' => 48000,
                'adress' => 'Gravenplein, 9120 Beveren, Belgium',
                'latitude' => 51.2135,
                'longitude' => 4.2587,
                'description' => 'Beveren, a town in East Flanders, combines a rich history with modern development, featuring several castles and extensive parks.',
                'language' => 'Dutch'
            ],
            [
                'postal_code' => 9170,
                'city' => 'Sint-Gillis-Waas ',
                'province' => 'East Flanders',
                'population' => 18400,
                'adress' => 'Kerkstraat, 9170 Sint-Gillis-Waas, Belgique',
                'latitude' => 51.2526,
                'longitude' =>  4.1170,
                'description' => 'Sint-Gillis-Waas, set in East Flanders, offers a peaceful rural setting with extensive agricultural lands and natural beauty.',
                'language' =>  'Dutchh'

            ],
            [
                'postal_code' => 3500,
                'city' => 'Hasselt ',
                'province' => 'Limburg',
                'population' => 77000,
                'adress' => 'Groenplein, 3500 Hasselt, Belgique',
                'latitude' => 50.9306,
                'longitude' =>  5.3378,
                'description' => 'Capital of the province of Limburg and known for Jenever, a gin made locally.',
                'language' =>  'Dutch, English'

            ],
            [
                'postal_code' => 3720,
                'city' => 'Kortessem',
                'province' => 'Limburg',
                'population' => 8000,
                'adress' => 'Kerkplein, 3720 Kortessem, Belgium',
                'latitude' => 50.8606,
                'longitude' => 5.3881,
                'description' => 'Kortessem, a small town in Limburg, is appreciated for its quiet, rural charm and historic sites scattered across the village centers.',
                'language' => 'Dutch'
            ],
            [
                'postal_code' => 2650,
                'city' => 'Edegem',
                'province' => 'Antwerp',
                'population' => 21527,
                'adress' => 'Gemeenteplein, 2650 Edegem, Belgium',
                'latitude' => 51.1570,
                'longitude' => 4.4386,
                'description' => 'Edegem, a suburban town near Antwerp, is known for its rich history and green spaces, offering residents and visitors a peaceful community with close proximity to urban amenities.',
                'language' => 'Dutch'
            ],
            [
                'postal_code' => 3840,
                'city' => 'Borgloon',
                'province' => 'Limburg',
                'population' => 10800,
                'adress' => 'Speelhof, 3840 Borgloon, Belgium',
                'latitude' => 50.8039,
                'longitude' => 5.3470,
                'description' => 'Borgloon is a historic city in Limburg, famous for its fruit production and picturesque landscapes, making it a popular destination for hikers and cultural tourists.',
                'language' => 'Dutch'
            ],
            [
                'postal_code' => 2880,
                'city' => 'Bornem',
                'province' => 'Antwerp',
                'population' => 21069,
                'adress' => 'Kardinaal Cardijnplein, 2880 Bornem, Belgium',
                'latitude' => 51.0953,
                'longitude' => 4.2336,
                'description' => 'Bornem, nestled on the banks of the Scheldt River, is known for its medieval castle and vibrant community events, attracting visitors with its scenic natural surroundings and active cultural life.',
                'language' => 'Dutch'
            ],
        ];

        foreach ($dataset as $data) {
            Locality::updateOrCreate(
                ['postal_code' => trim($data['postal_code'])],
                $data
            );
        }
    }
}
