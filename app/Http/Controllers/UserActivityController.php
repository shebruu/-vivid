<?php

namespace App\Http\Controllers;

use App\Models\UserActivity;
use Illuminate\Http\Request;



class UserActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        //
    }


    /**
     * Display the selection form with realized activities.
     */
    public function showValidatedActivitiesForm()
    {
        // Retrieve all realized activities
        $validatedActivities = UserActivity::where('status', 'validated')
            ->with('activity') // Assumes a relationship exists between UserActivity and Activity
            ->get()
            ->pluck('activity') //extraire directement les activitées


            ->unique();
        // dump($validatedActivities);

        // Pass the activities to the view/component
        return inertia('Mycomponents/activities/UserActivityForm', [
            'activities' => $validatedActivities,
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
        // Validate the input data
        $validated = $request->validate([
            'activity_id' => 'required|exists:activities,id',
            // Additional validation rules for other fields
        ]);

        // Process the data, for example:
        UserActivity::create([
            'activity_id' => $validated['activity_id'],
            // Other necessary data
        ]);

        return redirect()->route('useractivities.index')
            ->with('success', 'User activity created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(UserActivity $userActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserActivity $userActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserActivity $userActivity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserActivity $userActivity)
    {
        //
    }
}
