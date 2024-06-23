<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Showtime;
use App\Models\Booking;
use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\Clock\now;

class BookingController extends Controller
{
    
    protected int $totalseats;
    protected int $booked_seats;

    public function __construct()
    {
        $this->totalseats = 0;
        $this->booked_seats = 0;
    }

    public function bookingSeats($id) {
        
        $total_seats = $this->totalseats;
        $showtime_id = $id;
        $now_date_time = Carbon::now('Asia/Colombo');
        $showtime_details = Showtime::where('id', $showtime_id)
                        ->where('showtime', '>=', $now_date_time)
                        ->firstOrFail();
        $showtime = Carbon::parse($showtime_details->showtime)->format('Y-M-d H:i A');
        $day = Carbon::parse($showtime_details->showtime)->format('D');
        $date = Carbon::parse($showtime_details->showtime)->format('d');
        $total_seats = $showtime_details->total_seats;
        $total_booked = Booking::where('user_id', Auth::user()->id)
                        ->get()->count();

        return view('booking.booking', compact('showtime_id','showtime', 'total_seats', 'day', 'date', 'total_booked'));
    }

    public function getShowtimeDetails($showtime_id)
    {
        $showtime = Showtime::with(['bookings' => function ($query) {
            $query->where('status', '!=', 'cancelled');
        }])->findOrFail($showtime_id);
        
        $bookedSeats = $showtime->bookings->map(function($booking) {
            return [
                'row' => $booking->row,
                'col' => $booking->col,
            ];
        });

        return response()->json([
            'ticket_price' => (int)$showtime->adult_price,
            'bookedSeats' => $bookedSeats
        ]);
    }



    public function bookTickets(Request $request)
    {
        $seats = $request->input('seats');
        $user = auth()->user();
        $booked_seats = 0;


        DB::beginTransaction();

        try {
            foreach ($seats as  $seat) {
                Booking::create([
                    'user_id' => $user->id,
                    'showtime_id' => $seat['showtime'],
                    'row' => $seat['row'],
                    'col' => $seat['col'],
                    'is_confirmed' => 'pending'
                ]);
                $booked_seats = $booked_seats + 1;
            }
    
            $showtime = Showtime::findOrFail($seat['showtime']);
            $showtime->available_seats = $showtime->available_seats - $booked_seats;
            $showtime->save();

            DB::commit();
            return response()->json(['success' => true], 200);
        } catch (QueryException $e) {
            DB::rollBack();

            if ($e->getCode() == 23000) { 
                return response()->json(['error' => 'Seat already booked'], 409);
            }

            return response()->json(['error' => 'An error occurred'], 500);
        }

    }
}
