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
    
    public function delete(Request $request, $review_id)
    {
        $review = Review::find($review_id);

        if ($review) {
            $review->delete();
            return response()->json(['success' => true], 200);  // Respuesta exitosa
        }

        return response()->json(['success' => false, 'message' => 'No se encontró el comentario para eliminar.'], 404);  // Error
    }
}
