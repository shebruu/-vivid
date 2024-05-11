<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'locality_id',
        'title',
        'adress',
        'postal_code',
        'description',
        'latitude',
        'longitude'

    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'places';
    public $timestamps = false;

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }



    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'user_activities', 'place_id', 'activity_id')->withPivot(['user_id', 'duration', 'status', 'start_time', 'end_time']);
    }

    public function prices()
    {
        return $this->hasMany(Price::class, 'place_id');
    }


    // Relation avec Locality
    public function locality()
    {
        return $this->belongsTo(Locality::class, 'locality_id');
    }
}
