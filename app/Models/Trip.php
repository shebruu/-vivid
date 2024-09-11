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

    /**
     * Get the users associated with the trip.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_trip', 'trip_id', 'user_id');
    }

    /**
     * Get de expenses
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'user_trip');
    }
}
