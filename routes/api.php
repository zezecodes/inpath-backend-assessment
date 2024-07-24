<?php

use App\Http\Controllers\DistrictController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
Route::post("/register", [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Region and District Routes
Route::apiResource('regions', RegionController::class);
Route::get('/search-region', [RegionController::class, 'search']);
Route::apiResource('regions/{region}/districts', DistrictController::class);
Route::get('/search-district', [DistrictController::class, 'search']);

// User management Routes
Route::apiResource('users', UserController::class);
Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword']);
Route::post('users/{user}/disable', [UserController::class, 'disable']);
