<?php

use App\Http\Controllers\categoriesController;
use App\Http\Controllers\customerController;
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

// pages Route
Route::get('/categoryPage',[categoriesController::class,'CategoriesPage'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/categoriesID',[categoriesController::class,'categoriesID'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/categoryList',[categoriesController::class,'categoriesList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/categoriesCreate',[categoriesController::class,'categoriesCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/categoriesUpdate',[categoriesController::class,'categoriesUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/categoriesDelet',[categoriesController::class,'categoriesDelet'])->middleware([TokenVerificationMiddleware::class]);
// customer Route
Route::get('/customerPages',[customerController::class,'customerPages'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/customerList',[customerController::class,'customerList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/customerCreate',[customerController::class,'customerCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/customerupdate',[customerController::class,'customerupdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/customerDelete',[customerController::class,'customerDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/customerById',[customerController::class,'customerById'])->middleware([TokenVerificationMiddleware::class]);