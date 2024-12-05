<?php

namespace App\Http\Controllers;

use App\Models\Genre;

use Illuminate\Http\Response;
use GuzzleHttp\Client;

class GenreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create() 
    {
        return view('genre.create');
    }
    
    public function store() {
        
        $apiKey = env('TMDB_API_KEY');
        $url = "https://api.themoviedb.org/3/genre/movie/list?api_key={$apiKey}&language=es";

        $client = new Client();

        try {
            $response = $client->request('GET', $url, ['verify' => false]);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody(), true);
                $generos = $data['genres'] ?? [];

                foreach ($generos as $genero) {
                    $genero      = Genre::find($genero['id']);
                    if($genero){
                        return redirect()->route('home')->with(['error' => 'Ya se añadieron todos los géneros necesarios.']);
                    }
                    $this->updateOrCreate($genero['id'], $genero['name']);
                }
                return redirect()->route('home')->with(['message' => 'Genero añadido correctamente']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener géneros: ' . $e->getMessage()], 500);
        }
        
        return redirect()->route('home')->with(['message' => 'Genero añadido correctamente']);
    }
    
    public function updateOrCreate($id, $name) 
    {
        $genre       = new Genre();
        
        $genre->id   = $id;
        $genre->name = $name;

        $genre->save();
    }
}
