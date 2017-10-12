<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            'icon' => 'fa-home',
            'menu_name' => '管理中心',
            'route_name' => '#',
            'father_id' => -1,
            'sort' => 1,
            'display' => 1,
            'state' => 1,
            'is_custom' => 0,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('menus')->insert([
            'icon' => 'fa-users',
            'menu_name' => '用户中心',
            'route_name' => '#',
            'father_id' => -1,
            'sort' => 1,
            'display' => 1,
            'state' => 1,
            'is_custom' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

	    DB::table('menus')->insert([
		    'icon' => 'fa-dashboard',
		    'menu_name' => '仪表盘',
		    'route_name' => 'admin.index',
		    'father_id' => 1,
		    'sort' => 1,
		    'display' => 1,
		    'state' => 1,
		    'is_custom' => 0,
		    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
		    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
	    ]);

	    DB::table('menus')->insert([
		    'icon' => 'fa-gears',
		    'menu_name' => '系统配置',
		    'route_name' => '#',
		    'father_id' => 1,
		    'sort' => 0,
		    'display' => 1,
		    'state' => 1,
		    'is_custom' => 0,
		    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
		    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
	    ]);

        DB::table('menus')->insert([
            'icon' => 'fa-list-ul',
            'menu_name' => '菜单管理',
            'route_name' => 'menu.admin',
            'father_id' => 1,
            'sort' => 1,
            'display' => 1,
            'state' => 1,
            'is_custom' => 0,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('menus')->insert([
            'icon' => 'fa-user',
            'menu_name' => '用户管理',
            'route_name' => 'user.index',
            'father_id' => 2,
            'sort' => 0,
            'display' => 1,
            'state' => 1,
            'is_custom' => 0,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('menus')->insert([
            'icon' => 'fa-address-card',
            'menu_name' => '角色管理',
            'route_name' => 'role.index',
            'father_id' => 2,
            'sort' => 0,
            'display' => 1,
            'state' => 1,
            'is_custom' => 0,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('menus')->insert([
            'icon' => 'fa-expeditedssl',
            'menu_name' => '权限管理',
            'route_name' => 'permission.index',
            'father_id' => 2,
            'sort' => 0,
            'display' => 1,
            'state' => 1,
            'is_custom' => 0,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
    }
}
