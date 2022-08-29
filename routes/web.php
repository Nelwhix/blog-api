<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/upload-post', [PostController::class, 'store']);
});



//Route::post('/upload-image', [PostController::class, 'upload']);

require __DIR__.'/auth.php';
