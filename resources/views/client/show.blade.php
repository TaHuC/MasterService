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
                                        <p><i class="glyphicon glyphicon-phone"></i> {{ $client->phone }}</p>
                                        <a href="#addDevModal" class="waves-effect waves-light btn">Add Device</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
                <div class="row">
                    @if($finalProducts != null)
                        @foreach($finalProducts as $product)
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">{{ $product['brand'] }} {{ $product['model'] }}</h3>
                                            <div class="col-md-6 col-xs-6">Order: {{ $product['orderId'] }}</div>
                                            <div class="col-md-6 col-xs-6 text-right"><p class="">{{ $product['serial'] }}</p></div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="panel-body text-left">
                                            <h3>
                                                {{ $product['status'] }}
                                            <a href="{{ route('order.show', $product['orderId']) }}" class="btn btn-success pull-right">Open</a>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

    <div class="modal" id="addDevModal">
        <div class="modal-content">
            <div class="row">
                <form class="col s12">
                    <div class="row" >
                        <div class="checkbox-inline col s12" id="typeCheckBox">
                            @foreach($types as $type)
                                <div class="col s2 z-depth-2">
                                    <input type="radio" name="type" id="{{ $type['id'] }}" value="{{ $type['id'] }}" />
                                    <label for="{{ $type['id'] }}">{{ $type['title'] }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix" id="genetareSerial">textsms</i>
                            <input id="serial" type="text" class="autocomplate">
                            <label for="serial" id="showSerial">Serial Number</label>
                            <i class="test"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="brand" type="text" class="validate">
                            <label for="serial">Input Brand</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="model" type="text" class="validate">
                            <label for="model">Input Model</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="comment" class="materialize-textarea"></textarea>
                            <label for="comment">Write comment</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
        </div>
    </div>
@endsection

@section('jsImport')
    <script src="{{ asset('js/showClient.js') }}"></script>
@endsection