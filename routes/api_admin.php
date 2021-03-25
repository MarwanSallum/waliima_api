<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['namespace' => 'AdminApi', 'prefix' => 'admin'], function () {
    Route::post('admin-login', 'AdminAuthController@adminLogin');
});

Route::group(['middleware' => ['api', 'checkAdminToken:admin-api'], 'namespace' => 'AdminApi', 'prefix' => 'admin'], function () {
    Route::get('test', 'AdminAuthController@test');
});

