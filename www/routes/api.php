<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app(Dingo\Api\Routing\Router::class);

$api->version('v1', function ($api) {
    $api->post('authenticate', 'App\Http\Controllers\Api\Auth\AuthController@login');

});

$api->version('v1', ['middleware' => 'jwt.auth'], function($api) {
    $api->get('user', 'App\Http\Controllers\Api\Auth\AuthController@getAuthUser');
    $api->post('logout', 'App\Http\Controllers\Api\Auth\AuthController@logout');

    // socials
    $api->get('socials', 'App\Http\Controllers\Api\SocialController@getAssociatedAccounts');
    $api->post('post/store', 'App\Http\Controllers\Api\PostController@store');
    $api->get('post/last/{planned?}', 'App\Http\Controllers\Api\PostController@getLastPost');
    $api->get('posts/find/{date}', 'App\Http\Controllers\Api\PostController@getPostsByDate');
});