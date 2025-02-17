<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\MediaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/upload', [MediaController::class, 'upload'])->name('upload.store');
Route::get('/upload', [MediaController::class, 'upload'])->name('upload.store');
Route::get('/files', [MediaController::class, 'listFiles'])->name('upload.list');