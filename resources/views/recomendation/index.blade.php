@extends('layouts.app')

@section('title', 'Recomendaciones Personalizadas')

@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
@section('content')
    <div class="movies-list">
        <h1>Recomendaciones</h1>
        @if(!$moviesRecommPaginated->isEmpty())
            @foreach ($moviesRecommPaginated as $movie)
                <div class="movie-item">
                    <div class="container">
                        <div class="row">
                          <div class="col-12 col-sm-4">
                            <img src="{{ $movie->image }}" class="img-fluid" alt="{{ $movie->title }}">
                          </div>

                          <div class="col-12 col-sm-8">
                            <h2>{{ $movie->title }}</h2>
                            <p><i><b>Calificación:</b></i> {{ $movie->rate }}/10</p>
                            <p class="text-to-truncate"><i><b>Descripción: </b></i> {{ $movie->description }}</p>
                            <a href="{{ route('movie.details', ['id' => $movie->id]) }}" class="btn btn-link see-more">Ver más</a>
                            <p><i><b>Géneros:</b></i> 
                                {{ implode(', ', $movie->genres->pluck('name')->toArray()) }}
                            </p>
                            <p><i><b>Año de lanzamiento:</b></i> {{ $movie->release_year }}</p>
                            <a href="{{ route('recommendation.addpending', ['id' => $movie->id]) }}" class="btn btn-link see-more">Añadir a pendientes</a>
                          </div>
                        </div>
                    </div>
                    <hr>
                </div>
            @endforeach
        @else
            <h1>No hay recomendaciones para mostrar, prueba a cambiar tus generos favoritos.</h1>
        @endif
    </div>

    <div class="pagination">
        <p>Mostrando del {{ $moviesRecommPaginated->firstItem() }} hasta el {{ $moviesRecommPaginated->lastItem() }} de {{ $moviesRecommPaginated->total() }}</p>
    </div>
    <div class="pagination">
        <p>{{ $moviesRecommPaginated->links('pagination::bootstrap-4') }}</p>
    </div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection