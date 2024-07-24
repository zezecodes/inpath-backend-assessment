<?php

use App\Http\Controllers\DistrictController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
Route::post("/register", [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('regions', RegionController::class);
Route::get('/search', [RegionController::class, 'search']);

Route::apiResource('regions/{region}/districts', DistrictController::class);
Route::get('/search', [DistrictController::class, 'search']);

Route::apiResource('users', UserController::class);
Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword']);
Route::post('users/{user}/disable', [UserController::class, 'disable']);
