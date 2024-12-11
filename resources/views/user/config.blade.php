@extends('layouts.app')

@section('title', 'Configuración')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @if(session('message'))
                <div class="alert alert-success"> 
                    {{ session('message') }}
                </div>
            @endif
            
            <div class="card">
                <div class="card-header">Configuració de mi cuenta</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.update') }}" enctype='multipart/form-data' aria-label="Configuración de mi cuenta">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Auth::user()->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ Auth::user()->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Avatar') }}</label>
                            <div class="col-md-6">
                                @include('includes.avatar')
                                
                                <input id="image" type="file" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image">

                                @if ($errors->has('image'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="container">
                            <h5 class="row justify-content-center">Selecciona tus géneros favoritos</h5>
                            <div class="row justify-content-center">
                                @foreach($genres as $genre)
                                    <div class="col-3 d-flex justify-content-center align-items-center mb-3">
                                        <div class="form-check form-group">
                                            <input 
                                                class="form-check-input cursor-hand" 
                                                type="checkbox" 
                                                name="genres[]" 
                                                id="genre{{$genre->id}}" 
                                                value="{{$genre->id}}" 
                                                {{ $genreUsers->contains('genre_id', $genre->id) ? 'checked' : '' }}
                                            >
                                            <label class="form-check-label cursor-hand" for="genre{{$genre->id}}">
                                                {{$genre->name}}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Guardar cambios
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection