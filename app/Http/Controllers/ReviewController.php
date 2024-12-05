<?php

namespace App\Http\Controllers;

use App\Models\Review;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request) 
    {
       if(is_null(Auth::user())){
           return redirect()->back()->with('error', 'Debes iniciar sesión para crear un comentario.');
       }else{
            $review = new Review();
       
            $review->movie_id = $request->movie_id;
            $review->user_id = Auth::user()->id;
            $review->description = $request->description;
            $review->title = $request->title;

            $review->save();
       }
       return redirect()->back()->with('message', 'Comentario añadido correctamente.');
    }
    
    public function delete(Request $request)
{
    $review = Review::where('id', $request->id)
        ->first();

    if ($review) {
        $review->delete();
        return redirect()->back()->with('message', 'Comentario eliminado correctamente.');
    }

    return redirect()->back()->with('error', 'No se encontró el comentario para eliminar.');
}
}
