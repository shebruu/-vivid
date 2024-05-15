<?php

namespace App\Policies;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class TripPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function update(User $user, Trip $trip)
    {
        return $user->id === $trip->created_by;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Trip $trip): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }



    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Trip $trip): bool
    {
        return $user->id === $trip->created_by;
    }

    /**
     * Determine whether the user can add a member to the trip.
     */
    public function addMember(User $user, Trip $trip): bool
    {
        return $user->id === $trip->created_by;
    }

    /**
     * Determine whether the user can remove a member from the trip.
     */
    public function removeMember(User $user, Trip $trip): bool
    {
        return $user->id === $trip->created_by;
    }


    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Trip $trip): bool
    {

        return $user->id === $trip->created_by;
    }

    public function manageMembers(User $user, Trip $trip)
    {
        return $user->id === $trip->created_by;
    }
    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Trip $trip): bool
    {

        return $user->id === $trip->created_by;
    }
}
