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


Route::get('products', 'API\ProductController@index');
Route::get('products/{id}', 'API\ProductController@show');
Route::get('categories', 'API\CategoryController@index');
Route::get('categories/{id}', 'API\CategoryController@show');
Route::get('products_category/{id}', 'API\CategoryController@productsCategory');
Route::get('featured_products', 'API\ProductController@featuredProducts');


Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@store');



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
