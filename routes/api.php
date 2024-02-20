<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


use App\Http\Controllers\UserController;

Route::post('/v1/user/createOrUpdate', [UserController::class, 'createOrUpdate']);
Route::get('/v1/user/getAllUsers', [UserController::class, 'getAllUsers']);
Route::get('/v1/user/getUserByUsername/{username}', [UserController::class, 'getUserByUsername']);
Route::delete('/v1/user/deleteUserByUsername/{username}', [UserController::class, 'deleteUserByUsername']);
