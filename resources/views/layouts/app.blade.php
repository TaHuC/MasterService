<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Master Service') }}</title>

    <!-- Fonts -->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/master.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
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
        <nav class="navbar navbar-expand-md navbar-dark bg-dark justify-content-between">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/home') }}">
                 {{ config('app.name', 'Master Service') }}
            </a>

                <!-- Right Side Of Navbar -->
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li class="nav-item" ><a class="btn btn-outline-success my-2 my-sm-0" href="{{ route('login') }}">Login</a></li>
                    @if(\App\Settings::no_reg() === 0)
                        <li class="nav-item" ><a class="btn btn-outline-success my-2 my-sm-0" href="{{ route('register') }}">Register</a></li>
                    @endif
                    @else
                        <li class="nav-item dropdown">
                            <a href="#" class="dropdown-toggle btn btn-outline-success my-2 my-sm-0" data-toggle="dropdown" id="userDropdown">
                                references <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <li class="nav-item text-center">
                                    <a class="btn btn-outline-success my-2 my-sm-0" href="{{ route('client.index') }}">Clients</a>
                                </li>
                                <li class="nav-item text-center">
                                    <a class="btn btn-outline-success my-2 my-sm-0" href="{{ route('product.index') }}">Devices</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a href="#" class="btn btn-outline-success my-2 my-sm-0 dropdown-toggle" data-toggle="dropdown" id="userDropdown">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <li class="nav-item text-center">
                                    <a class="btn btn-outline-warning my-2 my-sm-0" href="{{ route('settings') }}">Настройки</a>
                                </li>
                                <li class="nav-item text-center">
                                    <a class="btn btn-outline-warning my-2 my-sm-0" href="{{ route('logout') }}"
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
                @if(!Auth::guest())
                <div class="form-inline my-2 my-lg-0">
                    {{ csrf_field() }}
                    <input class="form-control mr-sm-2" id="idOrder" type="search" placeholder="Order ID" aria-label="Order">
                    <button class="btn btn-outline-success my-2 my-sm-0" id="loadOrderBtn">Load</button>
                </div>
                    <ul class="navbar-nav">
                        <li class="nav-item align-bottom">
                            <a href="{{ route('client.create') }}" class="btn btn-outline-success my-2 my-sm-0">Add</a>
                        </li>
                    </ul>
                @endif
            </div>
        </nav>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/remote.js') }}"></script>
    <script src="{{ asset('js/notifycations.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/appMaster.js') }}"></script>
    @yield('jsImport')
</body>
</html>
