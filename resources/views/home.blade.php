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
            @foreach ($movies as $movie)
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
        
    </div>
@endsection
