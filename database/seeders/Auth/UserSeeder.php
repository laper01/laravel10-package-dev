<?php

namespace Database\Seeders\Auth;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::insert([
            [
                'name' => 'Hamdani',
                'email' => 'admin@gmail.com',
                'group_id' => 1,
                'is_active' => true,
                'password' => bcrypt('12345')
            ],

            [
                'name' => 'Ali',
                'email' => 'ali@mail.com',
                'group_id' => 2,
                'is_active' => true,
                'password' => bcrypt('admin123')
            ]

        ]);
    }
}
