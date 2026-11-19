<?php

use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\PlaywrightController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\ShowCastController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\ShowCrewController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TrainingCategoryController;
use App\Http\Controllers\TrainingItemController;
use App\Http\Controllers\TrainingSessionController;
use App\Http\Controllers\TrainingSessionPersonController;
use App\Http\Controllers\VenueController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::prefix('api/v1')->name('api.v1.')->middleware(['auth', 'verified'])->group(function () {
    Route::apiResource('people', PersonController::class);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('shows', ShowController::class);
    Route::apiResource('show-cast', ShowCastController::class);
    Route::apiResource('show-crew', ShowCrewController::class);
    Route::apiResource('venues', VenueController::class);
    Route::apiResource('seasons', SeasonController::class);
    Route::apiResource('playwrights', PlaywrightController::class);
    Route::apiResource('performances', PerformanceController::class);
    Route::apiResource('tickets', TicketController::class);
    Route::apiResource('training-categories', TrainingCategoryController::class);
    Route::apiResource('training-items', TrainingItemController::class);
    Route::apiResource('training-sessions', TrainingSessionController::class);
    Route::apiResource('training-session-people', TrainingSessionPersonController::class);
});

require __DIR__.'/settings.php';
