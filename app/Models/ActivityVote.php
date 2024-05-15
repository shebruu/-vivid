<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityVote extends Model
{
    use HasFactory;



    public $timestamps = false;
    protected $fillable = ['user_id', 'user_activity_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userActivity()
    {
        return $this->belongsTo(UserActivity::class, 'user_activity_id');
    }
}
