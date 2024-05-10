<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'created_by',
        'title',
        'slug',
        'departure',
        'arrival',
        'totalestimation',
        'note'

    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trips';

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'user_trip')
            ->withPivot('user_activities')
            ->withTimestamps();
    }

    public function activities()
    {
        return $this->hasManyThrough(Activity::class, User::class, 'user_trip', 'user_id', 'id', 'activity_id');
    }
}
