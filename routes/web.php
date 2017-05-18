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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'checkPermission']], function() {
    
    Route::get('/', 'AdminController@index')->name('admin');

    Route::group(['prefix' => 'menu', 'namespace' => 'Menu'], function (){
        Route::get('/admin', 'MenuController@admin')->name('menu.admin');
        Route::get('/home', 'MenuController@home')->name('menu.home');
        Route::get('/createAdminMenu', 'MenuController@createAdminMenu')->name('menu.admin.create');
        Route::get('/editAdminMenu', 'MenuController@editAdminMenu')->name('menu.admin.edit');
        Route::get('/editHomeMenu', 'MenuController@editHomeMenu')->name('menu.home.edit');
        Route::get('/createHomeMenu', 'MenuController@createHomeMenu')->name('menu.home.create');
        Route::get('/delete', 'MenuController@deleteMenu')->name('menu.delete');
        Route::get('/changeDisplay', 'MenuController@changeDisplay')->name('menu.changeDisplay');
        Route::post('/create', 'MenuController@createMenu')->name('menu.create');
        Route::post('/edit', 'MenuController@editMenu')->name('menu.edit');
    });

    Route::group(['prefix' => 'userCenter', 'namespace' => 'User'], function (){
        Route::group(['prefix' => 'user'], function (){
            Route::get('/index', 'UserController@index')->name('user.index');
            Route::get('/adminCreateUser', 'UserController@adminCreateUser')->name('user.admin.create');
            Route::get('/adminEditUser', 'UserController@adminEditUser')->name('user.admin.edit');
            Route::get('/delete', 'UserController@deleteUser')->name('user.delete');
            Route::get('/changeStatus', 'UserController@changeStatus')->name('user.changeStatus');
            Route::post('/create', 'UserController@createUser')->name('user.create');
            Route::post('/edit', 'UserController@editUser')->name('user.edit');
        });

        Route::get('/role/index', 'RoleController@index')->name('role.index');
        Route::get('/permission/index', 'PermissionController@index')->name('permission.index');
    });
});