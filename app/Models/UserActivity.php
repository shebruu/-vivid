<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
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
}
