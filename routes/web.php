<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/user', [AuthenticatedSessionController::class, 'user']);

    Route::post('/upload-post', [PostController::class, 'store']);

    Route::delete('/delete-post', [PostController::class, 'destroy']);
});

Route::post('/upload-image', [PostController::class, 'upload']);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{post}', [PostController::class, 'show']);

require __DIR__.'/auth.php';
