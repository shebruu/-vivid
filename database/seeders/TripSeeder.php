<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Trip;
use Illuminate\Support\Str;


use Carbon\Carbon;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $today = Carbon::now();
        $departure = $today->copy()->addDays(2);
        //le titre pt etre modifié sans impacter le slug 

        $trips = [

            [
                'id' => 1,
                'title' => 'Girls Trip',

                'departure' => Carbon::parse('2024-02-02'), // Convertit la date en objet Carbon
                'arrival' => Carbon::parse('2024-02-24'),
                'totalestimation' => 500,
                'note' => 'A short break in Brussels to explore the city and its attractions.',
                'created_by' => 1,
            ],

            [
                'id' => 2,
                'title' => null,

                'departure' => $departure,
                'arrival' => $departure->copy()->addDays(5),
                'totalestimation' => 600,
                'note' => 'An exciting getaway with friends to enjoy the city and its nightlife.',
                'created_by' => 2,
            ],

            [
                'id' => 3,
                'title' => 'Gang Only',
                'departure' => Carbon::parse('2024-02-02'),
                'arrival' => Carbon::parse('2024-02-29'),
                'totalestimation' => 800,
                'note' => null,
                'created_by' => 1,
            ],
        ];


        foreach ($trips as $tripData) {
            // default value
            $title = $tripData['title'] ?? 'Trip';

            // // If the trip exists, update the data without changing the slug or the title
            $slug = Str::slug($title);


            // Search for existing trip by ID
            $existingTrip = Trip::find($tripData['id']);

            // If the trip exists, update the data without changing the slug or creating new recording
            if ($existingTrip) {
                $existingTrip->update($tripData);
            } else {
                // if trip doesnt exists, create a new trip with the generated title and slug.
                $tripData['slug'] = $slug;
                Trip::create($tripData);
            }
        }
    }
}
