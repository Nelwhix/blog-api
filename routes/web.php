<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/user', [AuthenticatedSessionController::class, 'user']);

    Route::post('/upload-post', [PostController::class, 'store']);

    Route::delete('/posts/{post}', [PostController::class, 'destroy']);

    Route::put('/posts/{post}', [PostController::class, 'update']);

});

Route::post('/upload-image', [PostController::class, 'upload']);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{post}', [PostController::class, 'show']);

Route::get('/ping', function () {
    return response("pong @". \Carbon\Carbon::now() . "UTC", 200);
});

require __DIR__.'/auth.php';
