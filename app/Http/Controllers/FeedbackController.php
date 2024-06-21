<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $bookingCount = Booking::where('user_id', $user->id)->count();

        if ($bookingCount == 0) {
            return redirect()->back()->with('error', 'You must place a booking to leave feedback.');
        }

        $request->validate([
            'feedback' => 'required|string|max:255',
        ]);

        Feedback::create([
            'user_id' => $user->id,
            'feedback' => $request->feedback,
        ]);

        return redirect()->back()->with('success', 'Feedback submitted successfully.');
    }
}