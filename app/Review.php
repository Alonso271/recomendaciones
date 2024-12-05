<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'movie_id'];
    protected $table = 'reviews';
    
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function movie()
    {
        return $this->belongsTo('App\Movie', 'movie_id');
    }
    
    public function reviewLikes() 
    {
        return $this->hasMany('App\ReviewLike');
    }
}
