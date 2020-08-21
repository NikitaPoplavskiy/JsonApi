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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



// Route::resource('categories', 'CategoryController');

// Route::resource('products', 'ProductController');

// Список всех продуктов
Route::get('products', 'ProductController@index');

// Просмотр определенного продукта
Route::get('product/{id}', 'ProductController@show');

// Удаление продукта
Route::delete('product/{id}', 'ProductController@destroy');

// Добавление нового продукта
Route::post('product', 'ProductController@store');

// Список всех категории
Route::get('categories', 'CategoryController@index');

// Товар из конкретной категории
Route::get('category/{id}', 'CategoryController@show');

// Редактирование категории
Route::put('category/{id}', 'CategoryController@update');

// Удаление категории
Route::delete('category/{id}', 'CategoryController@destroy');

// Добавление новой категории
Route::post('category', 'CategoryController@store');


