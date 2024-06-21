<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\User;

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
        $feedbacks = Feedback::orderBy('created_at', 'desc')->take(10)->get();
            foreach ($feedbacks as $key => $feedback) {
                $name = User::where('id', $feedback->user_id)->first()->name;
                $feedback->name = $name;
            }
        return view('home', compact('movies', 'feedbacks'));
    }
}
