<?php

use App\Http\Controllers\PhotoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/photos', [PhotoController::class, 'index'])->name('api.photos.index');
Route::get('/photos/{photo}', [PhotoController::class, 'show'])->name('api.photos.show');
