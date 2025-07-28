<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlokController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TreeAssessmentController;
use App\Http\Controllers\AssessmentDetailController;
use App\Http\Controllers\GrafikAsesmenController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
Route::get('/assessments', [TreeAssessmentController::class, 'index'])
    ->name('assessments.index');
Route::get('/assessment-details', [AssessmentDetailController::class, 'index'])
    ->name('assessment-details.index');

Route::get('/assessment-details/detail', [AssessmentDetailController::class, 'detail'])
    ->name('assessment-details.detail');

Route::group(['prefix' => 'master-blok'], function () {
    Route::get('/', [BlokController::class, 'index'])
        ->name('master-blok.index');
    Route::get('/create', [BlokController::class, 'create'])
        ->name('master-blok.create');
    Route::post('/store', [BlokController::class, 'store'])
        ->name('master-blok.store');
    Route::get('/{id}/edit', [BlokController::class, 'edit'])
        ->name('master-blok.edit');
    Route::put('/{id}', [BlokController::class, 'update'])
        ->name('master-blok.update');
    Route::delete('/{id}', [BlokController::class, 'destroy'])
        ->name('master-blok.destroy');
});

Route::get('/grafik-asesmen', [GrafikAsesmenController::class, 'index'])
    ->name('grafik-asesmen.index');
