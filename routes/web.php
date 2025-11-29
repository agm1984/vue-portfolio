<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/debug-email', function () {
    try {
        Mail::raw('This is a test email from Laravel + Brevo', function ($msg) {
            $msg->to('agm1984@gmail.com') // <--- PUT YOUR ACTUAL EMAIL HERE
                ->subject('Test Email');
        });
        return 'Email sent! Check Brevo logs.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::group(['middleware' => ['guest', 'throttle:10,5']], function () {
    Route::post('register', 'Auth\RegisterController@register')->name('register');
    Route::post('login', 'Auth\LoginController@login')->name('login');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider')->name('oauth.redirect');
});

Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('oauth/link/{driver}', 'Auth\OAuthController@linkProvider')->name('oauth.link');
    Route::delete('oauth/unlink/{driver}', 'Auth\OAuthController@unlinkProvider')->name('oauth.unlink');
});

Route::get('oauth/link/{driver}/callback', 'Auth\OAuthController@handleLinkCallback')->middleware('web')->name('oauth.link.callback');

Route::post('email/verify/{user}', [VerificationController::class, 'verify'])->name('verification.verify'); // throttle already applied in controller
Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');
