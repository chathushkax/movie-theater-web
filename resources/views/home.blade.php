@extends('layouts.app')

@section('content')
    <style>
        .movie-card img {
            max-width: 75px;
            height: auto;
        }

        .image-container {
            position: relative !important;
            width: 100% !important;
        }

        .image-container img {
            width: 100% !important;
            height: auto !important;
        }

        .overlay {
            position: absolute !important;
            bottom: 0 !important;
            width: 100% !important;
            background: rgba(0, 0, 0, 0.5) !important;
            /* Slightly shaded dark background */
            color: white !important;
            text-align: center !important;
            padding: 10px 0 !important;
        }

        .movie-title {
            margin: 0 !important;
        }
        
    </style>
    {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> --}}

    <div class="container">
        <div class="section-title">
            NOW SHOWING
        </div>
        <div class="row">
            @foreach ($movies as $movie)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <a href="{{ url('/showtimes/' . str_replace(' ', '-', $movie->title)) }}">
                        <div class="card h-50" style="border: none !important;cursor: pointer;">
                            <div class="image-container">
                                <div class="overlay">
                                    <img src="{{ $movie->image_url }}" class="card-img-top" alt="{{ $movie->title }}">
                                    <h5 class="movie-title">{{ $movie->title }}</h5>
                                    <p class="card-text">{{ $movie->genre }}</p>
                                </div>
                            </div>
                            {{-- <div class="card-body">
                                <p class="card-text">{{ $movie->release_date }}</p>
                                <p class="card-text">{{ $movie->description }}</p>
                            </div> --}}
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
