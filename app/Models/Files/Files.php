<?php
/**
 * File: Files.php
 * Author: Seakee <seakee23@gmail.com>
 * Homepage: https://seakee.top/
 * Date: 2017/12/12 17:19
 * Description:
 */

namespace App\Models\Files;


use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
	protected $table = 'files';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'type', 'path', 'disk', 'size', 'uploader','md5',
	];
}