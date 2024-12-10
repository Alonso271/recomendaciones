@extends('layouts.app')
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@if(session('message'))
    <div class="alert alert-success "> 
        {{ session('message') }}
    </div>
@endif
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card">
                <div class="card-header">Añadir Película</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('movie.store') }}" enctype='multipart/form-data' aria-label="Añadir Película">
                        @csrf

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Título</label>
                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" placeholder="Título de la película" required autofocus>

                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Añadir
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


