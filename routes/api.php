<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes for user authentication
Route::post('/auth/register', [AuthController::class, 'register'])->name('register');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
Route::post('/auth/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}/subcategories', [CategoryController::class, 'subcategories']);

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me'])->name('me');
    Route::put('/me', [AuthController::class, 'updateMe'])->name('update-me');
});
