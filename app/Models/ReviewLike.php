<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewLike extends Model
{
    protected $fillable = ['user_id', 'review_id', 'is_like'];
   
    protected $table = 'review_likes';
    
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function review()
    {
        return $this->belongsTo('App\Models\Review', 'review_id');
    }
}
