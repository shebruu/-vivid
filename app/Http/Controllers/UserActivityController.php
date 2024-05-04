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
        // Charger les activités validées dans `user_activities` avec les relations nécessaires
        //gerer les filtres selon les inpus user 
        /*
    Obtenir les filtres de la requête
    $locality = $request->input('locality');
    $type = $request->input('type');
    $price = $request->input('price');

      if ($locality) {
        $query->whereHas('place', function ($query) use ($locality) {
            $query->where('locality', $locality);
        });
    }

    if ($type) {
        $query->whereHas('activity', function ($query) use ($type) {
            $query->where('type', $type);
        });
    }

    if ($price) {
        // Exemple: comparer les activités qui ont un prix inférieur ou égal à la valeur entrée
        $query->where('price', '<=', $price);
    }

    $realizedActivities = $query->get();
        
         */
        $realizedActivities = UserActivity::where('status', 'validated')
            ->with(['activity.prices', 'place', 'user'])
            ->get();
        dump($realizedActivities);

        return inertia('Mycomponents/activities/UserActivityList', [
            'activities' => $realizedActivities,
        ]);
    }



    public function show(UserActivity $useractivity)
    {
        $useractivity->load('activity.prices', 'activity.place', 'activity.createdby', 'user');
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
            'placeImages' => $imageFiles
        ];
        // dd($useractivity);  // instance du modele  UserActivity ( id, act, created, place, duration, status, start) 
        //  dd($activityData); //collection de   UserActivity ( champs de places, activity, createdby ..) 

        return inertia('Mycomponents/activities/ShowUseractivity',   [
            'activity' => $activityData['activity'],
            'place' => $activityData['place'],
            'createdby' => $activityData['createdby'],
            'prices' => $activityData['prices'],
            'placeImages' => $activityData['placeImages'] //
        ]);
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
