@extends('layouts.app')

@section('content')
<style>
    .form-group label{
        font-weight: 600 !important
    }
</style>
<div class="container">
    <h1 style="color: aliceblue">Edit Movie</h1>
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
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.movies.edit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title" hidden>Id</label>
                    <input type="text" class="form-control text-secondary" id="title" name="id" value="{{ $movieDetails->id }}" hidden>
                </div>
                <div class="form-group">
                    <label class="fw-bold" for="title">Title</label>
                    <input type="text" class="form-control text-secondary" id="title" name="title" value="{{ $movieDetails->title }}" required>
                </div>
                <div class="form-group">
                    <label class="fw-bold" for="description">Description</label>
                    <textarea class="form-control text-secondary" id="description" name="description" rows="3">{{ $movieDetails->description }}</textarea>
                </div>
                <div class="form-group">
                    <label class="fw-bold" for="genre">Genre</label>
                    <input type="text" class="form-control text-secondary" id="genre" name="genre" value="{{ $movieDetails->genre }}">
                </div>
                <div class="form-group">
                    <label class="fw-bold" for="release_date">Release Date</label>
                    <input type="date" class="form-control text-secondary" id="release_date" name="release_date" value="{{ $movieDetails->release_date }}">
                </div>
                <div class="form-group">
                    <label class="fw-bold" for="release_date">Show Times</label>
                    <div>
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <input type="date" class="text-secondary" id="show_time_date" name="show_time_date" value="">
                                    </div>
                                    <div class="col">
                                        <select class="form-control" name="show_time_time" id="show_time_time">
                                            <option value="">Select a time</option>
                                            @php
                                                $start = new DateTime('10:00');
                                                $end = new DateTime('22:00');
                                                $interval = new DateInterval('PT30M'); // 30 minutes interval
                                            @endphp
                                            @for ($time = $start; $time <= $end; $time->add($interval))
                                                <option value="{{ $time->format('H:i') }}">{{ $time->format('H:i') }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary" id="addShowtimeBtn">Add a Showtime</button>
                            </div>
                        </div>
                        <table style="text-align: center" id="showtimesTable">
                            @foreach($movieDetails->showtimes as $showtime)
                                <tr>
                                    <td value="{{ $showtime->id }}">{{ $showtime->showtime }}</td>
                                    <td><button type="button" class="btn btn-danger deleteShowtimeBtn ms-2" data-id="{{ $showtime->id }}">Delete</button></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="form-group">
                    <label class="fw-bold" for="image_url">Image URL</label>
                    <input type="text" class="form-control text-secondary" id="image_url" name="image_url" value="{{ $movieDetails->image_url }}">
                </div>
                <div class="form-group">
                    <label class="fw-bold" for="duration">Duration(min)</label>
                    <input type="number" class="form-control text-secondary" id="duration" name="duration" value="{{ $movieDetails->duration }}">
                </div>
                <div class="form-group">
                    <label class="fw-bold" for="language">Language</label>
                    <input type="text" class="form-control text-secondary" id="language" name="language" value="{{ $movieDetails->language }}">
                </div>
                <div class="form-group">
                    <label class="fw-bold" for="actors">Actors</label>
                    <input type="text" class="form-control text-secondary" id="actors" name="actors" value="{{ $movieDetails->actors }}">
                </div>
                <button type="submit" class="btn btn-primary">Edit Movie</button>
            </form>
        </div>        
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#addShowtimeBtn').click(function() {
            var movieId = '{{ $movieDetails->id }}';
            var showtimeDate = $('#show_time_date').val();
            var showtimeTime = $('#show_time_time').val();

            if (showtimeDate && showtimeTime) {
                $.ajax({
                    url: '{{ route("showtime.add") }}',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        movie_id: movieId,
                        show_time_date: showtimeDate,
                        show_time_time: showtimeTime
                    },
                    success: function(response) {
                        if (response.success) {
                            updateShowtimesTable(response.showtimes);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            } else {
                alert('Please select a date and time');
            }
        });

        $(document).on('click', '.deleteShowtimeBtn', function() {
            var showtimeId = $(this).data('id');

            if (confirm('Are you sure you want to delete this showtime?')) {
                $.ajax({
                    url: '/delete-showtime/' + showtimeId,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            updateShowtimesTable(response.showtimes);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            }
        });

        function updateShowtimesTable(showtimes) {
            var showtimesTable = $('#showtimesTable');
            showtimesTable.empty();
            $.each(showtimes, function(index, showtime) {
                showtimesTable.append('<tr id="showtime-' + showtime.id + '"><td value="' + showtime.id + '">' + showtime.showtime + '</td><td><button type="button" class="btn btn-danger deleteShowtimeBtn" data-id="' + showtime.id + '">Delete</button></td></tr>');
            });
        }
    });
</script>
@endsection
