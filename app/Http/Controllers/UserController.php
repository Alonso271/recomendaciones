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
        $user     = \Auth::user();
        GenreUser::where('user_id',$user->id)->delete();
        Recommendation::where('user_id',$user->id)->where('viewed', '!=', 1)->delete();
        $validate = $this->validate($request, [
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ]);
        
        $name  = $request->input('name');
        $email = $request->input('email');
        
        $user->name  = $name;
        $user->email = $email;
        
        if (!empty($request->genres)){
            foreach ($request->genres as $genre => $id){
            GenreUser::create(['user_id'=>$user->id, 'genre_id' => $id]);
            }

            $genresUsers = GenreUser::where('user_id', $user->id)->get();
            $genresMovies = GenreMovie::get();

            foreach($genresUsers as $genreUser){
                foreach($genresMovies as $genreMovie){
                if($genreUser->genre_id == $genreMovie->genre_id){
                    Recommendation::firstOrCreate([
                    'user_id'  => $user->id,
                    'movie_id' => $genreMovie->movie_id,
                    ], [
                    'viewed'   => 0,
                    ]);
                }
                }
            }
        }
        
        $image = $request->file('image');
        if($image){
            $image_name = time().$image->getClientOriginalName();
            
            Storage::disk('users')->put($image_name, File::get($image));
            
            $user->image = $image_name;
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
