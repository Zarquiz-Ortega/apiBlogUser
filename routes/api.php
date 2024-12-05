<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CommentsController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
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

//Ritas para la api

// User Router
Route::get('users', [UserController::class, 'index']);
Route::post('users', [UserController::class, 'store']);
Route::get('users/blogs', [UserController::class, 'getUserWhitoutBlog']);
Route::get('users/{user}', [UserController::class, 'show']);
Route::put('users/{user}', [UserController::class, 'update']);
Route::delete('users/{user}', [UserController::class, 'destroy']);


Route::apiResource('blogs', BlogController::class);
Route::apiResource('posts', PostController::class);
Route::apiResource('comments', CommentsController::class);


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
