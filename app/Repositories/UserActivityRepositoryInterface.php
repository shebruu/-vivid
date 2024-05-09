<?php

namespace App\Repositories;

interface UserActivityRepositoryInterface
{
    public function getValidatedUserActivities();
    public function getUserActivityDetails($userActivityId);
    public function getValidatedActivities();
}
