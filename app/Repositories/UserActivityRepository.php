<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class UserActivityRepository implements UserActivityRepositoryInterface
{

    public function getValidatedUserActivities()
    {
        $results = DB::table('user_activities')
            ->join('activities', 'user_activities.activity_id', '=', 'activities.id')
            ->join('places', 'user_activities.place_id', '=', 'places.id')
            ->join('users', 'user_activities.created_by', '=', 'users.id')
            ->where('user_activities.status', '=', 'validated')
            ->get(['activities.*', 'places.*', 'users.firstname as user_name']);
        //  dd($results);
        return $results;
    }

    public function getUserActivityDetails($userActivityId)
    {

        return DB::table('user_activities')
            ->join('activities', 'user_activities.activity_id', '=', 'activities.id')
            ->where('user_activities.id', '=', $userActivityId)
            ->first();
    }


    public function getValidatedActivities()
    {

        return DB::table('user_activities')
            ->join('activities', 'user_activities.activity_id', '=', 'activities.id')
            ->where('status', 'validated')
            ->distinct()
            ->get(['activities.*']);
    }
}
