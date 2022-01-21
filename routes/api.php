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

Route::group(['namespace' => 'Api'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('login', 'Login')
            ->name('api.auth.login');

        Route::get('logout', 'Logout')
            ->name('api.auth.logout')
            ->middleware('oauth:api');
    });

    Route::group(['middleware' => 'oauth:api'], function () {
        Route::group(['namespace' => 'Car', 'prefix' => 'car'], function () {
            Route::post('in-stock', 'GetCarsInStock')
                ->name('api.car.in-stock');
        });

        Route::group(['namespace' => 'Profile', 'prefix' => 'profile'], function () {
            Route::get('get-details', 'GetDetails')
                ->name('api.profile.get-details');
        });
    });
});
