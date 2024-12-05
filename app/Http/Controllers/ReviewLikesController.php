<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Review;

class ReviewLikesController extends Controller
{
    public function like(Request $request)
{
    $review = Review::findOrFail($request->review_id);
    
    $likeExists = $review->reviewLikes()->where('user_id', Auth::user()->id)->exists();

    if ($likeExists) {
        $review->reviewLikes()->where('user_id', Auth::user()->id)->delete();
    } else {
        $review->reviewLikes()->create([
            'user_id' => Auth::user()->id,
            'is_like' => true
        ]);
    }

    $likesCount = $review->reviewLikes()->where('is_like', true)->count();

    return response()->json(['likes_count' => $likesCount]);
}

    
    public function dislike(Request $request) {
        
    }
}
