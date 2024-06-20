<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Http;
use mysqli;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return view('movies.index', compact('movies'));
    }

    public function addMoviesToDatabase() {
    $apiKey = 'f29247c399bbc1436c35f46145a57341';

    // Fetch all movie IDs and titles from your database
    $conn = new mysqli('127.0.0.1', 'root', '', 'movie_theater');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, title FROM movies";
    $result = $conn->query($sql);
    $movieIds = $this->getMovieIds();
    

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $movieId = $movieIds[$row['id']-1];
            $originalTitle = $row['title'];

            // Fetch movie details
            $movieDetailsUrl = "https://api.themoviedb.org/3/movie/$movieId?api_key=$apiKey&language=en-US";
            $movieDetails = file_get_contents($movieDetailsUrl);
            $movieDetails = json_decode($movieDetails, true);

            // Fetch movie credits
            $movieCreditsUrl = "https://api.themoviedb.org/3/movie/$movieId/credits?api_key=$apiKey&language=en-US";
            $movieCredits = file_get_contents($movieCreditsUrl);
            $movieCredits = json_decode($movieCredits, true);

            // Get the required details
            $duration = $movieDetails['runtime'];
            $language = $movieDetails['original_language'];
            $actors = array_slice($movieCredits['cast'], 0, 5); // Get top 5 actors
            $actorNames = array_map(function($actor) { return $actor['name']; }, $actors);

            // Insert into your database
            $updateSql = "UPDATE movies SET duration = ?, language = ?, actors = ? WHERE id = ?";
            $stmt = $conn->prepare($updateSql);
            $actorNames = implode(', ', $actorNames); // Convert array to comma-separated string
            $stmt->bind_param("issi", $duration, $language, $actorNames, $movieId);

            if ($stmt->execute()) {
                echo "Record updated successfully: " . $originalTitle . " " . $duration . " " . $language . " " . $actorNames . "<br>";
            } else {
                echo "Error: " . $updateSql . "<br>" . $conn->error;
            }

            $stmt->close();
        }
    } else {
        echo "No records found.";
    }

    $conn->close();
}


    public function getMovieIds() {

        $url = 'https://api.themoviedb.org/3/discover/movie?api_key=f29247c399bbc1436c35f46145a57341&primary_release_year=2024';
        $movies = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->get($url);

        foreach($movies['results'] as $key => $movie){
            // $res = $this->addMoviesToDatabase($movie['id'], $movie['original_title']);
            $res[$key] = $movie['id'];

        }

        return $res;
    }
}
