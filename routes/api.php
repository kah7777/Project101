<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasicController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\MediaLibrary\Conversions\Conversion;

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
# CONV ROUTE -----------------------------------------------------------------------------------------------------------
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/chat/{otherUser}', [ConversationController::class, 'checkConversation']);
    Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store']);
});
# AUTH ROUTE -----------------------------------------------------------------------------------------------------------
Route::post('/register',[AuthController::class,"signUp"]);
Route::post('/login',[AuthController::class,"login"]);
Route::middleware('auth:sanctum')->get('/logout',[AuthController::class,"logoutFromUser"]);
