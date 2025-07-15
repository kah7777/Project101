<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasicController;
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

# POST ROUTES CRUD -------------------------------------------------------------------------------------------------------
Route::apiResource('post',PostController::class)->middleware('auth:sanctum');
# COMMENT ROUTES ---------------------------------------------------------------------------------------------------------
Route::apiResource('/post/{post}/comment',CommentController::class)->except(['show','index'])->middleware('auth:sanctum');
# AUTH ROUTE -----------------------------------------------------------------------------------------------------------
Route::post('/register',[AuthController::class,"signUp"]);
Route::post('/login',[AuthController::class,"login"]);
Route::middleware('auth:sanctum')->post('/logout',[AuthController::class,"logout"]);

# PROFILE ROUTE -----------------------------------------------------------------------------------------------------------
Route::middleware('auth:sanctum')->post('/children/update', [ProfileController::class, 'updateChildProfile']);
Route::middleware('auth:sanctum')->post('/doctor/update', [ProfileController::class, 'updateDoctorProfile']);