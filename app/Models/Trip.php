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
        return $this->belongsToMany(User::class, 'user_trip');
    }


    /* pour accéder à des relations éloignées à travers une relation intermédiaire
    public function activities()
    {
        return $this->hasManyThrough(
            Activity::class,    // La classe finale à atteindre
            UserTrip::class,    // La classe intermédiaire
            'trip_id',          // Clé étrangère sur la table intermédiaire
            'id',               // Clé étrangère sur la table finale (Activity)
            'id',               // Clé locale sur la table principale (Trip)
            'user_id'           // Clé locale sur la table intermédiaire (UserTrip)
        );
    }
    */
}
