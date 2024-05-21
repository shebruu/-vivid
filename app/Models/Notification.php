<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'sender_id', 'message', 'status'];


    public function receiver()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation to the User model for the sender
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
