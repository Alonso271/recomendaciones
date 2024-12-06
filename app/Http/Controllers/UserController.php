<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Genre;
use App\Models\GenreUser;
use App\Models\GenreMovie;
use App\Models\Recommendation;

use GuzzleHttp\Client;

class UserController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function config() 
    {
        $genres     = Genre::all();
        $genreUsers = GenreUser::where('user_id', Auth::user()->id)->get();
        return view('user.config', compact('genres', 'genreUsers'));
    }
    
    public function update(Request $request) 
    {
        $user = \Auth::user();

        GenreUser::where('user_id', $user->id)->delete();
        Recommendation::where('user_id', $user->id)->where('viewed', '!=', 1)->delete();

        $validate = $this->validate($request, [
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $name  = $request->input('name');
        $email = $request->input('email');

        $user->name  = $name;
        $user->email = $email;

        if (!empty($request->genres)) {
            foreach ($request->genres as $genre => $id) {
                GenreUser::create(['user_id' => $user->id, 'genre_id' => $id]);
            }

            $genresUsers = GenreUser::where('user_id', $user->id)->get();
            $genresMovies = GenreMovie::get();

            foreach ($genresUsers as $genreUser) {
                foreach ($genresMovies as $genreMovie) {
                    if ($genreUser->genre_id == $genreMovie->genre_id) {
                        Recommendation::firstOrCreate([
                            'user_id'  => $user->id,
                            'movie_id' => $genreMovie->movie_id,
                        ], [
                            'viewed' => 0,
                        ]);
                    }
                }
            }
        }

        $image = $request->file('image');
        if ($image) {
            $apiKey = env('CLOUDINARY_API_KEY');
            $apiSecret = env('CLOUDINARY_API_SECRET');
            $cloudName = env('CLOUDINARY_CLOUD_NAME');

            // URL de la API de Cloudinary para subir la imagen
            $url = "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload";

            // Preparar los datos para la solicitud POST
            $filePath = $image->getPathname(); // Obtiene la ruta temporal del archivo
            $uploadPreset = 'ml_default'; // Usando tu upload preset "ml_default"

            // Inicializar cURL para hacer la solicitud POST
            $client = new Client();
            try {
                $response = $client->request('POST', $url, [
                    'verify' => false,
                    'multipart' => [
                        [
                            'name'     => 'file',
                            'contents' => fopen($filePath, 'r'),
                        ],
                        [
                            'name'     => 'upload_preset',
                            'contents' => $uploadPreset, // Usamos el upload preset "ml_default"
                        ],
                        [
                            'name'     => 'api_key',
                            'contents' => $apiKey,  // Incluye tu API Key
                        ]
                    ]
                ]);

                $responseData = json_decode($response->getBody(), true);

                if (isset($responseData['secure_url'])) {
                    // Si la imagen fue subida correctamente a Cloudinary, guarda la URL pública
                    $user->image = $responseData['secure_url'];
                } else {
                    // Si no se obtiene la URL, puedes manejar el error según sea necesario
                    return redirect()->route('config')->with(['message' => 'Error al subir la imagen a Cloudinary']);
                }
            } catch (\Exception $e) {
                return redirect()->route('config')->with(['message' => 'Error al intentar conectar con Cloudinary: ' . $e->getMessage()]);
            }
        }

        $user->update();

        return redirect()->route('config')->with(['message' => 'Usuario actualizado correctamente']);
    }

    public function getImage($fileName) 
    {
        $file = Storage::disk('users')->get($fileName);
        
        return new Response($file, 200);
    }
    
}
