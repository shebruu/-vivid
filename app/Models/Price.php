<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['place_id', 'user_id', 'amount', 'age_rang', 'season', 'day-type'];




    /**
     * Get the place associated with this price (if applicable).
     */
    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id');
    }

    /**
     * Optional: Relation to a user if prices are user-specific.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
