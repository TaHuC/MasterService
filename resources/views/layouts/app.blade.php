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
    {{--  <link href="{{ asset('css/master.css') }}" rel="stylesheet">  --}}
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    {{--  <link href="{{ asset('css/plugins/dataTables.bootstrap4.min.css') }}" rel="stylesheet">  --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.0.0/dt-1.10.16/r-2.2.1/datatables.min.css"/>
    <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
    @yield('cssImport')

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
  <div id="app" >
    @if (!Auth::guest())
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Company name</a>
      
        <div class="input-group">
            <input class="form-control form-control-dark" type="text" @keyup.enter="searchit" v-model="search"  placeholder="Search" aria-label="Search">
          <div class="input-group-append" id="button-addon4">
              <button class="btn btn-outline-light" style="border-radius: 0%;" @click="searchit" type="button"><i class="fa fa-search"></i></button>
              <button class="btn btn-outline-light" style="border-radius: 0%;" @click="addNewClient" type="button"><i class="fa fa-plus"></i></button>
          </div>
        </div>
      <ul class="navbar-nav px-3"></ul>
      
    </nav>
    @endif
    <div class="container-fluid">
        @if(!Auth::guest())
        <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-dark text-white sidebar">
          <div class="sidebar-sticky">

            <div class="card border-danger mb-3 bg-dark text-white" style="max-width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title text-uppercase text-danger text-center">{{ Auth::user()->name }}</h5>
                    <div class="mx-auto" style="width: 100px;">
                        <a class="btn btn-link text-white-50 btn-sm" href="{{ route('settings') }}"><i class="fa fa-cogs"></i></a>
                        <a class="btn btn-link text-white-50 btn-sm" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            <i class="fa fa-power-off"></i>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>    
                    </div>
                </div>
            </div>   

            <div class="card border-danger mb-3 bg-dark text-white" style="max-width: 18rem;">
                <div class="card-body">
                    <h6 class="card-title text-uppercase text-danger text-center">Поръчки</h6>
                    <a href="#" class="badge badge-light">2222</a>
                    <a href="#" class="badge badge-light">2222</a>
                    <a href="#" class="badge badge-light">2222</a>
                    <a href="#" class="badge badge-light">2222</a>
                    <a href="#" class="badge badge-light">2222</a>
                    <a href="#" class="badge badge-light">2222</a>
                    <a href="#" class="badge badge-light">2222</a>
                    <a href="#" class="badge badge-light">2222</a>
                    <a href="#" class="badge badge-light">2222</a>
                    <a href="#" class="badge badge-light">2222</a>
                </div>
            </div>  
            

            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="#">
                  <span data-feather="home"></span>
                  Dashboard <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file"></span>
                  Orders
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="shopping-cart"></span>
                  Products
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="users"></span>
                  Customers
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="bar-chart-2"></span>
                  Reports
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="layers"></span>
                  Integrations
                </a>
              </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Saved reports</span>
              <a class="d-flex align-items-center text-muted" href="#">
                <span data-feather="plus-circle"></span>
              </a>
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file-text"></span>
                  Current month
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file-text"></span>
                  Last quarter
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file-text"></span>
                  Social engagement
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file-text"></span>
                  Year-end sale
                </a>
              </li>
            </ul>
          </div>
        </nav>
        @endif
        <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4 pt-48">
            <div class="row">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="col-md-8 col-lg-9 col-sm float-left">
                  <router-view></router-view>
                </div>
                @if (!Auth::guest())
                <div class="col-md-4 col-lg-3 col-sm float-right">

                  <forParts></forParts>

                  <tasks></tasks>
                </div>
                  
                  
                @endif
              </div>
                @yield('content')
            </div>
        </main>    
      </div>
    </div> 

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/remote.js') }}"></script>
    <script src="{{ asset('js/notifycations.js') }}"></script>
    {{--  <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>  --}}
    {{--  <script src="{{ asset('js/plugins/dataTables.bootstrap4.min.js') }}"></script>  --}}
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.0.0/dt-1.10.16/r-2.2.1/datatables.min.js"></script>
    <script src="{{ asset('js/appMaster.js') }}"></script>
    @yield('jsImport')
</body>
</html>
