<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Inertia\Inertia;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserActivityController;


use App\Models\UserActivity;



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


// Routes protégées
Route::middleware(['auth', 'verified'])->group(function () {

    // Tableau de bord
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');



    // Gestion du profil
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });


    // Gestion des voyages
    Route::resource('trips', TripController::class)->names([
        'index' => 'trip.index',
        'create' => 'trip.create',
        'store' => 'trip.store',
        'edit' => 'trip.edit',
        'update' => 'trip.update',
        'destroy' => 'trip.destroy',
        'show' => 'trip.show',
    ]);

    // Gestion des activités utilisateur
    Route::resource('itineraries', UserActivityController::class)->only(['index', 'show', 'create', 'store'])
        ->parameters(['itineraries' => 'useractivity'])
        ->names([
            'index' => 'user_activities.index',
            'show' => 'user_activity.show',
            'create' => 'user_activity.create',
            'store' => 'user_activity.store',
        ]);

    // Formulaire pour les activités validées
    Route::get('/itinerarie/form', [UserActivityController::class, 'showValidatedActivitiesForm'])->name('useractivities.form');


    // Autres pages spécifiques
    Route::get('/finance', function () {
        return Inertia::render('Depenses');
    })->name('expense.index');

    Route::get('/map', function () {
        return Inertia::render('Maps');
    })->name('map.index');
});





// Route pour la déconnexion
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');


// Routes publiques pour les activités
Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
Route::get('/activity/{activity}', [ActivityController::class, 'show'])->name('activity.show');


require __DIR__ . '/auth.php';
