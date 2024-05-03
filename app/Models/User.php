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
        'name',
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

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }



    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    //allows users to recover their activities,
    public function getActivities()
    {
        return $this->belongsToMany(Activity::class, 'user_activity', 'created_by', 'activity_id')->withPivot(['place_id', 'duration', 'date', 'duration', 'status', 'start_time', 'end_time']);
    }
}
