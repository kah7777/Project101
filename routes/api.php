<?php

use App\Http\Controllers\LearningController;
use App\Http\Controllers\ArticalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ChildMoodController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
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
Route::apiResource('/post/{post}/comment', CommentController::class)->except(['show', 'index'])->middleware('auth:sanctum');
# AUTH ROUTE -----------------------------------------------------------------------------------------------------------
Route::post('/register', [AuthController::class, "signUp"]);
Route::post('/login', [AuthController::class, "login"]);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, "logout"]);

Route::middleware('auth:sanctum')->group(function () {
    # PROFILE ROUTE -----------------------------------------------------------------------------------------------------------
    Route::post('/children/update', [ProfileController::class, 'updateChildProfile']);
    Route::post('/doctor/update', [ProfileController::class, 'updateDoctorProfile']);
    Route::post('change-password', [ProfileController::class, 'changePassword']);
    Route::get('/profile', [ProfileController::class, 'getProfile']);
    Route::delete('/account', [ProfileController::class, 'destroy']);

    # AVATAR -------------------------------------------------------------------------------------------------------------------
    Route::post('/user/avatar', [ProfileController::class, 'updateAvatar']);
    Route::delete('/user/avatar', [ProfileController::class, 'deleteAvatar']);
    Route::get('/user/avatar', [ProfileController::class, 'getAvatar']);

    # MOOD CHILD -------------------------------------------------------------------------------------------------------------
    Route::post('/mood-my-child', [ChildMoodController::class, 'store']);

    # Articals  -------------------------------------------------------------------------------------------------------------
    Route::post('/add/artical', [ArticalController::class, 'store']);
    Route::delete('/article/{id}', [ArticalController::class, 'destroy']);

    # Exercise  -------------------------------------------------------------------------------------------------------------
    Route::post('/exercises', [ExerciseController::class, 'store']);
    Route::delete('/exercises/{id}', [ExerciseController::class, 'destroy']);
    Route::get('/exercises/my', [ExerciseController::class, 'myExercises']);


    # Learning  -------------------------------------------------------------------------------------------------------------

    Route::get('/learnings', [LearningController::class, 'myLearnings']);
    Route::get('/learnings/{id}', [LearningController::class, 'showLearning']);
    Route::get('/my-learnings-by-category/{category}', [LearningController::class, 'byCategory']);

    // Posts  -------------------------------------------------------------------------------------------------------------
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::post('/posts/like/{post}', [PostController::class, 'like']);
    Route::post('/posts/unlike/{post}', [PostController::class, 'unlike']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);

    // Comments -------------------------------------------------------------------------------------------------------------
    Route::get('/posts/comments/{post}', [CommentController::class, 'index']);
    Route::get('/comments/reply/{comment}', [CommentController::class, 'replies']);
    Route::post('/posts/comments/{post}', [CommentController::class, 'store']);
    Route::post('/comments/like/{comment}', [CommentController::class, 'like']);
    Route::post('/comments/unlike/{comment}', [CommentController::class, 'unlike']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);

    // Diagnosis -------------------------------------------------------------------------------------------------------------
    Route::post('/diagnoses', [DiagnosisController::class, 'store']);
    Route::get('/diagnoses/last', [DiagnosisController::class, 'showLast']);

    // Message -------------------------------------------------------------------------------------------------------------
    Route::post('/messages', [MessageController::class, 'store']);

});

# Articals  -------------------------------------------------------------------------------------------------------------
Route::get('/articles', [ArticalController::class, 'index']);
Route::get('/article/{id}', [ArticalController::class, 'show']);

# Exercise  -------------------------------------------------------------------------------------------------------------
Route::get('/exercises/{id}', [ExerciseController::class, 'show']);
Route::get('/exercises/category/{category}', [ExerciseController::class, 'byCategory']);
Route::get('/exercises', [ExerciseController::class, 'index']);
