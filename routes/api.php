<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PhotoRandomController;
use App\Http\Controllers\PhotoSearchController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/photos', [PhotoController::class, 'index'])->name('api.photos.index');
Route::get('/photos/{photo}', [PhotoController::class, 'show'])->name('api.photos.show');

Route::get('/random/photo', PhotoRandomController::class)->name('api.photos.random');
Route::get('/search/photos', PhotoSearchController::class)->name('api.photos.search');
