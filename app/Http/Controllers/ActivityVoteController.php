<?php

namespace App\Http\Controllers;

use App\Models\ActivityVote;

use App\Models\Trip;
use Illuminate\Http\Request;



class ActivityVoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // Récupérer tous les voyages de l'utilisateur authentifié
        $userTrips = $request->user()->trips;

        // Récupérer les activités pour chaque voyage
        $activitiesByTrip = [];
        foreach ($userTrips as $trip) {
            $activitiesByTrip[$trip->id] = $trip->userActivities()->with('activity')->get();
        }

        return view('vote.index', [
            'activitiesByTrip' => $activitiesByTrip,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_activity_id' => 'required|exists:user_activities,id',
            'status' => 'required|in:yes,no',
        ]);
        ActivityVote::create([
            'user_id' => auth()->id(),
            'user_activity_id' => $request->user_activity_id,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Votre vote a été enregistré avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, ActivityVote $vote, $tripId)
    {
        // Récupérer le voyage spécifié
        $trip = Trip::findOrFail($tripId);

        // Vérifier si l'utilisateur appartient au voyage
        if (!$trip->users()->where('user_id', $request->user()->id)->exists()) {
            abort(403, 'Unauthorized');
        }

        // Récupérer les propositions d'activités pour le voyage spécifié
        $proposedActivities = $trip->userActivities()->with('activity')->get();

        return view('vote.show', [
            'trip' => $trip,
            'proposedActivities' => $proposedActivities,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivityVote $vote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActivityVote $vote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityVote $vote)
    {
        //
    }
}
