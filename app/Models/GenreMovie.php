<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GenreMovie extends Model
{
    protected $table = 'genre_movie';
    
    
    public function movie()
    {
        return $this->belongsTo('App\Models\Movie', 'movie_id');
    }
    
    public function genre()
    {
        return $this->belongsTo('App\Models\Genre', 'genre_id');
    }
    
    public function updateOrCreate($genreId, $movieId) 
    {
        
    }
}
