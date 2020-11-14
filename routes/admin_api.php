<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => 'api', 'namespace' => 'Api\Admin'], function () {
    Route::get('login', 'AdminAuthController@login');
    Route::post('register', 'AdminAuthController@register');
});

Route::group(['middleware' => ['api','checkUserToken:admin-api'],'namespace' => 'Api\Admin'], function () {


});