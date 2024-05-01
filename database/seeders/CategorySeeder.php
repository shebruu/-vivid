<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $dataset = [
            [
                'name' => 'transport'

            ],
            ['name' => 'food'],
            [
                'name' => 'hosting',

            ],
            [
                'name' => 'leisure',

            ],
            [
                'name' => 'shopping',

            ],
        ];

        foreach ($dataset as $data) {
            Category::updateOrCreate(
                ['name' => trim($data['name'])],
                $data
            );
        }
    }
}
