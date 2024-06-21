<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Showtime;
use App\Models\Booking;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request, $showtimeId)
    {
        $showtime = Showtime::findOrFail($showtimeId);
        $request->validate([
            'seats_booked' => 'required|integer|min:1|max:' . $showtime->available_seats,
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'showtime_id' => $showtime->id,
            'seats_booked' => $request->seats_booked,
        ]);

        $movieName = Movie::where('id',$showtime->movie_id)
        ->select('title')
        ->first()->title;
        

        $showtime->available_seats -= $request->seats_booked;
        $showtime->save();

        return redirect()->route('showtimes.index', $movieName)->with('success', 'Booking successful!');
    }
}
