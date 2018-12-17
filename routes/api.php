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

// Common API
Route::group(['prefix' => 'v1'], function(){
	Route::post('login', 'API\UserController@login');
	Route::post('register', 'API\UserController@register');
});

// With Auth
Route::group(['prefix' => 'v1','middleware' => 'auth:api'], function(){

	Route::get('details', 'API\UserController@details');
	Route::get('users', 'API\UserController@users');

	Route::get('vendors/{id}','API\VendorController@show');
	Route::put('vendors/{id}','API\VendorController@update');
});

Route::group(['prefix' => 'v1','middleware' => ['auth:api', 'adminauth']], function(){

	//Route::get('vendors','API\VendorController@index'); FOR TESTING MIDDLEWARE

	Route::get('admin/vendors', 'API\AdminController@vendors');

	// Route::resource('admin','API\AdminController'); //->except('create','update','destroy');
	
	Route::resource('user','API\UserController'); //->except('create','update','destroy');
	
	Route::resource('vendor','API\VendorController'); //->except('create','update','destroy');

});