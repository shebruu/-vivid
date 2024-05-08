<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

use Inertia\Inertia;

use Illuminate\Routing\Controller;
use App\Http\Requests\TripRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\User;

class TripController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth')->only(['index', 'create', 'store', 'edit', 'update', 'destroy', 'addMemberByLogin']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        $trips = Trip::where('created_by', $userId)->get();
        //dd($trips);

        //$userActivities = User::find($userId)->trips;
        // dd($userActivities);
        return Inertia::render('Mycomponents/trips/Trips', [
            'usertrips' => $trips,
            //  'useractivities' => $userActivities,
            //  'auth' => Auth::user(),

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
     * Store a newly created resource in storage.
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

        // dd($trip);
        return Inertia::render('Mycomponents/trips/Show', ['trip' => $trip]);
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
        $validatedData = $request->validated();
        $trip->update($validatedData);
        return redirect()->route('trip.show', ['trip' => $trip->id])->with('success', 'Voyage modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {
        //
    }



    public function addMemberByLogin(Request $request, Trip $trip)
    {
        $validatedData = $request->validate([
            'login' => 'required|string',
            'user_activities' => 'nullable|integer'
        ]);

        // Attach the user to the trip with additional data
        $trip->users()->attach($validatedData['user_id'], [
            'user_activities' => $validatedData['user_activities'] ?? null
        ]);


        return redirect()->route('trip.show', ['trip' => $trip->id])
            ->with('success', 'Membre ajouté au voyage.');
    }
}
