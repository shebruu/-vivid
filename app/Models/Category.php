<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [

        'name',


    ];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    public function activities()
    {
        return $this->belongsToMany('App\Models\Activity', 'activity_category');
    }
}
