
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Peliculas Recomendadas')</title>
    
    <!-- Favicon para navegadores modernos -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/Recomendaciones.png') }}">

    <!-- Scripts -->
    <script src="{{ app()->environment('local') ? asset('js/app.js') : secure_asset('js/app.js') }}" defer></script>
    <script src="{{ app()->environment('local') ? asset('js/truncate-text.js') : secure_asset('js/truncate-text.js') }}"></script>
    <script src="{{ app()->environment('local') ? asset('js/show-form.js') : secure_asset('js/show-form.js') }}"></script>
    <script src="{{ app()->environment('local') ? asset('js/like.js') : secure_asset('js/like.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ app()->environment('local') ? asset('css/app.css') : secure_asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ app()->environment('local') ? asset('css/style.css') : secure_asset('css/style.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Recomendaciones
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ route('recommendation.index') }}">Recomendaciones personalizadas</a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ route('recommendation.listpendings') }}">Lista de pendientes</a>
                            </li>
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Iniciar sesion</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                            </li>
                        @else
                            @if(Auth::user()->isAdmin())
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('movie.create') }}">Añadir Película</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('genre.create') }}">Añadir Genero</a>
                                </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    
                                    <a class="dropdown-item" href="{{route('config')}}">
                                       Configuración
                                    </a>
                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Cerrar sesion
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
                <div class="navbar-avatar">
                    @include('includes.avatar')
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        @yield('footer')
    </div>
</body>
</html>
