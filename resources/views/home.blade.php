@extends('layouts.app')

@section('content')
    <div class="container">
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
