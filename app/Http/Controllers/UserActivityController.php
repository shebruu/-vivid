<?php

namespace App\Http\Controllers;


use App\Models\UserActivity;
use App\Http\Requests\UseractivityRequest;
use Illuminate\Http\Request;

use App\Models\Activity;
use App\Models\Place;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

use Inertia\Inertia;

use Illuminate\Http\Response;



class UserActivityController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth')->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {



        $user = $request->user();
        $realizedActivities = UserActivity::where('status', 'validated')
            ->with(['activity.prices', 'place', 'user'])
            ->get();
        //dump($realizedActivities);

        return inertia('Mycomponents/activities/UserActivityList', [
            'activities' => $realizedActivities,
            'user_name' => $user ? $user->name : 'Guest',
        ]);
    }



    public function show(UserActivity $useractivity)
    {
        $useractivity->load('activity.prices', 'activity.place', 'activity.createdby', 'user', 'user.trips');
        $placeTitle = $useractivity->place->title;
        $folderPath = public_path("images/{$placeTitle}");


        $imageFiles = [];
        if (is_dir($folderPath)) {
            $files = scandir($folderPath);
            foreach ($files as $file) {
                if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
                    $imageFiles[] = "/images/{$placeTitle}/{$file}";
                }
            }
        }


        $activityData = [
            'activity' => $useractivity->activity,
            'place' => $useractivity->place, // UserActivity has a direct place association
            'createdby' => $useractivity->user, // User who created the user activity
            'prices' => $useractivity->activity->prices, // Prices come from the activity relationship,
            'placeImages' => $imageFiles,
            'usertrips' => $useractivity->user->trips
        ];
        // dd($useractivity);  // instance du modele  UserActivity ( id, act, created, place, duration, status, start) 
        dd($activityData); //collection de   UserActivity ( champs de places, activity, createdby ..) 

        return inertia('Mycomponents/activities/ShowUseractivity',   [
            'activity' => $activityData['activity'],
            'place' => $activityData['place'],
            'createdby' => $activityData['createdby'],
            'prices' => $activityData['prices'],
            'placeImages' => $activityData['placeImages'],
            'trips' => $activityData['usertrips']
        ]);
    }


    /**
     * Display the selection form with realized activities.
     */
    public function showValidatedActivitiesForm()
    {

        $validatedActivities = UserActivity::where('status', 'validated')
            ->with('activity')
            ->get()
            ->pluck('activity') //extraire directement les activitées


            ->unique();
        // dump($validatedActivities);


        return Inertia::render('UserActivityForm', [
            'activities' => $validatedActivities,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Mycomponents/activities/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserActivityRequest $urequest)
    {
        Log::info('Entering the store method of UserActivityController at' . now());
        //dd($urequest->all());
        $place = Place::create([

            'adress' => $urequest->adress,
            'postal_code' => $urequest->postal_code,
        ]);

        $activity = Activity::create([
            'activity'    => $urequest->activity,
            //  'place_id' => $place->id,
            'price'    => [
                'amount'     => $urequest->amount,
                'age_range'  => $urequest->input('age_range'),
                'season'     => $urequest->input('season'),
            ]
        ]);
        $userActivity = UserActivity::create([
            'created_by' => auth()->id(),
            'place_id'    => $place->id,
            'activity_id' => $activity->id,
            'duration'    => $urequest->duration,
            'start_time'  => $urequest->start_time,
            'status' => 'proposed'
        ]);


        return response()->json(['success' => true, 'message' => 'Activité ajoutée avec succès']);
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
