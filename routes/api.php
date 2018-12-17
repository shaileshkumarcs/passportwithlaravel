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

// Common API
Route::group(['prefix' => 'v1'], function(){
	Route::post('login', 'API\UserController@login');
	Route::post('register', 'API\UserController@register');
});

// Common API With Auth
Route::group(['prefix' => 'v1','middleware' => 'auth:api'], function(){

	Route::get('details', 'API\UserController@details');

});

// Check User Validation 
Route::group(['prefix' => 'v1','middleware' => ['auth:api', 'userauth']], function(){

	Route::get('user/{id}','API\UserController@show'); // Show one User Profile

	Route::put('user/{id}','API\UserController@update'); // Update profile from user

});

// Check Vendor Validation Validation
Route::group(['prefix' => 'v1','middleware' => ['auth:api', 'vendorauth']], function(){

	Route::get('vendor/{id}','API\VendorController@show'); // Show one Vendor Profile

	Route::put('vendor/{id}','API\VendorController@update'); // Update profile from vendor

});


// Check Admin Validation Group Route
Route::group(['prefix' => 'v1','middleware' => ['auth:api', 'adminauth']], function(){

	Route::get('user','API\UserController@index')->name('userlist'); // List Of all Users

	Route::get('vendor','API\VendorController@index'); // List Of all Users

});