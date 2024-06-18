<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

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
        $booking->delete();

        return redirect()->route('admin.index')->with('success', 'Booking cancelled.');
    }
}
