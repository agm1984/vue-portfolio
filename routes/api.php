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

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
    Route::get('user', 'Auth\UserController@me')->name('me');
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'role:admin']], function () {
    Route::get('/categories', 'Admin\CategoryController@index')->name('admin.categories.list');
    Route::get('/categories/{category}', 'Admin\CategoryController@show')->name('admin.categories.show');

    Route::get('/examples', 'Admin\ExampleController@index')->name('admin.examples.list');
    Route::get('/examples/{example}', 'Admin\ExampleController@show')->name('admin.examples.show');

    Route::get('/users', 'Admin\UserController@index')->name('admin.users.list');
    Route::get('/users/{user}', 'Admin\UserController@show')->name('admin.users.show');
});


























// Route::get('/categories', 'CategoryController@index');
// Route::get('/examples', 'ExampleController@index');

// Route::get('/examples/{example}', 'ExampleController@show');

// // Route::group(['prefix' => 'example'], function () {
// //     Route::post('add', 'ExampleController@add');
// //     Route::get('edit/{id}', 'ExampleController@edit');
// //     Route::post('update/{id}', 'ExampleController@update');
// //     Route::delete('delete/{id}', 'ExampleController@delete');
// // });

// // admin
// Route::prefix('admin')->middleware(['auth:sanctum'])->group(function () {
//     Route::get('/categories', 'Admin\CategoryController@index')->name('admin.categories.index');
//     Route::get('/examples', 'Admin\ExampleController@index')->name('admin.examples.index');
// });
