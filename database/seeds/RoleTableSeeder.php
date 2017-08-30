<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => '超级管理员',
            'display_name' => 'Super_Admin',
            'description' => '超级管理员，拥有所有权限',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('roles')->insert([
            'name' => '管理员',
            'display_name' => 'Admin',
            'description' => '按权限分配的管理员',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('roles')->insert([
            'name' => '会员',
            'display_name' => 'Member',
            'description' => '普通会员，只用拥有前台权限',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
    }
}
