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



    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_activities';


    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id');
    }
}
