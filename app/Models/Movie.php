<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'duration', 'language', 'actors','genre', 'release_date', 'image_url'];

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }
}
