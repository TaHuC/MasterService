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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
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
            <input class="form-control form-control-dark" type="text" @keyup.enter="searchit" v-model="search" @click="search = null" placeholder="Search" aria-label="Search">
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
                        <a class="btn btn-link text-white-50 btn-sm" href="/usersettings"><i class="fa fa-cogs"></i></a>
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
            {{-- menu --}}
            {{--             
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="#">
                  <span data-feather="home"></span>
                  Dashboard <span class="sr-only">(current)</span>
                </a>
              </li>
            </ul> --}}
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

                  <vue-topprogress ref="topProgress"></vue-topprogress>
                  <instantly></instantly>
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
    <!-- <script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script> -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="{{ asset('js/remote.js') }}"></script>
    <script src="{{ asset('js/notifycations.js') }}"></script>
    {{--  <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>  --}}
    {{--  <script src="{{ asset('js/plugins/dataTables.bootstrap4.min.js') }}"></script>  --}}
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.0.0/dt-1.10.16/r-2.2.1/datatables.min.js"></script>
    <script src="{{ asset('js/appMaster.js') }}"></script>
    @yield('jsImport')
</body>
</html>
