<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\ShowPerformanceController;
use App\Http\Controllers\TrainingCategoryController;
use App\Http\Controllers\TrainingItemController;
use App\Http\Controllers\TrainingSessionController;
use App\Http\Controllers\VenueController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard')
;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resources([
        'person' => PersonController::class,
        'trainingCategory' => TrainingCategoryController::class,
        'trainingItem' => TrainingItemController::class,
        'trainingSession' => TrainingSessionController::class,
        'show' => ShowController::class,
        'show.performance' => ShowPerformanceController::class,
        'season' => SeasonController::class,
        'venue' => VenueController::class,
    ]);
});

require __DIR__.'/auth.php';
