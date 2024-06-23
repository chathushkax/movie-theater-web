<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Showtime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ShowtimeController extends Controller
{
    public function index($movie)
    {
        $user = Auth::user();
        $movieName = str_replace('-', ' ', $movie);
        $movieDetails = Movie::where('title', $movieName)->first();
        $h = floor($movieDetails->duration / 60);
        $m =  ($movieDetails->duration % 60);
        $duration = $h.'h'.' '.$m.'m';
        $movieDetails->release_date = date('D, d M Y');
        $now_date_time = Carbon::now('Asia/Colombo');
        $tomorrow = $now_date_time->copy()->addDay();

        
        $showtimes = Showtime::where('movie_id', $movieDetails->id)
            ->whereBetween('showtime', [$now_date_time->format('Y-m-d H:i:s'), $tomorrow->format('Y-m-d H:i:s')])
            ->get();
       
            foreach ($showtimes as $key => $showtime) {
            $showtimes[$key]->time = Carbon::parse($showtime->showtime)
                                    ->format('D d H:i');
        }
  
       

        return view('showtimes.index', compact('movieDetails', 'showtimes', 'duration'));
    }
}
