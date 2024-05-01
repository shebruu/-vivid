<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use App\Models\Activity;

use App\Models\User;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $dataset = [
            [
                'activity' => 'Hiking',
                'login' => 'ebrusahin '

            ],
            [
                'activity' => 'Cyclyng',
                'login' => 'ebrusahin '

            ],
            [
                'activity' => 'Beer-tasting',
                'login' => 'ebrusahin '

            ],
            [
                'activity' => 'culturalfood-tasting',
                'login' => 'ebrusahin '

            ],
            [
                'activity' => 'Meat-tasting',
                'login' => 'ebrusahin '

            ],
            [
                'activity' => 'Photography-walk',
                'login' => 'ebrusahin '

            ],
            [
                'activity' => 'picnic',
                'login' => 'ebrusahin '

            ],
            [
                'activity' => 'Swimming',
                'login' => 'ebrusahin '

            ],
            [
                'activity' => 'Kayaking',
                'login' => 'ebrusahin '

            ],

        ];

        foreach ($dataset as $data) {
            $user = User::firstWhere('login', $data['login']);
            if ($user) {
                if ($user) {
                    // Vérifier si l'utilisateur n'a pas déjà cette activité
                    $existingActivity = Activity::where('activity', $data['activity'])
                        ->where('created_by', $user->id)
                        ->first();


                    if (!$existingActivity) {
                        Activity::updateOrcreate([
                            'activity' => $data['activity'],
                            'created_by' => $user->id
                        ]);
                    }
                }
            }
        }
    }
}
