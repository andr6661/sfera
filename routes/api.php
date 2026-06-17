<?php

use App\Http\Controllers\Api\DataController;
use Illuminate\Support\Facades\Route;

Route::get('/data', [DataController::class, 'getAllData']);
Route::post('/upload-image', [DataController::class, 'uploadImage']);
Route::post('/directions', [DataController::class, 'updateDirections']);
Route::post('/events', [DataController::class, 'updateEvents']);
Route::post('/statistics', [DataController::class, 'updateStatistics']);
Route::post('/home-texts', [DataController::class, 'updateHomeTexts']);
Route::post('/contacts', [DataController::class, 'updateContacts']);
