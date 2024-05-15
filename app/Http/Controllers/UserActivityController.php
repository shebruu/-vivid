<?php

namespace App\Http\Controllers;


use App\Models\UserActivity;
use App\Http\Requests\UseractivityRequest;
use Illuminate\Http\Request;

use App\Models\Activity;
use App\Models\Place;
use App\Models\Booking;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

use Inertia\Inertia;

use Illuminate\Http\Response;



class UserActivityController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth')->only(['index', 'create', 'store', 'edit', 'update', 'destroy', 'addselectedtolist', 'showactivitylist']);
    }

    /**
     * Méthode index pour afficher la liste des activités validées avec possibilité de filtrage.
     * Utilise le chargement préalable pour optimiser les performances des requêtes et la gestion des relations.
     * Applique un filtrage dynamique basé sur le terme de recherche fourni par l'utilisateur.
     *
     * @param Request $request La requête HTTP entrante
     * @return \Inertia\Response Renvoie une réponse Inertia avec les activités filtrées et le nom de l'utilisateur.
     */
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
            ->get();
        //  dump($realizedActivities);

        return inertia('Mycomponents/activities/UserActivityList', [
            'activities' => $realizedActivities,
            'user_name' => $user ? $user->name : 'Guest',
        ]);
    }



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



    //ajoute les activité a la db  pour proposer

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
     * Affiche la liste des activités.
     *
     * @return \Illuminate\View\View
     */
    public function showactivitylist($selectedTripId)
    {
        // Récupérer toutes les activités depuis la base de données
        $activities = UserActivity::where('created_by', auth()->id())
            ->where('trip_id', $selectedTripId)
            ->where('status', 'proposed')
            ->get();


        // Partager les données avec Inertia
        Inertia::share('activities', $activities);
        Inertia::share('selectedTripId', null);

        // Ne pas rendre la vue ici, car ActivityList est un composant React
        return inertia('Mycomponents/activities/ActivityList', [
            'activities' => $activities,
            'selectedTripId' => $selectedTripId,


        ]);
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
