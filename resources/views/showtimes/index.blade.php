@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" style="display: flex !important;">
        <h2 class="set_movie_name">{{ $movieDetails->title }}</h2>
        <div class="d-flex mb-2">
            <h5 class="rele_date">{{ $movieDetails->release_date }}</h5>
            {{-- <h5>&bull; {{ $movie->genre }}</h5>
            <h5>&bull; {{ $movie->language }}</h5> --}}
        </div>
    </div>
    <div class="row d-flex flex-wrap" style="color: rgb(128 128 146) !important;">
        <div class="col-12 col-md-7 col-lg-8 image-container">
            <img src="{{ $movieDetails->image_url }}" class="card-img-top w-100" alt="{{ $movieDetails->title }}">
        </div>
        <div class="col-12 col-md-5 col-lg-4">
            <label for="" class="duration_label">&bull; Duration</label>
            <h3 class="duration">{{ $duration }}</h3>
            <label for="" class="duration_label">&bull; Summery</label>
            <p class="set_m_d">{{ $movieDetails->description }}</p>
            <label for="" class="duration_label">&bull; Actors</label>
            <p class="set_m_d">{{ $movieDetails->actors }}</p>

            <h2>Choose your time slot</h2>
            <div class="d-flex">
                @if (empty($showtimes))
                    <h4>Comming Soon...</h4>
                @else
                    @foreach ($showtimes as $showtime)
                        <a href="/booking-process/{{$showtime->id}}">
                            <button class="time_select_btn" role="button"><span class="text">{{ $showtime->time }} PM</span><span>Book Now</span></button>
                        </a>
                    @endforeach
                @endif
                
            </div>
        </div>
    </div>
</div>
@endsection
