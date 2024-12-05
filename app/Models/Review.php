<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'movie_id'];
    protected $table = 'reviews';
    
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function movie()
    {
        return $this->belongsTo('App\Models\Movie', 'movie_id');
    }
    
    public function reviewLikes() 
    {
        return $this->hasMany('App\Models\ReviewLike');
    }
}
