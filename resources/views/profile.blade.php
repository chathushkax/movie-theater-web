@extends('layouts.app')

@section('content')
<div class="container">
    <h4 style="color: aliceblue; font-weight: 500; margin-top: 30px">YOUR BOOKINGS</h4>

    @if($bookings->isEmpty())
    <div style="width: 100%;background-color:rgb(105, 32, 32);min-height:30px;display: flex; justify-content:center; align-items:center;">
        <p style="display: flex; justify-content:center; align-items:center;color:aliceblue;margin-top:1rem !important">You have no bookings.</p>
    </div>
    @else
        <table class="table" style="text-align: center">
            <thead>
                <tr>
                    <th>Movie</th>
                    <th>Showtime</th>
                    <th>Seats</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                    @php
                        $showtimeDate = new \DateTime($booking->showtime->showtime);
                        $now = new \DateTime();
                        $isPastShowtime = $showtimeDate < $now;
                        $numberToLetter = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
                        $colLetter = $numberToLetter[$booking->col - 1] ?? $booking->col; 
                    @endphp
                    <tr class="{{ $isPastShowtime ? 'text-muted' : '' }}">
                        <td>
                            @if ($isPastShowtime)
                                {{ $booking->showtime->movie->title }}
                            @else
                                <a href="/booking-process/{{$booking->showtime->id}}">{{ $booking->showtime->movie->title }}</a>
                            @endif
                        </td>
                        <td>{{ $booking->showtime->showtime }}</td>
                        <td>
                            {{  $booking->row . $colLetter }}
                        </td>
                        <td>{{ $booking->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h4 style="color: aliceblue; font-weight: 500; margin-top: 30px">YOUR FEEDBACKS</h4>

    @if($feedbacks->isEmpty())
        <div style="width: 100%;background-color:rgb(105, 32, 32);min-height:30px;display: flex; justify-content:center; align-items:center;">
            <p style="display: flex; justify-content:center; align-items:center;color:aliceblue;margin-top:1rem !important">You have no feedabacks.</p>
        </div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Feedback</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($feedbacks as $feedback)
                    <tr>
                        <td>
                            {{$feedback->feedback}} 
                        </td>
                        <td>
                            {{$feedback->updated_at}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
