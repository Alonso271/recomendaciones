<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewLikesController extends Controller
{
    public function like(Request $request)
    {
        if (!Auth::check()) {
        return response()->json([
            'message' => 'Debes iniciar sesión para dar like a un comentario.',
            'type' => 'error'
        ], 401);
    }

        $review = Review::findOrFail($request->review_id);

        $review->reviewLikes()->where('user_id', Auth::user()->id)->where('is_like', false)->delete();

        $likeExists = $review->reviewLikes()->where('user_id', Auth::user()->id)->where('is_like', true)->exists();

        if ($likeExists) {
            $review->reviewLikes()->where('user_id', Auth::user()->id)->delete();
        } else {
            $review->reviewLikes()->create([
                'user_id' => Auth::user()->id,
                'is_like' => true
            ]);
        }

        $likesCount = $review->reviewLikes()->where('is_like', true)->count();
        $dislikesCount = $review->reviewLikes()->where('is_like', false)->count();

        return response()->json(['likes_count' => $likesCount, 'dislikes_count' => $dislikesCount]);
    }

    public function dislike(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Debes iniciar sesión para dar dislike a un comentario.',
                'type' => 'error'
            ], 401);
        }
        $review = Review::findOrFail($request->review_id);

        $review->reviewLikes()->where('user_id', Auth::user()->id)->where('is_like', true)->delete();

        $dislikeExists = $review->reviewLikes()->where('user_id', Auth::user()->id)->where('is_like', false)->exists();

        if ($dislikeExists) {
            $review->reviewLikes()->where('user_id', Auth::user()->id)->delete();
        } else {
            $review->reviewLikes()->create([
                'user_id' => Auth::user()->id,
                'is_like' => false
            ]);
        }

        $likesCount = $review->reviewLikes()->where('is_like', true)->count();
        $dislikesCount = $review->reviewLikes()->where('is_like', false)->count();

        return response()->json(['likes_count' => $likesCount, 'dislikes_count' => $dislikesCount]);
    }
}
