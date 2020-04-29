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

Route::get('/categories', 'CategoryController@index');
Route::get('/examples', 'ExampleController@index');

Route::get('/examples/{example}', 'ExampleController@show');

// Route::group(['prefix' => 'example'], function () {
//     Route::post('add', 'ExampleController@add');
//     Route::get('edit/{id}', 'ExampleController@edit');
//     Route::post('update/{id}', 'ExampleController@update');
//     Route::delete('delete/{id}', 'ExampleController@delete');
// });

// admin
Route::prefix('admin')->group(function () {
    Route::get('/examples', 'Admin/AdminExampleController@index')->name('admin.examples.index');
    // Route::get('/examples/', 'AdminExampleController@index')->name('admin.examples.index');
});