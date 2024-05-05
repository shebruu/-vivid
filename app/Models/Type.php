<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'description'

    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'types';

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_type');
    }
}
