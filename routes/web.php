<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  
    return view('welcome');
});
// 
Route::post('/userRegistretion',[UserController::class,'userRegistration']);
Route::post('/userlogin',[UserController::class,'userLogin']);
Route::post('/sendOtpCode',[UserController::class,'sendOtpCode']);
Route::post('/verifyOtpCode',[UserController::class,'verifyOtpCode']);
// token
Route::post('/passwordReset',[UserController::class,'passwordReset'])
->middleware([TokenVerificationMiddleware::class]);

// userlogout
Route::get('/userLogOut',[UserController::class,'userlogout']);
// profile update
Route::get('/userProfile',[UserController::class,'profileForm'])
->middleware([TokenVerificationMiddleware::class]);
Route::post('/userProfileUpdate',[UserController::class,'userProfileUpdate'])
->middleware([TokenVerificationMiddleware::class]);
// Route::get('/',[HomeController::class,'HomePage']);
Route::get('/userlogin',[UserController::class,'LoginPage']);
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage']);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/dashboard',[DashboardController::class,'DashboardPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/ProfilePage',[UserController::class,'ProfilePage'])->middleware([TokenVerificationMiddleware::class]);