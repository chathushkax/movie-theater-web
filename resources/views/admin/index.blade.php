@extends('layouts.app')

@section('content')
<div class="container">
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
    <h1 style="color: aliceblue">Booking Management</h1>
    <table class="table" style="text-align: center">
        <thead>
            <tr>
                <th>Movie</th>
                <th>Showtime</th>
                <th>Seats</th>
                <th>Customer</th>
                <th>Email</th>
                <th colspan="4">Actions</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                    @php
                        $numberToLetter = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
                        $colLetter = $numberToLetter[$booking->col - 1] ?? $booking->col; 
                    @endphp
                <tr>
                    <td>
                        <a href="/booking-process/{{$booking->showtime->id}}">{{ $booking->showtime->movie->title }}</a></td>
                    <td>{{ $booking->showtime->showtime }}</td>
                    <td>{{  $booking->row . $colLetter }}</td>
                    <td>@php $booking->user->email == Auth::user()->email ? "Admin" : $booking->user->name @endphp</td>
                    <td>@php $booking->user->email == Auth::user()->email ? "Admin" : $booking->user->email @endphp</td>
                    <td>
                        <td>
                            @if ($booking->status == 'pending')
                                <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Confirm</button>
                                </form>
                            @endif
                        </td>
                        <td>
                            @if($booking->status != 'pending')
                                <form action="{{ route('admin.bookings.modify', $booking) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status">
                                        <option value="confirmed">Confirmed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                    <button type="submit" class="btn btn-warning">Modify</button>
                                </form>
                            @endif
                        </td>                        
                        <td>
                            @if ($booking->status == 'pending')
                                <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Cancel</button>
                                </form>
                            @endif
                        </td>
                    </td>
                    <td>
                        {{ $booking->status }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="container">
    <h1 style="color: aliceblue">Movie Management</h1>
    <span class="btn btn-add">
        <a href="{{ route('admin.movies.create') }}" class="btn btn-primary">Add New Movie</a>
    </span>
    <input type="text" id="search2" class="form-control mb-3 mt-5" placeholder="Search by movie name" onkeyup="searchMovies()">
    <table class="table " style="text-align: center;min-height:100px">
        <thead>
            <tr>
                <th>Movie</th>
                <th>Release Date</th>
                <th>End Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="movieTable">
            @foreach($allMovies as $movie)
                <tr>
                    <td style="text-align:justify;padding-left:10px">
                        {{$movie->title}}
                    </td>
                    <td>
                        {{$movie->release_date}}
                    </td>
                    <td>
                        {{$movie->end_date}}
                    </td>
                    <td>
                        <a href="{{ url('/edit/' . str_replace(' ', '-', $movie->title)) }}">
                            <button class="btn btn-primary">Edit</button>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function(){ 
        $('#search2').on('keyup', function() {
            var query = $('#search2').val();

            $.ajax({
                url: '/search-movies',
                type: 'GET',
                data: { query: query },
                success: function(data) {
                    var rows = '';
                    data.forEach(function(movie) {
                        rows += `
                            <tr>
                                <td style="text-align:justify;padding-left:10px">
                                    ${movie.title}
                                </td>
                                <td>
                                    ${movie.release_date}
                                </td>
                                <td>
                                    ${movie.end_date}
                                </td>
                                <td>
                                    <button class="btn btn-primary">Edit</button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#movieTable').html(rows);
                }
            });
        });
    });
</script>
@endsection
