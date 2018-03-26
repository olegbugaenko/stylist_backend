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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['namespace' => 'Api'], function()
{
    Route::post('login', 'UserAuth@login');

    Route::post('register', 'UserAuth@register');
});

Route::group(['namespace' => 'Api','middleware' => ['jwt_auth']], function()
{
    Route::get('list','UserAuth@index');

    Route::get('check_auth', 'UserAuth@is_logged');

    Route::get('services/{user_id}', 'Services@getServices');

    Route::get('my-services', 'Services@myServices');

    Route::get('my-guide', 'Services@getCurrentUserStep');

	Route::get('available-services', 'Services@availableServices');

    Route::post('update_userservice', 'Services@saveService');

    Route::get('availability', 'UserAvailability@getAvailability');

    Route::post('update_availability', 'UserAvailability@setAvailability');


});