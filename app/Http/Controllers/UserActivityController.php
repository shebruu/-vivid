<?php

namespace App\Http\Controllers;


use App\Models\UserActivity;
use App\Http\Requests\UseractivityRequest;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

use Inertia\Inertia;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Response;


use App\Models\Activity;
use App\Models\Place;
use App\Models\ActivityVote;
use App\Models\Booking;




class UserActivityController extends Controller
{



    public function __construct()
    {
        $this->middleware('auth')->only(['index', 'create', 'store', 'edit', 'update', 'destroy', 'addselectedtolist', 'showactivitylist']);
    }

    // Displays list of validated activities, supports dynamic filtering.
    public function index(Request $request)
    {


        $user = $request->user();
        $searchTerm = $request->input('search', '');

        $realizedActivities = UserActivity::where('status', 'validated')
            ->with(['place.prices', 'place.locality', 'user', 'activity'])
            ->whereHas('place', function ($query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('locality', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('city', 'like', '%' . $searchTerm . '%');
                    });
            })
            ->orWhereHas('activity', function ($query) use ($searchTerm) {
                $query->where('activity', 'like', '%' . $searchTerm . '%');
            })
            ->get()
            ->unique('place.title');

        //  dump($realizedActivities);

        return inertia('Mycomponents/activities/UserActivityList', [
            'activities' => $realizedActivities,
            'user_name' => $user ? $user->name : 'Guest',
        ]);
    }



    // Shows detailed view for a specific user activity, loads related data.
    public function show(UserActivity $useractivity)
    {
        $useractivity->load('place.prices', 'activity.place', 'activity.createdby', 'user', 'user.trips');

        // Récupère les créneaux réservés pour l'activité
        $bookedTimes = Booking::where('user_activity_id', $useractivity->id)
            ->get(['start_time', 'end_time']);

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
            'prices' => $useractivity->place->prices, // Prices come from the activity relationship,
            'placeImages' => $imageFiles,
            'trips' => $useractivity->user->trips,
            'bookedTimes' => $bookedTimes
        ];

        // dump($useractivity);  // instance du modele  UserActivity ( id, act, created, place, duration, status, start) 
        // dump($activityData); //collection de   UserActivity ( champs de places, activity, createdby ..) 

        return inertia('Mycomponents/activities/ShowUseractivity',   [
            'activity' => $activityData['activity'],
            'place' => $activityData['place'],
            'createdby' => $activityData['createdby'],
            'prices' => $activityData['prices'],
            'placeImages' => $activityData['placeImages'],
            'trips' => $activityData['trips'],
            'bookedTimes' => $activityData['bookedTimes']
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



    // Handles addition of a user-selected activity to the database.

    public function addselectedtolist(Request $request)
    {
        // Valider les données de la demande
        $request->validate([
            'activityId' => 'required|exists:activities,id',
            'tripId' => 'required|exists:trips,id',
            'selectedPrice' => 'required|exists:places,id',
            'selectedPrice' => 'nullable|exists:prices,id',
            'selectedDateTime' => 'nullable|date'
        ]);


        $userActivity = new UserActivity();
        $userActivity->activity_id = $request->activityId;
        $userActivity->created_by = auth()->id();
        $userActivity->trip_id = $request->tripId;
        $userActivity->place_id = $request->placeId;
        $userActivity->status = 'proposed';


        if ($request->has('selectedPrice')) {
            $userActivity->price_id = $request->selectedPrice;
        }

        if ($request->has('selectedDateTime')) {
            $userActivity->start_time = new \DateTime($request->selectedDateTime);
        }
        $userActivity->save();
        // Répondre avec la nouvelle activité ajoutée
        return response()->json($userActivity, 201);
    }






    // Handles voting on an activity.
    public function vote(Request $request, $activity)
    {
        $request->validate([
            'vote' => 'required|in:yes,no',
        ]);
        $vote = $request->input('vote');


        //si l utilisateur a deja voté
        $existingVote = ActivityVote::where('user_activity_id', $activity)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingVote) {
            return response()->json(['success' => false, 'message' => 'You have already voted for this activity.'], 403);
        }

        ActivityVote::create([
            'user_id' => auth()->id(),
            'user_activity_id' => $activity,
            'status' => $vote,
        ]);

        return response()->json(['success' => true, 'message' => 'Vote registered.']);
    }



    /**
     * Affiche la liste des activités.
     *
     * @return \Illuminate\View\View
     */
    public function showactivitylist($tripId)
    {
        $activities = DB::table('user_activities')
            ->join('users', 'users.id', '=', 'user_activities.created_by')
            ->join('trips', 'trips.id', '=', 'user_activities.trip_id')
            ->join('activities', 'activities.id', '=', 'user_activities.activity_id')
            ->join('places', 'places.id', '=', 'user_activities.place_id')
            ->leftJoin('prices', 'prices.id', '=', 'user_activities.price_id')
            ->leftJoin('activity_votes', 'activity_votes.user_activity_id', '=', 'user_activities.id')

            ->select(
                'user_activities.id as activity_id',
                'activities.activity as activity_name',
                'users.firstname as user_firstname',
                'users.lastname as user_lastname',
                'trips.title as trip_title',
                'user_activities.start_time',
                'user_activities.duration',
                'user_activities.status',
                'places.title as place_title',
                'prices.amount as price_amount',
                DB::raw("COUNT(activity_votes.id) as total_votes"),
                DB::raw("SUM(case when activity_votes.status = 'yes' then 1 else 0 end) as yes_votes"),
                DB::raw("SUM(case when activity_votes.status = 'no' then 1 else 0 end) as no_votes")
            )
            ->where('user_activities.trip_id', $tripId)
            ->where('user_activities.status', 'proposed')
            ->groupBy('user_activities.id', 'activities.activity', 'users.firstname', 'users.lastname', 'trips.title', 'user_activities.start_time', 'user_activities.duration', 'user_activities.status', 'places.title', 'prices.amount')
            ->orderBy('users.firstname', 'asc')
            ->get();


        //calcul des pourcentages 
        $activitiesWithResults = $activities->map(function ($activity) {
            $activity->yes_percentage = $activity->total_votes ? round(($activity->yes_votes / $activity->total_votes) * 100, 2) : 0;
            $activity->no_percentage = $activity->total_votes ? round((($activity->total_votes - $activity->yes_votes) / $activity->total_votes) * 100, 2) : 0;
            return $activity;
        });

        return inertia('Mycomponents/activities/ActivityList', [
            'activities' => $activities,
            'selectedTripId' => $tripId,


        ]);
    }



    // Caches and returns voting results.
    public function getResults($activityId)
    {
        $results = Cache::remember('votes_activity_' . $activityId, 3600, function () use ($activityId) {
            $votes = ActivityVote::where('activity_id', $activityId)
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get();

            $totalVotes = $votes->sum('total');
            return $votes->mapWithKeys(function ($item) use ($totalVotes) {
                return [$item->status => round(($item->total / $totalVotes) * 100, 2)];
            });
        });

        return response()->json($results);
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
