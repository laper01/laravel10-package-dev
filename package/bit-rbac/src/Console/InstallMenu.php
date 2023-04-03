<?php

namespace Danova\BitRbac\Console;

use Illuminate\Console\Command;


class InstallMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bitrbac-api:install-menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add menu at rbac system';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {

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


        // update Men
    }
}
