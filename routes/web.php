<?php

use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AssessmentDetailController;
use App\Http\Controllers\BlokController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GrafikAsesmenController;
use App\Http\Controllers\TapperReportController;
use App\Http\Controllers\TreeAssessmentController;
use Illuminate\Support\Facades\Route;

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
Route::get('/grafik-asesmen/sum-chart', [GrafikAsesmenController::class, 'sumChart'])
    ->name('grafik-asesmen.sum-chart');

Route::get('/tapper-report', [TapperReportController::class, 'index'])
    ->name('tapper-report.index');
Route::get('/tapper-report/{nik}', [TapperReportController::class, 'detail'])
    ->name('tapper-report.detail');

Route::get('/tapper-report-chart/{nik}', [TapperReportController::class, 'chart'])
    ->name('tapper-report.chart');
    Route::get('/tapper-report-single-chart/{nik}/{tgl?}', [TapperReportController::class, 'single_chart'])
    ->name('tapper-report.single-chart');

Route::post('/import-assessment', [AssessmentController::class, 'import'])
    ->name('assessment.import-form');

Route::get('/assessment/download-template', [AssessmentController::class, 'downloadTemplate'])
    ->name('assessment.download-template');
