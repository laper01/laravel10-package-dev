<?php

namespace Database\Seeders\Auth;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Auth\Group;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Group::insert([
            [
                'name' => 'Developer',
                'module_access_code' => 7,
                'is_active' => true
            ],
            [
                'name' => 'Admin',
                'module_access_code' => 0,
                'is_active' => true
            ]
        ]);
    }

}
