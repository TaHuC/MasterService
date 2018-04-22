@extends('layouts.app')

@section('content')
    <div class="container">
    <br>
        <div class="row col-12 justify-content-center">
            <div class="col-md-6 col-xs-12 bg-dark mb-3 text-white align-middle" id="add-client-col">
                <h4 class="title">Login</h4>
                <form class="" role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="form-group col-12 {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="control-label">E-Mail Address</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                        @endif
                    </div>

                    <div class="form-group col-12 {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="control-label">Password</label>
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                        @endif
                    </div>

                    <div class="form-group col-12 text-right">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Remember Me</label>
                    </div>

                    <div class="form-group col-12 text-right">
                        <button type="submit" class="btn btn-outline-primary" data-position="bottom" data-delay="50" data-tooltip="Login">
                            <i class="material-icons">play_arrow</i>
                        </button>

                        <a class="btn btn-outline-warning" href="{{ route('password.request') }}" data-position="bottom" data-delay="50" data-tooltip="Forgot password!">
                            <i class="material-icons">warning</i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('jsImport')

@endsection
