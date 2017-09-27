<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Models\User\Role;
use App\Models\User\User;

class EntrustSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating roles to users (Many-to-Many)
        Schema::create('role_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'role_id']);
        });

        // Create table for storing permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });

        $this->setupUserRole();
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('permission_role');
        Schema::drop('permissions');
        Schema::drop('role_user');
        Schema::drop('roles');
    }

	/**
	 * 初始化管理员和超级管理权限
	 */
	public function setupUserRole()
	{
		//初始化权限
		$role = new Role();

		$role->name         = 'Super_Admin';
		$role->display_name = '超级管理员';
		$role->description  = '超级管理员，拥有所有权限';

		$role->save();

		//初始化管理员
		$user = new User();

		$user->user_name = 'admin';
		$user->nick_name = 'admin';
		$user->email     = 'admin@admin.com';
		$user->phone     = '18888888888';
		$user->rank      = 1;
		$user->password  = bcrypt('admin123456');

		$user->save();

		if (!$user->save()) {
			Log::info('Unable to create user ' . $user->username, (array)$user->errors());
		} else {
			Log::info('Created user "' . $user->username . '" <' . $user->email . '>');
		}

		//授权
		$user->roles()->attach($role->id);
	}
}
