<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataset = [
            [
                'name' => 'ebru ',
                'lastname' => 'sahin ',
                'login' => 'ebrusahin',
                'phone' => 0456407361,
                'email' => 'ebsahinn7887@outlook.com',
                'age' => 26,
                'student' => 1,
                'langue' => 'fr',
                'password' => Hash::make('mypass'),
            ],
            [
                'name' => 'ferah ',
                'lastname' => 'zeynep ',
                'login' => 'zeyn',
                'phone' => 0456407361,
                'email' => 'zeyno23@outlook.com',
                'age' => 26,
                'student' => 1,
                'langue' => 'fr',
                'password' => Hash::make('mypass'),
            ],

        ];
        foreach ($dataset as $data) {
            User::updateOrCreate(
                ['login' => $data['login']],
                $data
            );
        }
    }
}
