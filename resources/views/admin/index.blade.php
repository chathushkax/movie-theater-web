@extends('layouts.app')

@section('content')
<div class="container">
    <h1 style="color: aliceblue">Booking Management</h1>
    <span class="btn btn-add">
        <a href="{{ route('admin.movies.create') }}" class="btn btn-primary">Add New Movie</a>
    </span>
    <table class="table" style="text-align: center">
        <thead>
            <tr>
                <th>Movie</th>
                <th>Showtime</th>
                <th>Seats</th>
                <th>Customer</th>
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
                    <td>{{ $booking->user->name }}</td>
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
@endsection
