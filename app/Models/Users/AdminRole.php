<?php

namespace App\Models\Users;

use DB;
use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'display_name', 'description',
	];

	/**
	 * Many-to-Many relations with the user model.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users()
	{
		return $this->belongsToMany('App\Models\Users\AdminUser', 'admin_users', 'role_id', 'user_id');
	}

	/**
	 * Many-to-Many relations with the permission model.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function permissions()
	{
		return $this->belongsToMany('App\Models\Users\AdminPermission', 'admin_permission_role', 'role_id', 'permission_id');
	}
}
