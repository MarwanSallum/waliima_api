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
    Route::post('login', 'AdminAuthController@login');
    
});

Route::group(['middleware' => ['api', 'checkAdminToken:admin-api'], 'namespace' => 'AdminApi', 'prefix' => 'admin'], function () {
    Route::post('me', 'AdminAuthController@me');
    Route::post('refresh', 'AdminAuthController@refresh');
    Route::post('logout', 'AdminAuthController@logout');
    //---------------- Product Route ------------------------//
    Route::get('products', 'AdminProductController@index');
    Route::post('product', 'AdminProductController@store');
    Route::get('product/{product}', 'AdminProductController@show');
    Route::post('product/{product}', 'AdminProductController@update');
    Route::delete('delete/{product}', 'AdminProductController@destroy');
    //-------------------------------------------------------//

    //---------------- Advertis Route ------------------------//
    Route::get('advertis/all', 'AdminAdvertisementController@index');
    Route::post('advertis/add', 'AdminAdvertisementController@store');
    Route::get('advertis/show/{advertis}', 'AdminAdvertisementController@show');
    Route::post('advertis/update/{advertis}', 'AdminAdvertisementController@update');
    Route::delete('advertis/delete/{advertis}', 'AdminAdvertisementController@destroy');

     //---------------- Special Offers Route ------------------------//
    Route::get('special-offers/all', 'SpecialOfferController@index');
    Route::post('special-offer/add', 'SpecialOfferController@store');

    
});


