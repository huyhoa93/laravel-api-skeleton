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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Routes not authenticated
Route::group(['prefix' => '/', 'namespace' => 'Api'], function () {
    Route::post('register', 'UserController@register');
    Route::post('login', 'UserController@login');
    Route::get('refresh', 'UserController@refresh');
});

Route::group(['prefix' => '/', 'namespace' => 'Api', 'middleware' => ['auth:api']], function () {
    Route::get('me', 'UserController@me');
    Route::get('users', 'UserController@getUsers');
    Route::get('logout', 'UserController@logout');
});
