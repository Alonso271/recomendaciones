<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $table = 'recommendations';
    
    protected $fillable = [
        'user_id', 'movie_id', 'viewed'
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function movie()
    {
        return $this->belongsTo('App\Movie', 'movie_id');
    }
}
