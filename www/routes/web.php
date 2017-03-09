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

Route::get('/about', 'AboutPageController@index')->name('about');

Auth::routes();

Route::get('/auth/{provider}', 'SocialController@login')->name('auth.provider');
Route::get('/auth/{provider}/callback', 'SocialController@callback');

Route::get('/socials/{provider}/create', 'SocialController@create')->name('socials.provider');
Route::get('/socials/{provider}/callback', 'SocialController@appendSocialCallback');

Route::get('/home/{account?}', 'Account\AccountController@index')->name('account.index');
