<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'image',
        'description',
        'rate',
        'duration',
        'release_year',
    ];
    
    protected $table = 'movies';
    
    public function genres()
    {
        return $this->belongsToMany('App\Genre');
    }
    
    public function recommendations() 
    {
        return $this->hasMany('App\Recommendation');
    }
    
    public function reviews() 
    {
        return $this->hasMany('App\Review');
    }
    
    public function linkprovider() 
    {
        return $this->hasMany('App\LinkProvider');
    }
}
