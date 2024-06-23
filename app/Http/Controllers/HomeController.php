<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $movies = Movie::all();
        $now = Carbon::now();
        $incoming_movies = [];
        $now_showing_movies = [];

        foreach ($movies as $key => $movie) {
            if ($movie->release_date > $now) {
                $incoming_movies[] = $movie;
            } else {
                $now_showing_movies[] = $movie;
            }
        }
        $feedbacks = Feedback::orderBy('created_at', 'desc')->take(10)->get();
            foreach ($feedbacks as $key => $feedback) {
                $name = User::where('id', $feedback->user_id)->first()->name;
                $feedback->name = $name;
            }
        return view('home', compact('incoming_movies', 'now_showing_movies', 'feedbacks'));
    }
}
