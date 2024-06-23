<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Movie;
use App\Models\Showtime;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user', 'showtime')->get();
        return view('admin.index', compact('bookings'));
    }

    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'confirmed';
        $booking->save();

        return redirect()->route('admin.index')->with('success', 'Booking confirmed.');
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'cancelled';
        $booking->showtime->available_seats += $booking->seats_booked;
        $booking->showtime->save();
        $booking->save();

        return redirect()->route('admin.index')->with('success', 'Booking cancelled.');
    }

    public function modify(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:confirmed,cancelled',
        ]);

        $booking->status = $request->status;
        $booking->save();

        if ($booking->status === 'cancelled') {
            $booking->showtime->available_seats += $booking->seats_booked;
            $booking->showtime->save();
        }

        return redirect()->route('admin.index')->with('success', 'Booking modified.');
    }

    public function storeMovie(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'genre' => 'nullable|string|max:255',
            'release_date' => 'nullable|date',
            'image_url' => 'nullable|url',
            'duration' => 'nullable|integer|min:1',
            'language' => 'nullable|string|max:100',
            'actors' => 'nullable|string',
        ]);

        // Create new movie instance
        $movie = new Movie([
            'title' => $request->title,
            'description' => $request->description,
            'genre' => $request->genre,
            'release_date' => $request->release_date,
            'image_url' => $request->image_url,
            'duration' => $request->duration,
            'language' => $request->language,
            'actors' => $request->actors,
        ]);

        
        $movie->save();

        
        $timeslots = ['10:30', '13:30', '16:30', '19:30'];

       
        $startDate = Carbon::parse($request->release_date);
        $endDate = $startDate->copy()->addDays(6); 

        
        while ($startDate <= $endDate) {
            $existingShowtimes = Showtime::where('movie_id', $movie->id)
                ->whereDate('showtime', $startDate->format('Y-m-d'))
                ->get();

            $existingTimeslots = $existingShowtimes->pluck('showtime')->map(function ($item) {
                return Carbon::parse($item)->format('H:i');
            })->toArray();

            
            foreach ($timeslots as $timeslot) {
                $proposedShowtime = $startDate->format('Y-m-d') . ' ' . $timeslot;

                if (!in_array($timeslot, $existingTimeslots)) {
                    $showtime = new Showtime([
                        'movie_id' => $movie->id,
                        'showtime' => $proposedShowtime,
                        'available_seats' => $request->total_seats ?? 100,
                        'total_seats' => $request->total_seats ?? 100,
                        'adult_price' => $request->adult_price ?? 1000.00,
                        'child_price' => $request->child_price ?? 500.00, 
                    ]);

                    $showtime->save();
                }
            }

            $startDate->addDay();
        }

        return redirect()->back()->with('success', 'Movie added successfully with showtimes.');
    }

    public function addMovie(){
        return view('admin.add_movie');
    }

}
