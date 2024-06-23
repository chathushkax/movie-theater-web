<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile()
{
    $user = Auth::user();
    $isAdmin = $user->is_admin;
    $isStaff = $user->is_staff;
    $bookings = Booking::with('showtime.movie')
                ->where('user_id', $user->id)
                ->get();

    $feedbacks = Feedback::where('user_id', $user->id)
                ->get();
                
    if($isAdmin || $isStaff){
        return redirect()->route('admin.index');
    }else{
        return view('profile', compact('user', 'bookings', 'feedbacks'));
    }
}

}
