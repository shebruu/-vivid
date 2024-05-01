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
                'place_id' => 3,
                'duration' => 4,
                'status' => 'proposed',
                'start_time' => Carbon::create(2024, 6, 12, 5, 0, 0),

            ],

            [
                'activity_id' => 6,
                'created_by' => 1,
                'place_id' => 4,
                'duration' => 4,
                'status' => 'proposed',
                'start_time' => Carbon::create(2024, 7, 12, 5, 0, 0),

            ],
            [
                'activity_id' => 4,
                'created_by' => 1,
                'place_id' => 2,
                'duration' => 4,
                'status' => 'proposed',
                'start_time' => Carbon::create(2024, 7, 12, 5, 0, 0),

            ],
        ];

        // Insertion des données dans la table user_activities
        foreach ($userActivities as $userActivity) {
            UserActivity::create($userActivity);
        }
    }
}
