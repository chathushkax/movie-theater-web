@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" style="display: flex !important;">
        <h2>{{ $movieDetails->title }} - Showtimes</h2>
    </div>
    <div class="row d-flex" style="color: rgb(128 128 146) !important;">
        <div class="image-container" style="max-width: fit-content;">
            <img src="{{ $movieDetails->image_url }}" class="card-img-top" alt="{{ $movieDetails->title }}">
        </div>
        <div style="max-width: 70%;">
            <h3>{{ $duration }}</h3>
            <h4>{{ $movieDetails->actors }}</h4>
            <p>{{ $movieDetails->description }}</p>
            <h5>{{ $movieDetails->release_date }}</h5>
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
