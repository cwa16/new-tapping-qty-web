<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlokController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TreeAssessmentController;
use App\Http\Controllers\AssessmentDetailController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
Route::get('/assessments', [TreeAssessmentController::class, 'index'])
    ->name('assessments.index');
Route::get('/assessment-details', [AssessmentDetailController::class, 'index'])
    ->name('assessment-details.index');
Route::get('/master-blok', [BlokController::class, 'index'])
    ->name('master-blok.index');
