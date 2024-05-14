<?php

namespace App\Http\Controllers;

use App\Models\Trip;

use App\Models\User;
use Illuminate\Http\Request;

use Inertia\Inertia;

use Illuminate\Routing\Controller;
use App\Http\Requests\TripRequest;
use Illuminate\Support\Str;


//use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

//pour autorisation
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class TripController extends Controller
{

    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth')->only(['index', 'create', 'store', 'edit', 'update', 'destroy', 'addMemberByLogin']);
    }

    /**
     * Affiche une liste des voyages créés par l'utilisateur authentifié.
     *
     */
    public function index()
    {
        $userId = Auth::id();

        $trips = Trip::where('created_by', $userId)->with('creator', 'users')->get();
        // dd($trips);


        return Inertia::render('Mycomponents/trips/Trips', [
            'usertrips' => $trips,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Mycomponents/trips/Create');
    }



    /**
     * Stocke un nouveau voyage dans la base de données.
     * Valide et traite les données reçues du formulaire avant de créer le voyage.
     */
    public function store(TripRequest $request)
    {


        //les data qui arrivent au controller de http post
        // dd($request->all());
        $validatedData = $request->validated();

        // Génération du slug à partir du titre
        $slug = Str::slug($validatedData['title']);

        // Ajout du slug aux données validées
        $validatedData['slug'] = $slug;

        // Ajout de l'ID de l'utilisateur créant le voyage
        $validatedData['created_by'] = auth()->id();


        $trip = Trip::create($validatedData);
        return response()->json(['message' => 'Voyage créé avec succès'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip)
    {

        $user = Auth::user();
        // dd($trip);
        return Inertia::render('Mycomponents/trips/Show', [
            'trip' => $trip, 'canEdit' => $user->can('update', $trip),
            'canDelete' => $user->can('delete', $trip),
            'canAddMember' => $user->can('addMember', $trip),
            'canRemoveMember' => $user->can('removeMember', $trip)
        ]);
    }

    /**
     * Charge les activités associées à un voyage.
     * 
     */
    public function showActivities(Trip $trip)
    {

        $trip->load('users.activities');
        // dd($trip);
        return Inertia::render('ActivitiesList', [
            'trip' => $trip,
            'activities' => $trip->users->flatMap->activities
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trip $trip)
    {
        return Inertia::render('Mycomponents/trips/Show', ['trip' => $trip]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TripRequest $request, Trip $trip)
    {
        $this->authorize('update', $trip);
        $validatedData = $request->validated();
        $trip->update($validatedData);
        return redirect()->route('trip.show', ['trip' => $trip->id])->with('success', 'Voyage modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {
        $this->authorize('delete', $trip);

        $trip->delete();
        return redirect()->route('trips.index')->with('success', 'Voyage supprimé avec succès.');
    }

    /**
     * Ajoute un membre à un voyage via son login.
     * Valide le login, recherche l'utilisateur, et l'ajoute au voyage.
     */
    public function addMemberByLogin(Request $request, $tripId)
    {
        $request->validate([
            'login' => 'required|string|exists:users,login'
        ]);


        $user = User::where('login', $request->input('login'))->first();
        if (!$user) {
            return redirect()->back()->withErrors(['login' => 'No user found with this login.']);
        }
        $trip = Trip::findOrFail($tripId);

        $this->authorize('addMember', $trip, $user);
        if ($trip->users()->where('users.id', $user->id)->exists()) {
            return redirect()->back()->withErrors(['login' => 'Member already added.']);
        }
        $trip->users()->attach($user->id);
        return redirect()->back()->with('success', 'Membre ajouté avec succès.');
    }


    public function manageMembers($tripId)
    {
        $trip = Trip::with('users')->findOrFail($tripId);
        return Inertia::render('Mycomponents/trips/MemberManagement', [
            'trip' => $trip,
            'auth' => [
                'user' => auth()->user()  // Assurez-vous que l'utilisateur est authentifié
            ]
        ]);
    }

    public function removeMember(Request $request, $tripId, $userId)
    {
        $trip = Trip::findOrFail($tripId);
        $user = User::findOrFail($userId);

        $this->authorize('removeMember', $trip);
        // Détacher l'utilisateur du voyage
        $trip->users()->detach($user->id);

        return redirect()->back()->with('success', 'Member successfully removed.');
    }
}
