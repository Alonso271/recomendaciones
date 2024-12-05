<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $table = 'recommendations';
    
    protected $fillable = [
        'user_id', 'movie_id', 'viewed'
    ];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function movie()
    {
        return $this->belongsTo('App\Models\Movie', 'movie_id');
    }
}
