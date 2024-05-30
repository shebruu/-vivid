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
use App\Models\Trip;
use App\Models\ActivityVote;
use App\Models\Booking;

use App\Events\VotesUpdated;

use Carbon\Carbon;

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

        //dump($realizedActivities);

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
        // Répondre avec un message de succès personnalisé
        return response()->json([
            'message' => 'Activity added to your list successfully!',
            'userActivity' => $userActivity
        ], 201);
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

        $this->checkAndUpdateActivityStatus($activity);


        return response()->json(['success' => true, 'message' => 'Vote registered.']);
    }



    private function checkAndUpdateActivityStatus($userActivityId)
    {
        // Récupérer l'activité et le trip
        $activity = UserActivity::find($userActivityId);
        $trip = Trip::with('users')->find($activity->trip_id);

        if ($activity && $trip) {
            $totalParticipants = $trip->users->count();
            $votes = ActivityVote::where('user_activity_id', $userActivityId)->get();
            $totalVotes = $votes->count();

            // Vérifier si tous les participants ont voté
            if ($totalVotes === $totalParticipants) {
                $yesVotes = $votes->where('status', 'yes')->count();
                $yesVotePercentage = ($yesVotes / $totalVotes) * 100;

                // Si plus de 50 % de votes sont positifs, mettre à jour le statut
                if ($yesVotePercentage > 50) {
                    $activity->status = 'revised';
                    $activity->save();
                }
            }
        }
    }


    /**
     * Affiche la liste des activités.
     *
     * @return \Illuminate\View\View
     */
    public function showactivitylist($tripId)
    {

        $trip = Trip::with('users')->findOrFail($tripId);
        $user = auth()->user();

        $activities = DB::table('user_activities')
            ->join('users', 'users.id', '=', 'user_activities.created_by')
            ->join('trips', 'trips.id', '=', 'user_activities.trip_id')
            ->join('activities', 'activities.id', '=', 'user_activities.activity_id')
            ->join('places', 'places.id', '=', 'user_activities.place_id')
            ->leftJoin('prices', 'prices.id', '=', 'user_activities.price_id')


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



            )
            ->where('user_activities.trip_id', $tripId)
            ->where('user_activities.status', 'proposed')

            ->orderBy('users.firstname', 'asc')
            ->get();

        // Récupération des votes pour chaque activité

        foreach ($activities as $activity) {
            $activity->votes = $this->getVotes($activity->activity_id, $tripId);
        }
        $isCreator = $trip->created_by === $user->id;

        //dd($activities);

        // Récupération des participants du voyage
        $participants = DB::table('users')
            ->join('user_trip', 'users.id', '=', 'user_trip.user_id')
            ->where('user_trip.trip_id', $tripId)
            ->select('users.id', 'users.firstname', 'users.lastname')
            ->get();

        // dd($participants);
        return inertia('Mycomponents/activities/ActivityList', [
            'activities' => $activities,

            'selectedTripTitle' => $trip->title,
            'selectedTripId' => $tripId,
            'participants' => $participants,
            'user' => auth()->user(),
            'isCreator' => $isCreator


        ]);
    }


    //get the results of  vote 
    public function getVotes($useractivityId, $tripId)
    {

        $votes = DB::table('activity_votes as av')
            ->join('user_activities as ua', 'ua.id', '=', 'av.user_activity_id')
            ->where('ua.id', $useractivityId)
            ->where('ua.trip_id', $tripId)
            ->selectRaw("COUNT(*) as total_votes, 
                     SUM(CASE WHEN av.status = 'yes' THEN 1 ELSE 0 END) as yes_votes,
                     SUM(CASE WHEN av.status = 'no' THEN 1 ELSE 0 END) as no_votes")
            ->groupBy('ua.id')
            ->first();

        if ($votes) {
            return [
                'total_votes' => $votes->total_votes,
                'yes_votes' => $votes->yes_votes,
                'no_votes' => $votes->no_votes
            ];
        }



        return [
            'total_votes' => 0,
            'yes_votes' => 0,
            'no_votes' => 0
        ];
    }


    public function fetchRevisedActivities($tripId)
    {


        $activities = UserActivity::where('trip_id', $tripId)
            ->where('status', 'revised')
            ->with('activity', 'price')
            ->get()
            ->map(function ($activity) {

                $start = $activity->start_time ? new Carbon($activity->start_time) : null;
                $end = $activity->end_time ? new Carbon($activity->end_time) : null;
                return [
                    'title' => $activity->activity->activity,
                    'start' => $start ? $start->format('c') : null,
                    //    'end' => $end ? $end->format('c') : null,
                    'url' => route('user_activity.show', $activity->id)
                ];
            });

        // dd($activities);


        return response()->json($activities);
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
