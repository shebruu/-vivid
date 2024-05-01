<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Photo;
use App\Models\Place;
use Illuminate\Support\Facades\File;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $places = Place::all();

        foreach ($places as $place) {
            // chemin du dossier d'images pour cette place
            $imageFolderPath = public_path('images/' . $place->title);


            if (File::isDirectory($imageFolderPath)) {

                $images = File::allFiles($imageFolderPath);

                // Parcours de chaque image
                foreach ($images as $image) {
                    // obtenir uniquement le nom du fichier sans le chemin d'accès
                    $fileName = $image->getFilename();

                    Photo::create([
                        'url' => $fileName,
                        'place_id' => $place->id,
                    ]);
                }
            }
        }
    }
}
