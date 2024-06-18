@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @foreach ($movies as $movie)
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $movie->title }}</h5>
                    <p class="card-text">{{ $movie->description }}</p>
                    <a href="{{ route('showtimes.index', $movie->id) }}" class="btn btn-primary">View Showtimes</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
