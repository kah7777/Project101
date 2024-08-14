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
# EVENTS ROUTES FOR PUSHER (FIRE AN EVENT) ---------------------------------------------------------------
Route::get('/event',function(){

});
# EVENTS ROUTES FOR PUSHER (LISTEN FOR AN EVENT)---------------------------------------------------------------
Route::get('/listen',function(){
    return view('listen');
});
Route::get('/login',function(){
    return 'you are accepted to log in';
})->name('login');
# BIGGENER TEST ROUTE FOR ACCEPTING THE USER

