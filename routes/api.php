<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Http\Request;
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

Route::post('register',[UserController::class,'store'])->name('user.store');
Route::post('login',[UserController::class,'login'])->name('user.login');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('logout',[UserController::class,'logout'])->name('user.logout');
    Route::get('user',[UserController::class,'index'])->name('user.index');
    Route::get('feedback',[FeedbackController::class,'index'])->name('feedback.index');
    Route::post('feedback',[FeedbackController::class,'store'])->name('feedback.store');
    Route::get('feedback/{id}',[FeedbackController::class,'show'])->name('feedback.show');
    Route::post('comment/{feedback}',[CommentController::class,'store'])->name('comment.store');
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
