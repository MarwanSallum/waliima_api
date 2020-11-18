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
Route::group(['middleware' => 'api', 'namespace' => 'Api'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login')->name('json.login');

});

Route::group(['middleware' => ['api','checkUserToken:user-api'],'namespace' => 'Api'], function () {
    Route::get('logout', 'AuthController@logout');
    Route::get('user', 'AuthController@getAuthUser');
    
    ///////////////////// ADMIN SECTION ////////////////////////

    /////////////////////  Category Route ///////////////////////
    Route::get('categories', 'CategoryController@index');
    Route::post('add-category', 'CategoryController@store');
    Route::post('delete-category/{id}', 'CategoryController@destroy');
    ///////////////////  End Category Route /////////////////////

});

