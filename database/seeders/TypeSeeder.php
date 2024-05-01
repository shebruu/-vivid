<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataset = [
            [
                'type' => 'Aventure ',
                'description' => 'Challenging and exciting activities, ideal for those seeking to experience thrills and explore new horizons in wilderness or urban environments. ',

            ],
            [
                'type' => 'Gastronomie ',
                'description' => 'Culinary experiences that allow you to discover local and regional flavors through traditional dishes, wine tastings, and visits to markets and producers. ',

            ],
            [
                'type' => 'Culture ',
                'description' => 'Explore the historical, artistic and social heritage of a region through its museums, art galleries, shows and historic sites. ',

            ],
            [
                'type' => 'Urbain ',
                'description' => 'Discover urban spaces, including shopping, visits to iconic neighborhoods, architecture, nightlife and urban events. ',

            ],
            [
                'type' => 'Bien-etre/détente ',
                'description' => 'Activities focused on relaxation and self-care, including spas, yoga retreats, tranquil nature walks, and mental and physical wellness experiences. ',

            ],
            [
                'type' => 'Luxe',
                'description' => 'Upscale experiences offering exceptional comfort and service, often combined with luxury accommodations, cruises, exclusive boutiques, and personalized services. ',

            ],
            [
                'type' => 'ecouturism ',
                'description' => 'Responsible tourism activities that seek to minimize environmental impact, while contributing to environmental conservation and the well-being of local populations. ',

            ],

        ];
        foreach ($dataset as $data) {
            Type::updateOrCreate(
                ['type' => trim($data['type'])],
                $data
            );
        }
    }
}
