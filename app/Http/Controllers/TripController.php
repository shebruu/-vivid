<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

use Inertia\Inertia;

use Illuminate\Routing\Controller;
use App\Http\Requests\TripRequest;

use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        $trips = Trip::where('created_by', $userId)->get();
        //dd($trips);

        return Inertia::render('Mycomponents/trips/Trips', [
            'usertrips' => $trips,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Mycomponents/trips/Trips');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validated();
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
        return redirect()->route('Mycomponents/trips/Show', ['trip' => $trip->id])->with('success', 'Voyage modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {
        //
    }
}
