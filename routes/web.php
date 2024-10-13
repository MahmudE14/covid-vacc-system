<?php

use App\Http\Controllers\VaccinationSearchController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Route::has('register'),
    ]);
});

Route::get('/search', [VaccinationSearchController::class, 'index'])->name('search-page');
Route::get('/search-status', [VaccinationSearchController::class, 'search'])->name('search-status');

require __DIR__.'/auth.php';
