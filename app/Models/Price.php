<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['activity_id', 'place_id', 'user_id', 'amount', 'age_rang', 'season', 'day-type'];

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
}
