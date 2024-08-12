<?php

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
Route::get('/basics',BasicController::class);
Route::get('/test/{test}',[TestController::class, 'show']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/chat/{otherUser}', [ConversationController::class, 'checkConversation']);
    Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store']);
});

# POST ROUTES CRUD ---------------------------
Route::apiResource('post',PostController::class)->middleware('auth:sanctum');
# COMMENT ROUTES -----------------------------------------------------------------------------------
Route::post('/post/{post}/comment',[CommentController::class,'store'])->middleware('auth:sanctum');
