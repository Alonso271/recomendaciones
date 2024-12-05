<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\GenreUser;
use App\GenreMovie;
use App\Recommendation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected function redirectTo()
    {
        return route('movie.index');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user =User::create([
            'role' => 'user',
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]); 
        
        if(!empty($data['genres'])){
            foreach ($data['genres'] as $genre => $id){
                GenreUser::create(['user_id'=>$user->id, 'genre_id' => $id]);
            }   
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
        return $user;
    }
    
    public function showRegistrationForm()
    {
        $genres = \App\Genre::all();
        return view('auth.register', compact('genres'));
    }
    
}
