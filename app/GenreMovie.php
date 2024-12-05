<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GenreMovie extends Model
{
    protected $table = 'genre_movie';
    
    
    public function movie()
    {
        return $this->belongsTo('App\Movie', 'movie_id');
    }
    
    public function genre()
    {
        return $this->belongsTo('App\Genre', 'genre_id');
    }
    
    public function updateOrCreate($genreId, $movieId) 
    {
        
    }
}
