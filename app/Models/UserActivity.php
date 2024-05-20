<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [

        'activity_id',
        'created_by',
        'place_id',
        'duration',
        'status',
        'start_time',
        'trip_id',
        'price_id'



    ];


    protected $dates = ['start_time', 'end_time'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_activities';


    /**
     * Get the user who created the activity.
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the place associated with the user activity.
     */
    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id');
    }


    /**
     * Get the trips associated with the user activity.
     */
    public function trips()
    {
        return $this->hasMany(Trip::class, 'trip_id');
    }

    /**
     * Get the bookings for the user activity.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
