<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\LikeController;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('logout', [AuthController::class, 'logout']);
Route::post('save', [AuthController::class, 'userInfo'])->middleware('jwtAuth');

//Post route in CRUD sequence
Route::post('posts/create', [PostController::class, 'create'])->middleware('jwtAuth');
Route::get('posts', [PostController::class, 'posts'])->middleware('jwtAuth');
Route::post('posts/update', [PostController::class, 'update'])->middleware('jwtAuth');
Route::post('posts/delete', [PostController::class, 'delete'])->middleware('jwtAuth');

//Comment route in CRUD sequence
Route::post('comments/create', [CommentController::class, 'create'])->middleware('jwtAuth');
Route::post('posts/comments', [CommentController::class, 'comments'])->middleware('jwtAuth');
Route::post('comments/update', [CommentController::class, 'update'])->middleware('jwtAuth');
Route::post('comments/delete', [CommentController::class, 'delete'])->middleware('jwtAuth');


//Comment route in CRUD sequence
Route::post('posts/like', [LikeController::class, 'like'])->middleware('jwtAuth');