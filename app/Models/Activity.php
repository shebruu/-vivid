<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [

        'activity',
        'created_by',

    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activities';


    //an activity belongs to a creator. 
    public function createdby()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function types()
    {
        return $this->belongsToMany(Type::class, 'activity_type');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'activity_category');
    }


    //an activity can be associated with several users via a user_activity pivot table.
    public function participants()
    {
        return $this->belongsToMany(User::class, 'user_activity', 'activity_id', 'created_by')->withPivot(['place_id', 'duration', 'status', 'start_time', 'end_time']);
    }


    public function prices()
    {
        return $this->hasMany(Price::class, 'activity_id');
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
