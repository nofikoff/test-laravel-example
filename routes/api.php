<?php

use App\Http\Controllers\ActorController;
use Illuminate\Support\Facades\Route;

Route::get('/actors/prompt-validation', [ActorController::class, 'getPrompt']);
