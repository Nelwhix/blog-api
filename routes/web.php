<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/upload-post', [PostController::class, 'store']);
});

Route::post('/upload-image', [PostController::class, 'upload']);
Route::get('/posts', [PostController::class, 'index']);

require __DIR__.'/auth.php';
