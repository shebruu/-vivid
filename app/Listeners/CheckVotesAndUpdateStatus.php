<?php

namespace App\Listeners;



use App\Events\VotesUpdated;
use App\Models\UserActivity;
use App\Models\ActivityVote;
use App\Models\Trip;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckVotesAndUpdateStatus
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(VotesUpdated $event): void
    {
        $userActivityId = $event->userActivityId;
        $tripId = $event->tripId;


        $activity = UserActivity::find($userActivityId);
        $trip = Trip::with('users')->find($tripId);

        if ($activity && $trip) {
            $totalParticipants = $trip->users->count();
            $votes = ActivityVote::where('user_activity_id', $userActivityId)->get();
            $totalVotes = $votes->count();

            // Vérifier si tous les participants ont voté
            if ($totalVotes === $totalParticipants) {
                $yesVotes = $votes->where('status', 'yes')->count();
                $yesVotePercentage = ($yesVotes / $totalVotes) * 100;

                // mettre à jour le statut
                if ($yesVotePercentage > 50) {
                    $activity->status = 'revised';
                    $activity->save();
                }
            }
        }
    }
}
