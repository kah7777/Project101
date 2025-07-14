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

# BASICS ROUTE (A BASIC IS A COLLCETION FOR BIGGENER FRIENDLY TEST TO TEST IF PAIENT IS AUTISITC OR NOT) -----------------------------------------------------------------------------------------------------------
Route::get('/basics',BasicController::class);
# POST ROUTES CRUD -------------------------------------------------------------------------------------------------------
Route::apiResource('post',PostController::class)->middleware('auth:sanctum');
# COMMENT ROUTES ---------------------------------------------------------------------------------------------------------
Route::apiResource('/post/{post}/comment',CommentController::class)->except(['show','index'])->middleware('auth:sanctum');
# TEST ROUTE -----------------------------------------------------------------------------------------------------------
Route::get('/test/score',[TestController::class,'isDone'])->middleware(['auth:sanctum','guardian']);
# AUTH ROUTE -----------------------------------------------------------------------------------------------------------
Route::post('/register',[AuthController::class,"signUp"]);
Route::post('/login',[AuthController::class,"login"]);
Route::middleware('auth:sanctum')->post('/logout',[AuthController::class,"logout"]);

# PROFILE ROUTE -----------------------------------------------------------------------------------------------------------
Route::middleware('auth:sanctum')->post('/children/update', [ProfileController::class, 'updateChildProfile']);