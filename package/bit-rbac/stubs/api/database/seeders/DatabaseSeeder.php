<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Auth\ModuleSeeder;
use Database\Seeders\Auth\UserSeeder;
use Database\Seeders\Auth\GroupSeeder;
use Database\Seeders\Auth\RoleSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            GroupSeeder::class,
            UserSeeder::class,
            ModuleSeeder::class,
            RoleSeeder::class
        ]);
    }
}
