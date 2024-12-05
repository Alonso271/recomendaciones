<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkProvider extends Model
{
    protected $table = 'providers_link';
    
    protected $fillable = ['movie_id', 'name', 'link'];

    // Relación con Movie
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}

