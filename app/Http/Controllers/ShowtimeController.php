<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Showtime;
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
        $showtimes = Showtime::where('movie_id', $movieDetails->id)->get();
        if($user){
            $bookedSeats = Booking::where('user_id', $user->id)->get();   
            foreach ($showtimes as $key => $showtime) {
                foreach ($bookedSeats as $id => $bookedSeat) {
                    if($showtime->id == $bookedSeat->showtime_id){
                        $showtimes[$key]->booked_seats += $bookedSeat->seats_booked;
                    }
                }
            }
        }
        

        return view('showtimes.index', compact('movieDetails', 'showtimes', 'duration', 'bookedSeats'));
    }
}
