@extends('layouts.app')

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
                <div class="card-header">Añadir Genero</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('genre.store') }}" enctype='multipart/form-data' aria-label="Añadir Genero">
                        @csrf             
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
