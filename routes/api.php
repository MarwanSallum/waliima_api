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
    Route::get('add-to-cart/{product}', 'CartController@addToCart');
    Route::post('auth', 'AuthController@auth');
    Route::post('send-otp', 'AuthController@sendOtp');
});

Route::group(['middleware' => ['api','checkUserToken:user-api'],'namespace' => 'Api'], function () {
    Route::get('logout', 'AuthController@logout');
    Route::get('user', 'AuthController@getAuthUser');
    
    ///////////////////// ADMIN SECTION ////////////////////////

    /////////////////////  Product Route ///////////////////////
    Route::get('products', 'ProductController@index');
    Route::post('add-product', 'ProductController@store');
    Route::get('product/{product}', 'ProductController@show');
    Route::post('update-product/{product}', 'ProductController@update');

    //////////////////// Cart Route ///////////////////////////////
    Route::get('cart','CartController@store');
    Route::get('cart/{cart}','CartController@show');
    Route::post('cart/{cart}', 'CartController@addProducts');
    Route::post('cart/{cart}/checkout', 'CartController@checkout');

    ////////////////// Order Route ////////////////////////////////
    Route::get('orders', 'OrderController@index');
    Route::get('order/{order}', 'OrderController@show');

    ///////////////// Mutual Cart Route //////////////////////////
    Route::get('mutual-cart', 'MutualcartController@store');
    Route::get('mutual-cart/{cart}', 'MutualcartController@show');
    Route::post('mutual-cart/{cart}', 'MutualcartController@addProducts');
    Route::get('find-cart', 'MutualcartController@findCart');
    Route::post('join-cart/{cart}', 'MutualcartController@joinToCart');




});

