<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Inertia\Inertia;

//racine de l app 


Route::get('/', function () {
    if (Auth::check()) {

        return Inertia::render('Dashboard');
    }
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

// Route pour la déconnexion
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




Route::get('/itinerarie', function () {
    return Inertia::render('Itinerairies');
})->name('itinerarie.index');

Route::get('/finance', function () {
    return Inertia::render('Depenses');
})->name('financing.index');

Route::get('/map', function () {
    return Inertia::render('Maps');
})->name('map.index');

Route::get('/travel', function () {
    return Inertia::render('Trips');
})->name('travel.index');


require __DIR__ . '/auth.php';
