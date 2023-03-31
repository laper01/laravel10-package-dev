<?php

namespace Database\Seeders;

use App\Models\Auth\Group;
use App\Models\Auth\Module;
use App\Models\Auth\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Menu\Entities\Menu;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        Group::create([
            'name' => 'Developer',
            'module_access_code' => 7,
            'is_active' => true
        ]);
        Group::create([
            'name' => 'Admin',
            'module_access_code' => 0,
            'is_active' => true
        ]);
        Group::create([
            'name' => 'Supervisor',
            'module_access_code' => 0,
            'is_active' => true
        ]);
        Group::create([
            'name' => 'Enumerator',
            'module_access_code' => 0,
            'is_active' => true
        ]);
        Group::create([
            'name' => 'Petugas',
            'module_access_code' => 0,
            'is_active' => true
        ]);
        // ============================

        function test($menus,$parent){
            foreach($menus['sub_menu'] as $key=>$m){
                $cnt=count($m['sub_menu']);
                $res=Menu::create([
                    "depth" => 0 ,
                    "position" =>   $key,
                    "icon_class" =>$m['icon_class'],
                    "type" => $cnt?'GROUP':'MODULE',
                    "name" => $m['name'],
                    "original_name" => null,
                    "parent_menu_id" => $parent,
                    "is_active" => true,
                    "module_id" => null,
                    "url" =>  $cnt?'#':$m['url'],
                    "open_in_new_tab" => false
                ]);
                if($cnt<1){
                    Module::create([
                        'name' => $m['url'],
                        'icon_class' => $m['icon_class'],
                        'display_name' => $m['name'],
                        'allow_permision' => $m['allow_permissions'],
                        'author' => 'Yusuf',
                        'edited' => 'Yusuf',
                        'folder' => $m['name']
                    ]);
                }

                if($cnt)test($m,$res->id);
            }
        }

        foreach( config('menusDefault.data') as $keyy=>$m){
            // echo $m['name'];
            // echo "<br>";

            $cnt1=count($m['sub_menu']);
            // add Menu
            $res = Menu::create([
                "depth" =>  0,
                "position" => $keyy,
                "icon_class" =>$m['icon_class'],
                "type" =>  $cnt1?'GROUP':'MODULE',
                "name" => $m['name'],
                "original_name" => null,
                "parent_menu_id" => null,
                "is_active" => true,
                "module_id" => null,
                "url" => $cnt1?'#':$m['url'],
                "open_in_new_tab" => false
            ]);
            // add module
            if($cnt1<1){
                Module::create([
                    'name' => $m['url'],
                    'icon_class' => $m['icon_class'],
                    'display_name' => $m['name'],
                    'allow_permision' => $m['allow_permissions'],
                    'author' => 'Yusuf',
                    'edited' => 'Yusuf',
                    'folder' => $m['name']
                ]);
            }

            if( $cnt1)test($m,$res->id);
        }

        // daerah
        // try {
		// 	Model::unguard();

		// 	// $path = base_path('Modules/MasterData/sql/data.sql');
		// 	$path = base_path('indonesia.sql');
		// 	$sql = file_get_contents($path);

		// 	DB::unprepared($sql);
		// } catch (Exception $e) {
		// 	echo 'Caught exception: ', $e->getMessage(), "\n";
		// }
        // end daerah


        User::create([
            'name' => 'Hamdani',
            'email' => 'admin@gmail.com',
            'group_id' => 1,
            'is_active' => true,
            'password' => bcrypt('12345')
        ]);

        User::create([
            'name' => 'Ali',
            'email' => 'ali@mail.com',
            'group_id' => 2,
            'is_active' => true,
            'password' => bcrypt('admin123')
        ]);

        Role::create([
            'permision'=>15,
            'module_id'=>2,
            'group_id'=>1
        ]);
        // update Men


    }
}
