<?php

use App\Http\Controllers\Api\FieldController;
use App\Http\Controllers\Api\FieldTypeController;
use App\Http\Controllers\Api\FormController;
use App\Http\Controllers\Api\SubmissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Field Types Routes
Route::prefix('field-types')->group(function () {
    Route::get('/', [FieldTypeController::class, 'index']);
    Route::get('/{id}', [FieldTypeController::class, 'show']);
});

// Forms Routes
Route::prefix('forms')->group(function () {
    Route::get('/', [FormController::class, 'index']);
    Route::post('/', [FormController::class, 'store']);
    Route::get('/{id}', [FormController::class, 'show']);
    Route::put('/{id}', [FormController::class, 'update']);
    Route::delete('/{id}', [FormController::class, 'destroy']);
    Route::post('/{id}/duplicate', [FormController::class, 'duplicate']);
});

// Fields Routes
Route::prefix('fields')->group(function () {
    Route::get('/', [FieldController::class, 'index']);
    Route::post('/', [FieldController::class, 'store']);
    Route::get('/{id}', [FieldController::class, 'show']);
    Route::put('/{id}', [FieldController::class, 'update']);
    Route::delete('/{id}', [FieldController::class, 'destroy']);
});

// Submissions Routes
Route::prefix('submissions')->group(function () {
    Route::get('/', [SubmissionController::class, 'index']);
    Route::get('/{id}', [SubmissionController::class, 'show']);
    Route::delete('/{id}', [SubmissionController::class, 'destroy']);
});

// Form Submissions Routes
Route::prefix('forms/{formId}')->group(function () {
    Route::post('/submit', [SubmissionController::class, 'store']);
    Route::post('/submissions/query', [SubmissionController::class, 'query']);
    Route::get('/submissions/statistics', [SubmissionController::class, 'statistics']);
});
