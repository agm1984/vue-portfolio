<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\UserController as AuthUserController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\CommentVoteController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ExampleController as AdminExampleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\TagController as AdminTagController;


use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group.
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthUserController::class, 'me'])->name('me');

    // Route::patch('settings/profile', [ProfileController::class, 'update'])->name('settings.profile.update');
    // Route::patch('settings/password', [PasswordController::class, 'update'])->name('settings.password.update');

    Route::post('user/profile', [AuthUserController::class, 'editProfile'])->name('user.profile.edit');
    Route::put('user/password', [AuthUserController::class, 'editPassword'])->name('user.password.edit');
    Route::get('user/oauth-providers', [OAuthController::class, 'getLinkedProviders'])->name('user.oauth.providers');

    Route::post('comments/{example}/new', [CommentController::class, 'create'])->name('user.comments.create');
    Route::put('comments/{comment}', [CommentController::class, 'edit'])->name('user.comments.edit');
    Route::delete('comments/{comment}/delete', [CommentController::class, 'delete'])->name('user.comments.delete');
    Route::post('/comments/{comment}/vote', [CommentVoteController::class, 'store'])->name('user.comments.vote.store');
    Route::delete('/comments/{comment}/vote', [CommentVoteController::class, 'destroy'])->name('user.comments.vote.destroy');
});

Route::prefix('admin')
    ->middleware(['transformTypes'])
    ->group(function () {
        Route::get('metrics', [DashboardController::class, 'metrics'])->name('admin.dashboard.metrics');

        Route::get('categories', [AdminCategoryController::class, 'index'])->name('admin.categories.list');
        Route::get('categories/all', [AdminCategoryController::class, 'getAll'])->name('admin.categories.getAll');
        Route::get('categories/{category:slug}', [AdminCategoryController::class, 'show'])->name('admin.categories.show');
        Route::patch('categories/{category:slug}', [AdminCategoryController::class, 'edit'])
            ->middleware('role:admin')
            ->name('admin.categories.edit');
        Route::post('categories', [AdminCategoryController::class, 'create'])
            ->middleware('role:admin')
            ->name('admin.categories.create');

        Route::get('examples', [AdminExampleController::class, 'index'])->name('admin.examples.list');
        Route::get('examples/{example}', [AdminExampleController::class, 'show'])->name('admin.examples.show');
        Route::post('examples', [AdminExampleController::class, 'create'])
            ->middleware('role:admin')
            ->name('admin.examples.create');
        Route::patch('examples/{example:slug}', [AdminExampleController::class, 'edit'])
            ->middleware('role:admin')
            ->name('admin.examples.edit');
        Route::post('examples/{example}/images/append', [AdminExampleController::class, 'appendImages'])
            ->middleware('role:admin')
            ->name('admin.examples.appendImages');
        Route::put('examples/{example}/images/delete/{exampleImage}', [AdminExampleController::class, 'removeImage'])
            ->middleware('role:admin')
            ->name('admin.examples.removeImage');

        Route::get('users', [AdminUserController::class, 'index'])->name('admin.users.list');
        Route::get('users/{user}', [AdminUserController::class, 'show'])->name('admin.users.show');

        Route::get('tags', [AdminTagController::class, 'getAll'])->name('admin.tags.getAll');
    });

Route::prefix('public')->group(function () {
    Route::get('categories', [CategoryController::class, 'index'])->name('public.categories.list');
    Route::get('categories/{category}', [CategoryController::class, 'show'])->name('public.categories.show');

    Route::get('examples', [ExampleController::class, 'index'])->name('public.examples.list');
    Route::get('examples/{example}', [ExampleController::class, 'show'])->name('public.examples.show');
    Route::get('examples/{example}/images/{exampleImage}', [ExampleController::class, 'image'])->name('public.examples.image');
    Route::get('examples/{example}/comments', [ExampleController::class, 'listComments'])->name('public.examples.listComments');

    Route::post('contact', [ContactController::class, 'send'])->name('public.contact.send');

    // not used
    // Route::get('users', [UserController::class, 'index'])->name('public.users.list');
    // Route::get('users/{user}', [UserController::class, 'show'])->name('public.users.show');
});