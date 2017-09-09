@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col s8 offset-s2">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <h4 class="card-title">Login</h4>

                        <form class="col s12" role="form" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            <div class="input-field col s12 {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="control-label">E-Mail Address</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                            </div>

                            <div class="input-field col s12 {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="control-label">Password</label>
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                            </div>

                            <div class="input-field col s12 right-align">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">Remember Me</label>
                            </div>

                            <div class="input-field col s12 right-align">
                                <button type="submit" class="waves-effect waves-light btn blue tooltipped" data-position="bottom" data-delay="50" data-tooltip="Login">
                                    <i class="material-icons">play_arrow</i>
                                </button>

                                <a class="waves-effect waves-light btn orange tooltipped" href="{{ route('password.request') }}" data-position="bottom" data-delay="50" data-tooltip="Forgot password!">
                                    <i class="material-icons">warning</i>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('jsImport')

@endsection
