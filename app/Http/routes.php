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

// アドレス帳
Route::get('/addressbook/', ['middleware' => 'auth', 'uses' => 'AddressBookController@getIndex']);
Route::get('/addressbook/group', ['middleware' => 'auth', 'uses' => 'AddressBookController@getGroup']);
Route::get('/addressbook/group-edit/{id?}', ['middleware' => 'auth', 'uses' => 'AddressBookController@getGroupEdit']);
Route::post('/addressbook/group-edit/{id?}', ['middleware' => 'auth', 'uses' => 'AddressBookController@postGroupEdit']);
Route::get('/addressbook/sel2Group', ['middleware' => 'auth', 'uses' => 'AddressBookController@getSel2Group']);
Route::post('/addressbook/search', ['middleware' => 'auth', 'uses' => 'AddressBookController@postSearch']);
Route::get('/addressbook/detail/{id?}', ['middleware' => 'auth', 'uses' => 'AddressBookController@getDetail']);
Route::get('/addressbook/edit/{id?}', ['middleware' => 'auth', 'uses' => 'AddressBookController@getEdit']);
Route::post('/addressbook/edit/{id?}', ['middleware' => 'auth', 'uses' => 'AddressBookController@postEdit']);

// ユーザ認証
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// パスワードリセット リクエスト
Route::get('auth/email', 'Auth\PasswordController@getEmail');
Route::post('auth/email', 'Auth\PasswordController@postEmail');
 
// パスワードリセット
Route::get('auth/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('auth/reset', 'Auth\PasswordController@postReset');

// ユーザ管理(一般ユーザ)
Route::get('user/password', ['middleware' => 'auth', 'uses' => 'UserController@getPassword']);
Route::post('user/password', ['middleware' => 'auth', 'uses' => 'UserController@postPassword']);

// ユーザ管理(管理者)
Route::get('admin/', ['middleware' => ['role:admin'], 'uses' => 'AdminController@getIndex']);
Route::get('admin/AddUser', ['middleware' => ['role:admin'], 'uses' => 'AdminController@getAddUser']);
Route::post('admin/AddUser', ['middleware' => ['role:admin'], 'uses' => 'AdminController@postAddUser']);
Route::post('admin/DelUser', ['middleware' => ['role:admin'], 'uses' => 'AdminController@postDelUser']);
