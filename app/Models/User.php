<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $timestamps = false;
    protected $fillable = [
        'lastname',
        'firstname',
        'login',
        'phone',
        'email',
        'age',
        'student',
        'password',
        'langue',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts()
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';


    /**
     * User's activities relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activity()
    {
        return $this->hasMany(Activity::class);
    }


    /**
     * Get the trips created by the user.
     */
    public function trips()
    {
        return $this->belongsToMany(Trip::class, 'user_trip', 'user_id', 'trip_id');
    }
    /**
     * Retrieves user's activities along with associated pivot data.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getActivities()
    {
        return $this->belongsToMany(Activity::class, 'user_activity', 'created_by', 'activity_id')->withPivot(['place_id', 'duration', 'date', 'duration', 'status', 'start_time', 'end_time']);
    }


    /**
     * Get the trips the user is associated with.
     */
    public function userstrips()
    {
        return $this->belongsToMany(Trip::class, 'user_trip')
            ->withPivot('user_activities')
            ->withTimestamps();
    }
}
