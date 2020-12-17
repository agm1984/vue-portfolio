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

    Route::post('/user/profile', 'Auth\UserController@editProfile')->name('user.profile.edit');
    Route::put('/user/password', 'Auth\UserController@editPassword')->name('user.password.edit');

    Route::post('/comments/{example}/new', 'User\CommentController@create')->name('user.comments.create');
    Route::put('/comments/{comment}', 'User\CommentController@edit')->name('user.comments.edit');
    Route::delete('/comments/{comment}/delete', 'User\CommentController@delete')->name('user.comments.delete');
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'role:admin', 'transformTypes']], function () {
    Route::get('/categories', 'Admin\CategoryController@index')->name('admin.categories.list');
    Route::get('/categories/all', 'Admin\CategoryController@getAll')->name('admin.categories.getAll');
    Route::get('/categories/{category}', 'Admin\CategoryController@show')->name('admin.categories.show');

    Route::get('/examples', 'Admin\ExampleController@index')->name('admin.examples.list');
    Route::get('/examples/{example}', 'Admin\ExampleController@show')->name('admin.examples.show');
    Route::post('/examples', 'Admin\ExampleController@create')->name('admin.examples.create');
    Route::put('/examples/{example}', 'Admin\ExampleController@edit')->name('admin.examples.edit');
    Route::post('/examples/{example}/images/append', 'Admin\ExampleController@appendImages')->name('admin.examples.appendImages');
    Route::put('/examples/{example}/images/delete/{exampleImage}', 'Admin\ExampleController@removeImage')->name('admin.examples.removeImage');

    Route::get('/users', 'Admin\UserController@index')->name('admin.users.list');
    Route::get('/users/{user}', 'Admin\UserController@show')->name('admin.users.show');

    Route::get('/tags', 'Admin\TagController@getAll')->name('admin.tags.getAll');
});

Route::group(['prefix' => 'public'], function () {
    Route::get('/categories', 'CategoryController@index')->name('public.categories.list');
    Route::get('/categories/{category}', 'CategoryController@show')->name('public.categories.show');

    Route::get('/examples', 'ExampleController@index')->name('public.examples.list');
    Route::get('/examples/{example}', 'ExampleController@show')->name('public.examples.show');
    Route::get('/examples/{example}/images/{exampleImage}', 'ExampleController@image')->name('public.examples.images');
    Route::get('/examples/{example}/comments', 'ExampleController@listComments')->name('public.examples.listComments');

    // Route::get('/users', 'UserController@index')->name('public.users.list');
    // Route::get('/users/{user}', 'UserController@show')->name('public.users.show');
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
