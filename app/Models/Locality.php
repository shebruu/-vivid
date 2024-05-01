<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locality extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'postal_code',
        'city',
        'province',
        'country',
        'population',
        'main_attraction',
        'adress',
        'googleplace_id',
        'latitude',
        'longitude',
        'description',
        'language'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'localities';


    public function trips()
    {
        return $this->belongsToMany(Trip::class);
    }
}
