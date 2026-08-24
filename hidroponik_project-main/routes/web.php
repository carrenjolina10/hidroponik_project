<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\DiseaseDetectionController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('index', DataController::class);

Route::get('/data', [DataController::class, 'data'])
    ->name('data');

Route::get('/disease-detection', [DiseaseDetectionController::class, 'index'])
    ->name('disease.index');

Route::post('/disease-detection/analyze', [DiseaseDetectionController::class, 'analyze'])
    ->name('disease.analyze');

Route::get('/ai', function () {
    return view('ai');
})->name('ai');

Route::post('/ai/predict', [App\Http\Controllers\AiController::class, 'predict'])->name('ai.predict');