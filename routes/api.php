<?php

use App\Http\Controllers\ArticalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasicController;
use App\Http\Controllers\ChildMoodController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

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

# COMMENT ROUTES ---------------------------------------------------------------------------------------------------------
Route::apiResource('/post/{post}/comment',CommentController::class)->except(['show','index'])->middleware('auth:sanctum');
# AUTH ROUTE -----------------------------------------------------------------------------------------------------------
Route::post('/register',[AuthController::class,"signUp"]);
Route::post('/login',[AuthController::class,"login"]);
Route::middleware('auth:sanctum')->post('/logout',[AuthController::class,"logout"]);

# PROFILE ROUTE -----------------------------------------------------------------------------------------------------------
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/children/update', [ProfileController::class, 'updateChildProfile']);
    Route::post('/doctor/update', [ProfileController::class, 'updateDoctorProfile']);
    Route::post('change-password', [ProfileController::class, 'changePassword']);

    # MOOD CHILD -------------------------------------------------------------------------------------------------------------
    Route::post('/mood-my-child', [ChildMoodController::class, 'store']);

    # Articals  -------------------------------------------------------------------------------------------------------------
    Route::post('/add/artical', [ArticalController::class, 'store']);
    Route::delete('/article/{id}', [ArticalController::class, 'destroy']);

});

# Articals  -------------------------------------------------------------------------------------------------------------
Route::get('/articles', [ArticalController::class, 'index']);
Route::get('/article/{id}', [ArticalController::class, 'show']);
