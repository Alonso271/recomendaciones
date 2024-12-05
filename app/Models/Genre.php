<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = [
        'name'
    ];
    
    protected $table = 'genres';
    
    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }
    
    public function movies()
    {
        return $this->belongsToMany('App\Models\Movie');
    }
}
