<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DataController;
use App\Http\Controllers\DiseaseDetectionController;
use App\Http\Controllers\AiController;


// Data
Route::post('/data/record', [DataController::class, 'record'])
    ->name('data.record');

Route::get('/', [DataController::class, 'data'])
    ->name('data');

Route::resource('index', DataController::class);

Route::get('/data', [DataController::class, 'data'])
    ->name('data');


// Disease Detection
Route::get('/disease-detection', [DiseaseDetectionController::class, 'index'])
    ->name('disease.index');

Route::post('/disease-detection/analyze', [DiseaseDetectionController::class, 'analyze'])
    ->name('disease.analyze');


// AI Prediction
Route::get('/ai', [AiController::class, 'index'])
    ->name('ai.index');

Route::post('/ai/predict', [AiController::class, 'predict'])
    ->name('ai.predict');


// Other pages
Route::get('/lettuce-guide', function () {
    return view('lettuce-guide');
})->name('lettuce.guide');

Route::get('/control', function () {
    return view('control');
})->name('control');
