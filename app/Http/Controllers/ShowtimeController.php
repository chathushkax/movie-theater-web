<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Showtime;

class ShowtimeController extends Controller
{
    public function index($movie)
    {
        $movieName = str_replace('-', ' ', $movie);
        $movieDetails = Movie::where('title', $movieName)->first();
        $h = floor($movieDetails->duration / 60);
        $m =  ($movieDetails->duration % 60);
        $duration = $h.'h'.' '.$m.'m';
        $movieDetails->release_date = date('D, d M Y');
        $showtimes = Showtime::where('movie_id', $movieDetails->id)->get();
        return view('showtimes.index', compact('movieDetails', 'showtimes', 'duration'));
    }
}
