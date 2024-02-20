<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;

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
    return view('welcome');
});

// User routes
Route::post('api/v1/user/createOrUpdate', [UserController::class, 'createOrUpdate']);
Route::get('api/v1/user/getAllUsers', [UserController::class, 'getAllUsers']);
Route::get('api/v1/user/getUserByUsername/{username}', [UserController::class, 'getUserByUsername']);
Route::delete('api/v1/user/deleteUserByUsername/{username}', [UserController::class, 'deleteUserByUsername']);

// Book routes
Route::post('api/v1/book/createOrUpdate', [BookController::class, 'createOrUpdate']);
Route::get('api/v1/book/getBooks', [BookController::class, 'getBooks']);
Route::get('api/v1/book/getBookByName/{name}', [BookController::class, 'getBookByName']);
Route::delete('api/v1/book/deleteBookByName/{name}', [BookController::class, 'deleteBookByName']);
