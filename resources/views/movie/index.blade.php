@extends('layouts.app')

@section('content')

    <div class="movies-list">
        <h1>Películas Destacadas</h1>
        @if(!$movies->isEmpty())
            @foreach ($movies as $movie)
                <div class="movie-item">
                    <div class="container">
                        <div class="row">
                          <div class="col-12 col-md-3 col-lg-4 mb-3 mb-lg-0 mb-md-0">
                            <a href="{{ route('movie.details', ['id' => $movie->id]) }}"><img src="{{ $movie->image }}" class="img-fluid" alt="{{ $movie->title }}"></a>
                          </div>

                           <div class="col-12 col-md-9 col-lg-8">
                            <h2>{{ $movie->title }}</h2>
                            <p><i><b>Calificación: </b></i> {{ $movie->rate }}/10</p>
                            <p class="text-to-truncate"><i><b>Descripción: </b></i> {{ $movie->description }}</p>
                            <a href="{{ route('movie.details', ['id' => $movie->id]) }}">Ver más</a>
                            <p><i><b>Géneros:</b></i> 
                                {{ implode(', ', $movie->genres->pluck('name')->toArray()) }}
                            </p>
                            <p><i><b>Año de lanzamiento:</b></i> {{ $movie->release_year }}</p>
                          </div>
                        </div>
                    </div>
                    <hr>
                </div>
            @endforeach
        @else
            <h1>No hay películas en la base de datos.</h1>
        @endif
    </div>

    <div class="pagination-container">
        <p class="pagination-text">
            Mostrando del {{ $movies->firstItem() }} hasta el {{ $movies->lastItem() }} de {{ $movies->total() }}
        </p>

        <div class="pagination">
            {{ $movies->links('pagination::bootstrap-4') }}
        </div>
    </div>

@endsection

@section('footer')
    @include('layouts.footer')
@endsection

