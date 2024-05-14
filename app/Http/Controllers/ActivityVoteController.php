<?php

namespace App\Http\Controllers;

use App\Models\ActivityVote;
use Illuminate\Http\Request;

class ActivityVoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
        $request->validate([
            'user_activity_id' => 'required|exists:user_activities,id',
            'status' => 'required|in:yes,no',
        ]);
        ActivityVote::create([
            'user_id' => auth()->id(),
            'user_activity_id' => $request->user_activity_id,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Votre vote a été enregistré avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ActivityVote $vote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivityVote $vote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActivityVote $vote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityVote $vote)
    {
        //
    }
}
