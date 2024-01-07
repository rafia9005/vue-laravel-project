<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/post', [PostController::class, 'index']);
    Route::post('/post', [PostController::class, 'create']);
    Route::delete('/post/{id}', [PostController::class, 'delete']);
    Route::get('/post/{id}', [PostController::class, 'show']);
    Route::put('/post/{id}', [PostController::class, 'update']);
    Route::middleware('admin')->group(function(){
        // admin only
    });
});