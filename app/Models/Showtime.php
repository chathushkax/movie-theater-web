<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    use HasFactory;

    protected $fillable = ['movie_id', 'showtime', 'available_seats', 'total_seats', 'adult_price', 'child_price'];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
