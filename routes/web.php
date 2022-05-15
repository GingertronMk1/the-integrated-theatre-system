<?php

use App\Http\Controllers\ShowController;
use App\Http\Controllers\TrainingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resources([
        'show' => ShowController::class,
        'training' => TrainingController::class,
    ]);
});

require __DIR__ . '/auth.php';
