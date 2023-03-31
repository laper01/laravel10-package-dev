<?php

namespace Database\Seeders\Auth;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Auth\Module;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $author_1 = 'Yusuf';
        //
        Module::insert([
            [
                'name' => 'module',
                'icon_class' => 'fa-solid fa-cubes',
                'display_name' =>'Module',
                'allow_permision' => 15,
                'author' => $author_1,
                'edited' => $author_1,
                'folder' => 'Module',
            ],

            [
                'name' => 'group',
                'icon_class' => 'fa-solid fa-layer-group',
                'display_name' => 'Group',
                'allow_permision' => 15,
                'author' => $author_1,
                'edited' => $author_1,
                'folder' => 'Group',
            ],

            [
                'name' => 'menu',
                'icon_class' => 'fa-solid fa-layer-group',
                'display_name' => 'Menu',
                'allow_permision' => 15,
                'author' => $author_1,
                'edited' => $author_1,
                'folder' => 'Menu',
            ],

            [
                'name' => 'dashboard',
                'icon_class' => 'fa-solid fa-layer-group',
                'display_name' => 'Dashboard',
                'allow_permision' => 15,
                'author' => $author_1,
                'edited' => $author_1,
                'folder' => 'Dashboard',
            ],

        ]);
    }
}
