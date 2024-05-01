<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Locality;
use App\Models\Role;
use App\Models\User;
use App\Models\UserActivity;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            RoleSeeder::class,
            TypeSeeder::class,
            LocalitySeeder::class,
            ActivitySeeder::class,
            PlaceSeeder::class,
            PhotoSeeder::class,
            TripSeeder::class,
            UserActivitySeeder::class,


        ]);
    }
}
