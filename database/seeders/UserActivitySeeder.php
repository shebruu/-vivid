<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\UserActivity;

use Carbon\Carbon;

class UserActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        $start = Carbon::now();
        $end = $start->copy()->addHour(2);

        $tripDisponibility = 10; 
        */
        $userActivities = [
            [
                'activity_id' => 1,
                'created_by' => 1,
                'trip_id' => 1,
                'place_id' => 3,
                'duration' => 4,
                'status' => 'validated',
                'start_time' => Carbon::create(2024, 6, 12, 5, 0, 0),

            ],

            [
                'activity_id' => 6,
                'created_by' => 1,
                'trip_id' => 1,
                'place_id' => 4,
                'duration' => 4,
                'status' => 'validated',
                'start_time' => Carbon::create(2024, 7, 12, 5, 0, 0),

            ],
            [
                'activity_id' => 1,
                'created_by' => 1,
                'trip_id' => 2,
                'place_id' => 2,
                'duration' => 4,
                'status' => 'validated',
                'start_time' => Carbon::create(2024, 7, 12, 5, 0, 0),

            ],




            [
                'activity_id' => 4,
                'created_by' => 1,
                'trip_id' => 1,
                'place_id' => 5,
                'duration' => 4,
                'status' => 'validated',


            ],
            [
                'activity_id' => 7,
                'created_by' => 1,
                'trip_id' => 1,
                'place_id' => 6,
                'duration' => 4,
                'status' => 'validated',

            ],
            [
                'activity_id' => 6,
                'created_by' => 1,
                'trip_id' => 1,
                'place_id' => 7,
                'duration' => 4,
                'status' => 'validated',

            ],
            [
                'activity_id' => 2,
                'created_by' => 1,
                'trip_id' => 1,
                'place_id' => 8,
                'duration' => 4,
                'status' => 'validated',

            ],
            [
                'activity_id' => 4,
                'created_by' => 1,
                'trip_id' => 1,
                'place_id' => 9,
                'duration' => 4,
                'status' => 'validated',

            ],
            [
                'activity_id' => 1,
                'created_by' => 1,
                'trip_id' => 1,
                'place_id' => 15,
                'duration' => 4,
                'status' => 'validated',

            ],
            [
                'activity_id' => 6,
                'created_by' => 1,
                'trip_id' => 1,
                'place_id' => 19,
                'duration' => 4,
                'status' => 'validated',

            ],
            [
                'activity_id' => 1,
                'created_by' => 1,
                'trip_id' => 1,
                'place_id' => 20,
                'duration' => 4,
                'status' => 'validated',

            ],



        ];

        // Insertion des données dans la table user_activities
        foreach ($userActivities as $userActivity) {
            UserActivity::create($userActivity);
        }
    }
}
