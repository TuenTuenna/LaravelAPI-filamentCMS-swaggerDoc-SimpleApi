<?php

use App\Http\Controllers\Api\v1\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// root/api/v1/post ->
Route::prefix('/v1')->group(function (){
    Route::resource('posts', PostController::class);
//    Route::controller(PostController::class)->group(function (){
//        Route::get('/posts', 'index');
//        Route::get('/posts/{id}', 'show');
//        Route::delete('/posts/{id}', 'destroy');
//        Route::put('/posts/{id}', 'update');
//        Route::post('/posts', 'store');
//    });
});


