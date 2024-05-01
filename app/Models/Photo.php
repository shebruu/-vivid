<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'url',
        'place_id'

    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'photos';

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id');
    }
}
