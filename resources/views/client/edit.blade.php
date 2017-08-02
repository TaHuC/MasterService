@extends('layouts.app')

@section('content')
    <div class="container">
        <br>
        <div class="row">
            <div class="col m6 offset-m3 z-depth-4 grey lighten-3" id="add-client-col">
                <div class="row">
                    <h4 class="title">Edit Client</h4>
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('client.update', $client->id) }}">
                        {{ csrf_field() }}
                        <input name="_method" type="hidden" value="PUT">

                        <div class="input-field col s12 {{ $errors->has('name') ? ' has-error' : '' }}">

                            <input id="name" type="text" autocomplete="off" class="validate" name="name" value="{{ $client->name }}" required autofocus>
                            <label for="name" class="active">Name</label>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="input-field col s12 {{ $errors->has('email') ? ' has-error' : '' }}">
                            <input id="email" type="email" autocomplete="off" class="validate" name="email" value="{{ $client->email }}">
                            <label for="email" class="active">E-Mail Address</label>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="input-field col s12 {{ $errors->has('phone') ? ' has-error' : '' }}">
                            <input id="phone" type="text" autocomplete="off" class="validate" name="phone" value="{{ $client->phone }}" required>
                            <label for="phone" class="active">Phone Number</label>
                            @if ($errors->has('phone'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="col s12 right-align">
                            <button type="submit" class="btn-large orange accent-4 btn waves-effect waves-light">
                                <i class="material-icons">edit</i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection