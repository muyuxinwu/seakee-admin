<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::group(['prefix' => 'admin', 'middleware' => ['checkPermission']], function() {
    
    Route::get('/index', 'AdminController@index')->name('admin.index');

    Route::group(['prefix' => 'menu', 'namespace' => 'Menu'], function (){
        Route::get('/admin', 'MenuController@admin')->name('menu.admin');
        Route::get('/home', 'MenuController@home')->name('menu.home');
        Route::get('/createAdmin', 'MenuController@createAdmin')->name('menu.createAdmin');
        Route::get('/editAdmin', 'MenuController@editAdmin')->name('menu.editAdmin');
        Route::get('/editHome', 'MenuController@editHome')->name('menu.editHome');
        Route::get('/createHome', 'MenuController@createHome')->name('menu.createHome');
        Route::post('/delete', 'MenuController@delete')->name('menu.delete');
        Route::post('/display', 'MenuController@display')->name('menu.display');
        Route::post('/store', 'MenuController@store')->name('menu.store');
        Route::post('/update', 'MenuController@update')->name('menu.update');
    });

    Route::group(['prefix' => 'userCenter', 'namespace' => 'User'], function (){
        Route::group(['prefix' => 'user'], function (){
            Route::get('/index', 'UserController@index')->name('user.index');
            Route::get('/adminCreate', 'UserController@adminCreate')->name('user.adminCreate');
            Route::get('/adminEdit', 'UserController@adminEdit')->name('user.adminEdit');
            Route::post('/delete', 'UserController@delete')->name('user.delete');
            Route::post('/status', 'UserController@status')->name('user.status');
            Route::post('/store', 'UserController@store')->name('user.store');
            Route::post('/update', 'UserController@update')->name('user.update');
        });

        Route::group(['prefix' => 'role'], function (){
            Route::get('/index', 'RoleController@index')->name('role.index');
            Route::get('/userRole', 'RoleController@userRole')->name('role.userRole');
            Route::get('/edit', 'RoleController@edit')->name('role.edit');
            Route::post('/delete', 'RoleController@delete')->name('role.delete');
            Route::post('/store', 'RoleController@store')->name('role.store');
            Route::post('/update', 'RoleController@update')->name('role.update');
            Route::post('/assignRole', 'RoleController@assignRole')->name('role.assignRole');
        });

        Route::group(['prefix' => 'permission'], function (){
            Route::get('/index', 'PermissionController@index')->name('permission.index');
            Route::get('/rolePermission', 'PermissionController@rolePermission')->name('permission.rolePermission');
            Route::get('/edit', 'PermissionController@edit')->name('permission.edit');
            Route::get('/batchCreate', 'PermissionController@batchCreate')->name('permission.batchCreate');
            Route::post('/store', 'PermissionController@store')->name('permission.store');
            Route::post('/delete', 'PermissionController@delete')->name('permission.delete');
            Route::post('/update', 'PermissionController@update')->name('permission.update');
            Route::post('/authorization', 'PermissionController@authorization')->name('permission.authorization');
        });

    });

	Route::group(['prefix' => 'config', 'namespace' => 'Configuration'], function (){
		Route::get('/index', 'ConfigController@index')->name('config.index');
		Route::get('/app', 'ConfigController@app')->name('config.app');
		Route::post('/update', 'ConfigController@update')->name('config.update');
	});

	Route::group(['prefix' => 'file', 'namespace' => 'Files'], function (){
		Route::get('/index', 'FileController@index')->name('file.index');
		Route::get('/getDisk', 'FileController@getDisk')->name('file.getDisk');
		Route::post('/upload', 'FileController@upload')->name('file.upload');
	});
});