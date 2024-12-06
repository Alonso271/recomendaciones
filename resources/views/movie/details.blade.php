@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
@extends('layouts.app')

@section('title', $movie->title)

@section('content')

    <div class="row justify-content-center mb-3 ml-2 mr-2 ml-lg-0 mr-lg-0">
        <div class="col-lg-2 col-sm-8">
            <img src="{{ $movie->image }}" class="img-fluid w-100" alt="{{ $movie->title }}">
        </div>
        <div class="col-lg-6 col-sm-8">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="{{ $movie->video }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-8">
            <p>{{ $movie->description }}</p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-8">
            <h5>Donde ver: </h5>         
            @if(count($movie->LinkProvider) === 0)
                <p>No tenemos informacion de donde ver la película.</p>
            @else
                <ul>
                    @foreach ($movie->LinkProvider as $provider)
                        @if(is_null($provider->link))
                            <li>
                                {{ $provider->name }} (No tenemos link para este sitio.)
                            </li>
                        @else
                            <li>
                                <a href="{{ $provider->link }}" target="_blank">{{ $provider->name }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
<div class="row justify-content-center mb-4">
    <div class="col-8 text-left">
        <h1>Comentarios</h1>
    </div>
    @if($movie->reviews->isEmpty())
        <div class="col-8 text-left">
                <p>No hay comentarios</p>
        </div>
    @else
        @foreach ($movie->reviews as $review)
            <div class="col-8 text-left">
                <h4>{{$review->title}}</h4>
                <div>
                    {{ e(wordwrap($review->description, 100, "\n", true)) }}
                </div>
                <a href="#" id="like-btn-{{ $review->id }}" class="me-4 text-reset" data-review-id="{{ $review->id }}" data-url="{{ route('review.like', ['review_id' => $review->id]) }}">
                    <i class="fas fa-thumbs-up fa-lg"></i>
                    <span id="likes-count-{{ $review->id }}">{{ $review->reviewLikes()->where('is_like', true)->count() }}</span>
                </a>

                <a href="#" id="dislike-btn-{{ $review->id }}" class="me-4 text-reset" data-review-id="{{ $review->id }}" data-url="{{ route('review.dislike', ['review_id' => $review->id]) }}">
                    <i class="fas fa-thumbs-down fa-lg"></i>
                    <span id="dislikes-count-{{ $review->id }}">{{ $review->reviewLikes()->where('is_like', false)->count() }}</span>
                </a>
                @if(!empty(\Auth::user()) && \Auth::user()->id == $review->user_id)
                    <a href="{{ route('review.delete', ['id' => $review->id]) }}" class="btn btn-link see-more">Eliminar comentario</a>
                @endif
            </div>
        @endforeach
    @endif
    <div class="col-8 text-left">
        <button id="showFormBtn" class="btn btn-primary mt-3">Añade un comentario</button>
    </div>
    <div class="col-8 text-center">
        <div id="reviewForm" style="display: none;">
            <h2>Crear Comentario para {{ $movie->title }}</h2>
            <form action="{{ route('review.store', ['movie_id' =>$movie->id]) }}" method="POST" style="display: flex; flex-direction: column; align-items: center;">
                @csrf
                <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                <div class="form-group" style="width: 100%; max-width: 600px;">
                    <label for="title" class="w-100 text-start">Título:</label>
                    <input name="title" id="title" class="form-control mb-3">
                    <label for="description" class="w-100 text-start">Descripción:</label>
                    <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Crear Comentario</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection

