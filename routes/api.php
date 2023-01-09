<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\API\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users', [UserController::class, 'index']);

Route::get('/users/{id}', [UserController::class, 'show']);

Route::get('/users/{id}/cars', [UserController::class, 'showAllCars']);

Route::get('/cars/{id}', [CarController::class, 'show']);

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::delete('/cars/{id}/delete', [CarController::class, 'destroy']);

    Route::post('/cars/create', [CarController::class, 'create']);

    Route::put('/cars/{id}/edit', [CarController::class, 'edit']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
