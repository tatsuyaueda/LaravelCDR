<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', function() {
    return view('index');
});

Route::get('/cdr/', ['middleware' => 'auth', 'uses' => 'CdrController@getIndex']);
Route::post('/cdr/search', ['middleware' => 'auth', 'uses' => 'CdrController@postSearch']);

// ユーザ認証
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// ユーザ管理(一般ユーザ)
Route::get('user/password', ['middleware' => 'auth', 'uses' => 'UserController@getPassword']);
Route::post('user/password', ['middleware' => 'auth', 'uses' => 'UserController@postPassword']);

// ユーザ管理(管理者)
Route::get('admin/', ['middleware' => 'adminauth', 'uses' => 'AdminController@getIndex']);
Route::get('admin/AddUser', ['middleware' => 'adminauth', 'uses' => 'AdminController@getAddUser']);
Route::post('admin/AddUser', ['middleware' => 'adminauth', 'uses' => 'AdminController@postAddUser']);
Route::post('admin/DelUser', ['middleware' => 'adminauth', 'uses' => 'AdminController@postDelUser']);
