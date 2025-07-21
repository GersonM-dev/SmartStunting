<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnakController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PredictionRecordController;
use App\Http\Controllers\AntropometryRecordController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->apiResource('anak', AnakController::class);
Route::middleware('auth:sanctum')->apiResource('antropometry-record', AntropometryRecordController::class);
Route::middleware('auth:sanctum')->apiResource('prediction-record', PredictionRecordController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'profile']);        // GET current user's profile
    Route::put('/user', [UserController::class, 'update']);         // UPDATE profile
    Route::delete('/user', [UserController::class, 'destroy']);     // DELETE account
});