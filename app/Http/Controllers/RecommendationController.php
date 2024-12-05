<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function index()
    {
        $personalRecomm = Recommendation::where('user_id', Auth::user()->id)
        ->where('viewed', '!=', 1)
        ->with('movie')
        ->get()
        ->pluck('movie');
        
        $moviesRecomm = collect($personalRecomm)->unique('id')
        ->sortByDesc('rate')
        ->values();

        $page = request('page', 1);
        $perPage = 5;
        $paginatedMovies = $moviesRecomm->forPage($page, $perPage);

        $moviesRecommPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedMovies,
            $moviesRecomm->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('recomendation.index', compact('moviesRecommPaginated'));
    }
    
    public function listPendings() 
    {
        $personalRecomm = Recommendation::where('user_id', Auth::user()->id)
        ->where('viewed', '!=', 1)
        ->where('pending', '=', 1)
        ->with('movie')
        ->get()
        ->pluck('movie');
        
        $moviesRecomm = collect($personalRecomm)->unique('id')
        ->sortByDesc('rate')
        ->values();

        $page = request('page', 1);
        $perPage = 5;
        $paginatedMovies = $moviesRecomm->forPage($page, $perPage);

        $moviesRecommPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedMovies,
            $moviesRecomm->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('recomendation.list-pendings', compact('moviesRecommPaginated'));
    }
    
    public function removepending(Request $request)
    {
        $personalRecomm = Recommendation::where('user_id', Auth::user()->id)
            ->where('movie_id', $request->id)
            ->first();

        if ($personalRecomm) {
            $personalRecomm->pending = 0;
            $personalRecomm->save();
            return redirect()->back()->with('message', 'Película quitada de pendientes correctamente.');
        } else {
            return redirect()->back()->with('error', 'No se encontró la recomendación.');
        }
    }
    
    public function addpending(Request $request)
    {
        $personalRecomm = Recommendation::where('user_id', Auth::user()->id)
            ->where('movie_id', $request->id)
            ->first();

        if ($personalRecomm) {
            $personalRecomm->pending = 1;
            $personalRecomm->save();
            return redirect()->back()->with('message', 'Película añadida a pendientes correctamente.');
        } else {
            return redirect()->back()->with('error', 'No se encontró la recomendación.');
        }
    }
}
