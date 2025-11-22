<?php

use App\Http\Controllers\ActorController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::prefix('actors')->name('actors.')->group(function () {
        Route::get('/', [ActorController::class, 'api'])->name('index');
        Route::get('/prompt-validation', [ActorController::class, 'getPrompt'])->name('prompt');
    });
});
