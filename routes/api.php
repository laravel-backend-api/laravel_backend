<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\CreatorController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SessionTemplateController;
use App\Http\Controllers\Api\SessionOccurrenceController;

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

// Authenticated routes for regular users
Route::middleware(['auth:sanctum', 'is.user'])->group(function () {
    Route::get('/me', [AuthController::class, 'me'])->name('me');
    Route::put('/me', [AuthController::class, 'updateMe'])->name('update-me');
});

// public routes
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}/subcategories', [CategoryController::class, 'subcategories']);

Route::get('/creators', [CreatorController::class, 'index']);
Route::get('/creators/{id}', [CreatorController::class, 'show']);
Route::get('/creators/{id}/room', [CreatorController::class, 'rooms']);
Route::post('/creator/room', [CreatorController::class, 'storeRoom'])->middleware(['auth:sanctum', 'is.creator']);


// Public routes
Route::get('/sessions', [SessionOccurrenceController::class, 'index']);
Route::get('/sessions/{occurrence}', [SessionOccurrenceController::class, 'show']);

// Routes for authenticated users
Route::middleware('auth:sanctum')->group(function () {

    // Creator routes
    Route::middleware('is.creator')->group(function () {
        Route::post('/creator/session-templates', [SessionTemplateController::class, 'store']);
        Route::post('/creator/session-templates/{template}/rules', [SessionTemplateController::class, 'addRules']);
        Route::post('/creator/session-templates/{template}/generate', [SessionTemplateController::class, 'generateOccurrences']);
        Route::post('/sessions/{occurrence}/drive-link', [SessionOccurrenceController::class, 'addDriveLink']);
    });

    // Booking routes
    Route::middleware('is.user')->group(function () {
        Route::post('/sessions/{occurrence}/book', [BookingController::class, 'book']);
        Route::post('/sessions/{occurrence}/waitlist', [BookingController::class, 'waitlist']);
    });
});
