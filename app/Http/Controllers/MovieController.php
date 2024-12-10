<?php

namespace App\Http\Controllers;

use App\Models\GenreMovie;
use App\Models\GenreUser;
use App\Models\Movie;
use App\Models\Recommendation;
use App\Models\LinkProvider;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

class MovieController extends Controller
{
    private function getMovie($title)
    {
        $apiKey     = env('TMDB_API_KEY');
        $url        = "https://api.themoviedb.org/3/search/movie?api_key={$apiKey}&query=".urlencode($title)."&language=es-ES";
        $client     = new Client();
        
         try {
            $response = $client->request('GET', $url, [
            'verify' => false,
        ]);
            $statusCode = $response->getStatusCode();

            if ($statusCode == 200) {
                $data = json_decode($response->getBody(), true);

                if (isset($data['results']) && count($data['results']) > 0) {
                    $movieData = $data['results'][0];
                    $movieId   = $movieData['id'];
                    $genreIds  = $movieData['genre_ids'];                    
                    
                    $detailsUrl      = "https://api.themoviedb.org/3/movie/{$movieId}?api_key={$apiKey}";
                    $detailsResponse = $client->request('GET', $detailsUrl, ['verify' => false]);
                    $detailsData     = json_decode($detailsResponse->getBody(), true);
                    
                    $hours       = intdiv($detailsData['runtime'], 60);
                    $minutes     = $detailsData['runtime'] % 60;
                    $duration    = sprintf('%02d:%02d:00', $hours, $minutes);
                    $movieData[] = ['duration' => $duration];
                    
                    $videoUrl = null;

                    $videosUrl = "https://api.themoviedb.org/3/movie/{$movieId}/videos?api_key={$apiKey}&language=es-ES";
                    $videosResponse = $client->request('GET', $videosUrl, ['verify' => false]);
                    $videosData = json_decode($videosResponse->getBody(), true);

                    if (isset($videosData['results']) && count($videosData['results']) > 0) {
                        $video = $videosData['results'][0];
                        $videoUrl = 'https://www.youtube.com/embed/' . $video['key'];
                    }
                    
                    $providerDomains = [
                        'Netflix' => 'https://www.netflix.com/search?q=',
                        'Amazon Prime Video' => 'https://www.primevideo.com/search/ref=atv_sr_sug_?phrase=',
                        'HBO Max' => 'https://www.hbomax.com/search?q=',
                        'Disney+' => 'https://www.disneyplus.com/search/',
                    ];
                    $providers         = [];
                    $providersUrl      = "https://api.themoviedb.org/3/movie/{$movieId}/watch/providers?api_key={$apiKey}";
                    $providersResponse = $client->request('GET', $providersUrl, ['verify' => false]);
                    $providersData     = json_decode($providersResponse->getBody(), true);
                    $encodedTitle      = urlencode($title);

                    if (isset($providersData['results']['ES']['flatrate'])) {
                        foreach ($providersData['results']['ES']['flatrate'] as $provider) {
                            $providerName = $provider['provider_name'];
                            $providerLink = isset($providerDomains[$providerName])
                                ? $providerDomains[$providerName] . $encodedTitle
                                : null;

                            $providers[] = [
                                'name' => $providerName,
                                'link' => $providerLink,
                            ];
                        }
                    }
                    $movieDetails['providers'] = $providers;
                    
                    $movieData[] = ['videoUrl' => $videoUrl];
                    $movieDetails['moviedata'] = $movieData;
                    $movieDetails['detailsdata'] = $detailsData;
                    $movieDetails['genresids'] = $genreIds;
                    
                    return $movieDetails;
                } else {
                    $movieData = [];
                    return $movieData;
                }
            }
        } catch (\Exception $e) {
            $movieData = [];
            return $movieData;
        }
    }


    public function index()
    {
        $movies = Movie::with('genres')->orderBy('rate', 'desc')->paginate(5);
        return view('movie.index', compact('movies'));
    }

    public function create() 
    {
        return view('movie.create');
    }
    
    public function store(Request $request) 
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:movies',
        ]);
        $title      = $request->input('title');
        $movie      = new Movie();
        $movieData  = $this->getMovie($title);
        
        if(empty($movieData)){
            return redirect()->back()->with('error', 'No se ha encontrado la película');
        }else{
            $movie->title        = $movieData['moviedata']['title'];
            $movie->description  = $movieData['moviedata']['overview'];
            $movie->rate         = $movieData['moviedata']['vote_average'];
            $movie->release_year = substr($movieData['moviedata']['release_date'], 0, 4);
            $movie->duration     = $movieData['moviedata'][0]['duration'];
            $movie->video        = $movieData['moviedata'][1]['videoUrl'];
            $movie->image        = 'https://image.tmdb.org/t/p/w500'.$movieData['detailsdata']['poster_path'];

            $movie->save();

            foreach ($movieData['providers'] as $provider) {
                LinkProvider::create([
                    'movie_id' => $movie->id,
                    'name' => $provider['name'],
                    'link' => $provider['link'],
                ]);
            }
        }

        foreach($movieData['genresids'] as $id){
            GenreMovie::updateOrInsert(['genre_id' => $id, 'movie_id' => $movie->id]);
        }
        
        $genresUsers = GenreUser::get();
        $genresMovies = GenreMovie::where('movie_id', $movie->id)->get();

        foreach($genresUsers as $genreUser){
            foreach($genresMovies as $genreMovie){
                if($genreUser->genre_id == $genreMovie->genre_id){
                    Recommendation::firstOrCreate([
                    'user_id'  => $genreUser->user_id,
                    'movie_id' => $genreMovie->movie_id,
                    ], [
                    'viewed'   => 0,
                    ]);
                }
            }
        }
        
        return redirect()->route('home')->with(['message' => 'Película añadida correctamente']);
    }
    
    public function details(Request $request)
    {   
        $movie = Movie::findOrFail($request->id);
        return view('movie.details', compact('movie'));
    }
    
    public function getImage($fileName) 
    {
        $file = Storage::disk('movies')->get($fileName);
        
        return new Response($file, 200);
    }
}
