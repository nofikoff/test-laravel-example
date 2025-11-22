<?php

use App\Http\Controllers\ActorController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('actors.create'));

Route::prefix('actors')->name('actors.')->group(function () {
    Route::get('/', [ActorController::class, 'index'])->name('index');
    Route::get('/create', [ActorController::class, 'create'])->name('create');
    Route::post('/', [ActorController::class, 'store'])->name('store');
    Route::get('/prompt', [ActorController::class, 'showPrompt'])->name('prompt');
});
