@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manage Bookings</h2>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Showtime</th>
                    <th>Seats</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                <tr>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->showtime->showtime }}</td>
                    <td>{{ $booking->seats_booked }}</td>
                    <td>{{ $booking->status ?? 'Pending' }}</td>
                    <td>
                        <form action="{{ route('admin.confirm', $booking->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Confirm</button>
                        </form>
                        <form action="{{ route('admin.cancel', $booking->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">Cancel</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
