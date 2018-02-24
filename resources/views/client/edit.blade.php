@extends('layouts.app')

@section('content')
    <div class="container">
        <br>
        <div class="row col-12 justify-content-center">
            <div class="col-6 bg-dark mb-3 text-white align-middle" id="add-client-col">
                <h4 class="title">Add Client</h4>
                <form class="" role="form" method="post" action="{{ route('client.update', $client->id) }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="put">
                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="active">Name</label>
                        <input id="name" type="text" autocomplete="off" class="form-control" name="name" value="{{ $client->name }}" required autofocus>
                        @if ($errors->has('name'))
                            <span class="form-text">
                                  <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('idNumber') ? ' has-error' : '' }}">
                        <label for="idNumber" class="active">ID Number</label>
                        <input id="idNumber" type="text" autocomplete="off" class="form-control" name="idNumber" value="{{ $client->idNumber }}">
                        @if ($errors->has('idNumber'))
                            <span class="form-text">
                                <strong>{{ $errors->first('idNumber') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="active">E-Mail Address</label>
                        <input id="email" type="email" autocomplete="off" class="form-control" name="email" value="{{ $client->email }}">
                        @if ($errors->has('email'))
                            <span class="form-text">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label for="phone" class="active">Phone Number</label>
                        <input id="phone" type="text" autocomplete="off" class="form-control" name="phone" value="{{ $client->phone }}" required>
                        @if ($errors->has('phone'))
                            <span class="form-text">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" data-toggle="tooltip" data-placement="top" title="Запамети" class="btn btn-outline-primary">
                            <i class="material-icons">save</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection