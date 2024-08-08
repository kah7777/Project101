<?php

use App\Events\MessageNotification;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
# POST ROUTES CRUD ---------------------------
Route::resource('post',PostController::class);
# COMMENT ROUTES -----------------------------------------------------------------------------------
Route::post('/post/{post}/comment',[CommentController::class,'store'])->name('post.comments.store');
# EVENTS ROUTES FOR TESTING ---------------------------------------------------------------
Route::get('/event',function(){

});
Route::get('/listen',function(){
    return view('listen');
});
Route::get('/login',function(){
    return 'you are accepted to log in';
})->name('login');
# BIGGENER TEST ROUTE FOR ACCEPTING THE USER

