@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Client Profile</div>
                        <div class="panel-body text-left">
                            <div class="row">
                                <div class="col-md-2 col-xs-4 text-center">
                                        <a class="" href="#">
                                            <img class="media-object dp img-circle" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" style="width: 180px;height:180px;">
                                        </a>
                                </div>
                                <div class="col-md-10 col-xs-8">
                                    <h2>{{ $client->name }} <a href="{{ route('client.edit', ['id' => $client->id]) }}" class="btn btn-xs btn-warning">Edit</a></h2>
                                    <p>
                                        <p><i class="glyphicon glyphicon-envelope"></i> {{ $client->email }}</p>
                                        <p></p><i class="glyphicon glyphicon-phone"></i> {{ $client->phone }}</p>
                                        <button class="btn btn-success">Add Device</button>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection

@section('jsImport')
    <script src="{{ asset('js/showClient.js') }}"></script>
@endsection