<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\KeluhanController;
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
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group(function () {
    //aplikasi
    Route::get('/me', [AuthController::class, 'getUsers'])->name('getUsers');
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/listKonsultasi',  [ChatController::class, 'listKonsultasi']);
    Route::get('/listKeluhan',  [KeluhanController::class, 'listKeluhan']);
    Route::get('/listKeluhanById/{id}',  [KeluhanController::class, 'listKeluhanById']);
});

Route::get('/messages',  [ChatController::class, 'messages']);
Route::post('/addMessage',  [ChatController::class, 'addMessage']);
Route::post('/addKeluhan',  [KeluhanController::class, 'addKeluhan']);
Route::post('/addJawaban',  [KeluhanController::class, 'addJawaban']);
Route::get('/keluhan/{id}',  [KeluhanController::class, 'keluhan']);