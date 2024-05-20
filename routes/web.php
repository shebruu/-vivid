<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Inertia\Inertia;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TripController;

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\UserActivityController;

use App\Http\Controllers\ActivityVoteController;


use App\Models\UserActivity;
use App\Models\Trip;



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


    Route::resource('bookings', BookingController::class)->names([
        'index' => 'booking.index',
        'create' => 'booking.create',
        'store' => 'booking.store',
        'edit' => 'booking.edit',
        'update' => 'booking.update',
        'destroy' => 'booking.destroy',
        'show' => 'booking.show',
    ]);

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
    Route::post('/trips/{tripId}/addMember', [TripController::class, 'addMemberByLogin'])->name('trip.addmember');
    Route::get('/trips/{tripId}/manage', [TripController::class, 'manageMembers'])->name('trip.manage');
    Route::delete('/trips/{tripId}/members/{userId}', [TripController::class, 'removeMember'])->name('trip.removemember');

    Route::get('/trip/{trip}/activities', [TripController::class, 'showActivities'])->name('trip.activities');

    // Gestion des activités utilisateur
    Route::resource('itineraries', UserActivityController::class)->only(['index', 'show', 'create', 'store', 'edit'])
        ->parameters(['itineraries' => 'useractivity'])
        ->names([
            'index' => 'user_activities.index',
            'show' => 'user_activity.show',
            'create' => 'user_activity.create',
            'store' => 'user_activity.store',
        ]);

    Route::post('/itinerarie/list', [UserActivityController::class, 'addselectedtolist'])->name('itinerarie.addlist');

    Route::get('/itinerarie/list/{tripId}', [UserActivityController::class, 'showactivitylist'])->name('itinerarie.list');


    Route::post('/activities/{activity}/vote', [UserActivityController::class, 'vote'])->name('activities.vote');





    Route::resource('votes', ActivityVoteController::class)->names([
        'index' => 'vote.index',
        'create' => 'vote.create',
        'store' => 'vote.store',
        'edit' => 'vote.edit',
        'update' => 'vote.update',
        'destroy' => 'vote.destroy',
        'show' => 'vote.show',
    ]);

    Route::get('/votes/{useractivityId}/{tripId}', [UserActivityController::class, 'getVotes'])->name('activities.getvote');



    Route::get('/trips/{tripId}/revised-activities', [UserActivityController::class, 'fetchRevisedActivities']);


    Route::get('/trips/{tripId}/calendar', function ($tripId) {
        return Inertia::render('Mycomponents/trips/CalendarPage', ['tripId' => $tripId]);
    })->name('trip.calendar');


    Route::get('/trips/{tripId}/expenses/create', [ExpenseController::class, 'getRevisedActivitiesWithPrices'])->name('expenses.create');

    Route::post('/trips/{tripId}/expenses', [ExpenseController::class, 'store'])->name('expenses.store');




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
