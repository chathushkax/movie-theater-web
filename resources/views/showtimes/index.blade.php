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

            {{-- use database for get show time here --}}
            <h2>Choose your time slot</h2>
            <div class="d-flex">
                <a href="/booking-process">
                    <button class="time_select_btn" role="button"><span class="text">10.30 PM</span><span>Book Now</span></button>
                </a>
                <button class="time_select_btn" role="button"><span class="text">1.30 PM</span><span>Book Now</span></button>
                <button class="time_select_btn" role="button"><span class="text">4.30 PM</span><span>Book Now</span></button>
            </div>
        </div>
    </div>
    
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="row">
        @foreach ($showtimes as $showtime)
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $showtime->showtime }}</h5>
                    <p class="card-text">Available Seats: {{ $showtime->available_seats }}</p>
                    @if($showtime->booked_seats)<span class="card-text">Booked Seats: {{ $showtime->booked_seats }}</span>@endif
                    <form action="{{ route('bookings.store', $showtime->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="seats_booked">Seats</label>
                            <input type="number" name="seats_booked" class="form-control" min="1" max="{{ $showtime->available_seats }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Book Now</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
