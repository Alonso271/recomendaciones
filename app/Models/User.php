<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role', 'name', 'image','email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function genres()
    {
        return $this->belongsToMany('App\Models\Genre');
    }
    
    public function recommendations() 
    {
        return $this->hasMany('App\Models\Recommendation');
    }
    
    public function reviews() 
    {
        return $this->hasMany('App\Models\Review');
    }
    
    public function reviewLikes() 
    {
        return $this->hasMany('App\Models\ReviewLike');
    }
    
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
