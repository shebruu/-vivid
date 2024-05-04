<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\UserActivity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Afficher toutes les activités réalisées
     */
    public function index()
    {
        // Charger les activités avec leurs participants et lieux
        $activities = Activity::with(['participants', 'place'])
            ->get();

        return inertia('Mycomponents/activities/ActivityList', [
            'activities' => $activities,
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    { {
            $activity->load(['place', 'createdby', 'prices']);
            //  dd($activity);

            return inertia('Mycomponents/activities/Show',  ['activity' => $activity]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        //
    }
}
