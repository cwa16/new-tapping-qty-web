<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AssessmentApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Assessment Upload API Route
Route::post('/assessment-upload', [AssessmentApiController::class, 'store']);
