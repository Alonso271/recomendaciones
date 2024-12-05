<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GenreUser extends Model
{
    protected $table = 'genre_user';
    
    protected $fillable = [
        'user_id', 'genre_id'
    ];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function genre()
    {
        return $this->belongsTo('App\Models\Genre', 'genre_id');
    }
}
