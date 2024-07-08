<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodolistController;
use App\Http\Middleware\JwtMiddleware;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware([JwtMiddleware::class])->group(function() {
    Route::get('/todos', [TodolistController::class, 'show'])->withoutMiddleware([JwtMiddleware::class]);
    Route::post('/todos', [TodolistController::class, 'create'])->withoutMiddleware([JwtMiddleware::class]);
    Route::put('/todos/{id}', [TodolistController::class, 'update']);
    Route::delete('/todos/{id}', [TodolistController::class, 'delete']);
});
    

