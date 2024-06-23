@extends('layouts.app')

@section('content')
<div class="container">
    <h1 style="color: aliceblue">Add New Movie</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="genre">Genre</label>
                    <input type="text" class="form-control" id="genre" name="genre">
                </div>
                <div class="form-group">
                    <label for="release_date">Release Date</label>
                    <input type="date" class="form-control" id="release_date" name="release_date">
                </div>
                <div class="form-group">
                    <label for="image_url">Image URL</label>
                    <input type="text" class="form-control" id="image_url" name="image_url">
                </div>
                <div class="form-group">
                    <label for="duration">Duration (minutes)</label>
                    <input type="number" class="form-control" id="duration" name="duration">
                </div>
                <div class="form-group">
                    <label for="language">Language</label>
                    <input type="text" class="form-control" id="language" name="language">
                </div>
                <div class="form-group">
                    <label for="actors">Actors</label>
                    <input type="text" class="form-control" id="actors" name="actors">
                </div>
                <button type="submit" class="btn btn-primary">Add Movie</button>
            </form>
        </div>
    </div>
</div>
@endsection
