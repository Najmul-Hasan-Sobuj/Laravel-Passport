<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('logout ', [AuthController::class, 'logout']);

    Route::get('books', [BookController::class, 'index']);
    Route::get('author-books', [BookController::class, 'authorBook']);
    Route::post('books', [BookController::class, 'store']);
    Route::get('books/{id}/edit', [BookController::class, 'edit']);
    Route::put('books/{id}', [BookController::class, 'update']);
    Route::delete('books/{id}', [BookController::class, 'delete']);
});
