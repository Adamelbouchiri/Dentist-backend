<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\ResetPasswordController as AuthResetPasswordController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FacebookAuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SecondRegistrationController;
use App\Http\Controllers\UserSettingsController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/', function () {
    return 'hello';
});

Route::apiResource('appointments', AppointmentController::class);
Route::get('user-appointments', [AppointmentController::class, 'userAppointments'])->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/second-registration', [SecondRegistrationController::class, 'store'])->middleware('auth:sanctum');
Route::get('/user-second-registration', [SecondRegistrationController::class, 'show'])->middleware('auth:sanctum');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum'); 

//GoogleAuth
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

//FacebookAuth
Route::get('/auth/facebook/redirect', [FacebookAuthController::class, 'facebookRedirect']);
Route::get('/auth/facebook/callback', [FacebookAuthController::class, 'facebookCallback']);

//Reset Password
Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLink']);
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);

//Stripe
Route::post('/create-payment-intent', [PaymentController::class, 'createIntent']);

//Settings
Route::post('/update-avatar', [UserSettingsController::class, 'changeAvatar'])->middleware('auth:sanctum');
Route::post('/update-name', [UserSettingsController::class, 'changeName'])->middleware('auth:sanctum');
Route::post('/update-password', [UserSettingsController::class, 'changePassword'])->middleware('auth:sanctum');

//Admin part
Route::get('/admin/appointments', [AdminController::class, 'index'])->middleware('auth:sanctum');
Route::put('/admin/appointments/{id}', [AdminController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/admin/appointments/{id}', [AdminController::class, 'destroy'])->middleware('auth:sanctum');

