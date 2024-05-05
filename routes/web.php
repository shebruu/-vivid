<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Inertia\Inertia;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\UserActivityController;

use App\Models\UserActivity;



//racine de l app 

Route::get('/', function () {
    // Redirige les utilisateurs authentifiés vers le tableau de bord
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    // Pour les utilisateurs non connectés, rend la page Welcome
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




//listes des activite depuis user activities
Route::get('/itineraries', [UserActivityController::class, 'index'])->middleware(['auth'])->name('user_activities.index');


//detail de l activité
Route::get('/itineraries/{useractivity}', [UserActivityController::class, 'show'])->name('user_activity.show');

//s Formulaire de soumission d'une activité.
Route::get('/itinerarie/form', [UserActivityController::class, 'showValidatedActivitiesForm'])->name('useractivities.form');

//Pour la page détaillée de l' activité.  n a pas marché car il sahit de l id useractivitie
Route::get('/activity/{activity}', [ActivityController::class, 'show'])->name('activity.show');


//Pour afficher liste d activité.
Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');



Route::get('/finance', function () {
    return Inertia::render('Depenses');
})->name('expense.index');

Route::get('/map', function () {
    return Inertia::render('Maps');
})->name('map.index');

Route::get('/travel', function () {
    return Inertia::render('Trips');
})->name('travel.index');


require __DIR__ . '/auth.php';
