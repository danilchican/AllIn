<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', [
    'as' => 'about',
    'uses' => 'AboutPageController@index'
]);

Auth::routes();

Route::get('/auth/{provider}', 'SocialController@login')->name('auth.provider');
Route::get('/auth/{provider}/callback', 'SocialController@callback');

Route::get('/home/{account?}', 'Account\AccountController@index')->name('account.index');
