@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- slider start --}}
        {{-- <div class="container" id="container">
            <div class="caption" id="slider-caption">
                <div class="caption-heading">
                    <h1>Lorem Ipsum</h1>
                </div>
                <div class="caption-subhead"><span>dolor sit amet, consectetur adipiscing elit. </span></div><a class="btn" href="#">Sit Amet</a></div>
            <div class="left-col" id="left-col">
                <div id="left-slider"></div>
            </div>
            <ul class="nav">
                <li class="slide-up">
                    <a href="#">
                        <</a>
                </li>
                <li class="slide-down"> <a id="down_button" href="#">></a></li>
            </ul>
        </div> --}}
        {{-- slider end --}}
        <div class="section-title">
            NOW SHOWING
        </div>
        <div class="row">
            @foreach ($now_showing_movies as $movie)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="movie-card">
                        <img src="{{ $movie->image_url }}" class="card-img-top" alt="{{ $movie->title }}">
                        <div class="movie-details">
                            <h5 class="movie-title">{{ $movie->title }}</h5>
                            <p class="card-text">&bull; {{ $movie->genre }}</p>
                            <div class="action">
                                <a href="{{ url('/showtimes/' . str_replace(' ', '-', $movie->title)) }}">
                                    <button class="act_btn"><span class="text">Book Tickets</span></button>
                                </a>
                                <button class="act_btn"><span class="text">Play Trailer</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="section-title">
            COMING SOON
        </div>
        <div class="row">
            @foreach ($incoming_movies as $movie)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="movie-card">
                        <img src="{{ $movie->image_url }}" class="card-img-top" alt="{{ $movie->title }}">
                        <div class="movie-details">
                            <h5 class="movie-title">{{ $movie->title }}</h5>
                            <p class="card-text">&bull; {{ $movie->genre }}</p>
                            <div class="action">
                                <a href="{{ url('/showtimes/' . str_replace(' ', '-', $movie->title)) }}">
                                    <button class="act_btn"><span class="text">Book Tickets</span></button>
                                </a>
                                <button class="act_btn"><span class="text">Play Trailer</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        
        {{-- feedbacks --}}
        <div class="row">
            <div class="feedback_form">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if (Auth::check())
                    <div  class="share_idea">
                        <h2>Share your Idea with Us.</h2>
                    </div>
                    <form action="{{ route('feedback.store') }}" method="POST"  style="width:100%">
                        @csrf
                        <div class="form-group">
                            <label for="feedback">Your Feedback</label>
                            <textarea id="feedback" name="feedback" class="form-control" required></textarea>
                        </div>
                        <div class="feedback_submit">
                            <button type="submit" class="btn btn-primary feedback_submit_btn">Submit Feedback</button>
                        </div>
                    </form>
                @else
                    <p style="color: #b2f918; margin-top:100px">You need to <label for="" class="login_lable"><a class="link_lable" href="{{ route('login') }}">login</a></label> to leave feedback.</p>
                @endif
            </div>
            <div class="recent_feedbacks">
                {{-- feedback list --}}
                <h3>Recent Feedbacks</h3>
                @if ($feedbacks->isEmpty())
                    <p>No feedbacks available.</p>
                @else
                    <ul class="list-group">
                        @foreach ($feedbacks as $feedback)
                            <li class="list-group-item">
                                <strong>{{ $feedback->name }}:</strong> {{ $feedback->feedback }}
                                <br>
                                <small>Submitted on {{ $feedback->created_at->format('d M Y, h:i A') }}</small>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection
