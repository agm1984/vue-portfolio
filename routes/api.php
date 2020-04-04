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

Route::get('categories', 'CategoryController@index');
Route::get('examples', 'ExampleController@index');
// Route::group(['prefix' => 'book'], function () {
//     Route::post('add', 'BookController@add');
//     Route::get('edit/{id}', 'BookController@edit');
//     Route::post('update/{id}', 'BookController@update');
//     Route::delete('delete/{id}', 'BookController@delete');
// });