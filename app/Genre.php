<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = [
        'name'
    ];
    
    protected $table = 'genres';
    
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    
    public function movies()
    {
        return $this->belongsToMany('App\Movie');
    }
}
