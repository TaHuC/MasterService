<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Master Service') }}</title>

    <!-- Fonts -->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/materialize.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/master.css') }}" rel="stylesheet">
    @yield('cssImport')

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        <nav class="">
            <div class="nav-wrapper navbar-fixed navbar-fixed-top blue">

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                         {{ config('app.name', 'Master Service') }}
                    </a>
                    <a href="#" data-activates="modeli_navigation" class="button-collapse">
                        <i class="material-icons">menu</i>
                    </a>

                    <!-- Right Side Of Navbar -->
                    <ul class="right hide-on-med-and-down">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li>
                                <form method="get" action="{{ route('search.index') }}">
                                    <div class="input-field">
                                        <input id="search" type="search" required autocomplete="off">
                                        <label class="label-icon" for="search">
                                            <i class="material-icons">search</i>
                                        </label>
                                        <i class="material-icons">close</i>
                                    </div>
                                </form>
                            </li>
                            <li class="user-menu-li">
                                <a href="#" class="dropdown-button" data-activates="user-dropdown-menu">
                                    {{ Auth::user()->name }} <i class="material-icons right">arrow_drop_down</i>
                                </a>
                                <ul class="dropdown-content" id="user-dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>

                        @if(Auth::user())
                            <ul>
                                <li>
                                    <a href="{{ route('client.create') }}" class="btn-floating btn-large halfway-fab amber darken-4 waves-effect waves-light">
                                        <i class="material-icons">add</i>
                                    </a>
                                </li>
                            </ul>
                        @endif

                    <ul class="nav side-nav" id="modeli_navigation">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li>
                                <a href="{{ route('client.create') }}" class="btn btn-link">Add</a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="{{ asset('js/materialize.min.js') }}"></script>
    @yield('jsImport')
</body>
</html>
