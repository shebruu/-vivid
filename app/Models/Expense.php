<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $fillable = [
        'trip_id',
        'price_id',
        'category_id',
        'amount',
        'payment_link',


    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function price()
    {
        return $this->belongsTo(Price::class, 'price_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
