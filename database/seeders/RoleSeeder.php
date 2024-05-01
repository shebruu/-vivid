<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $roles = [
            [
                'role' => 'admin'

            ],
            ['role' => 'member'],
            [
                'role' => 'contributor',

            ],
            [
                'role' => 'groupmember',

            ],

        ];

        foreach ($roles as $roleData) {
            Role::updateOrCreate(
                ['role' => $roleData['role']],
                $roleData
            );
        }
    }
}
