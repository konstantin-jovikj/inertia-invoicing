<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // COUNTRIES

    Route::get('/countries', [CountryController::class, 'index'])->name('country.index');
    Route::get('/countries/add', [CountryController::class, 'create'])->name('country.create');
    Route::post('/countries/store', [CountryController::class, 'store'])->name('country.store');
    Route::get('/countries/edit/{country}', [CountryController::class, 'edit'])->name('country.edit');
    Route::put('/countries/update/{country}', [CountryController::class, 'update'])->name('country.update');
    Route::delete('/countries/delete/{country}', [CountryController::class, 'destroy'])->name('country.delete');

    // PLACES

    Route::get('/places', [PlaceController::class, 'index'])->name('place.index');
    Route::get('/places/edit/{place}', [PlaceController::class, 'edit'])->name('place.edit');
    Route::delete('/places/delete/{place}', [PlaceController::class, 'destroy'])->name('place.delete');
    Route::get('/places/add', [PlaceController::class, 'create'])->name('place.create');
    Route::post('/places/store', [PlaceController::class, 'store'])->name('place.store');


});

require __DIR__ . '/auth.php';
