<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Showtime;

class ShowtimeController extends Controller
{
    public function index($movieId)
    {
        $movie = Movie::findOrFail($movieId);
        $showtimes = Showtime::where('movie_id', $movieId)->get();
        return view('showtimes.index', compact('movie', 'showtimes'));
    }
}
