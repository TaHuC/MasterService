@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card hoverable">
                    <div class="card-content blue accent-1 white-text text-left">
                        <div class="row">
                            <div class="col m4 s4 text-center">
                                <a class="" href="#">
                                    <img class="media-object z- dp img-circle" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" style="width: 180px;height:180px;">
                                </a>
                            </div>
                            <div class="col-m8 s8">
                                <h2>{{ $client->name }} <a href="{{ route('client.edit', ['id' => $client->id]) }}" class="btn halfway-fab waves-effect waves-light red tooltipped" data-position="top" data-delay="100" data-tooltip="Edit Profile"><i class="material-icons">edit</i></a></h2>
                                <p>
                                <h4><i class="glyphicon glyphicon-envelope"></i> {{ $client->email }}</h4>
                                <h4><i class="glyphicon glyphicon-phone"></i> {{ $client->phone }}</h4>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-action blue-grey lighten-2">
                        <div class="row" id="show">
                            <table class="highlight">
                                <thead>
                                    <tr>
                                        <th>Devices</th>
                                        <th>Date add</th>
                                        <th>Serial</th>
                                        <th>Status</th>
                                        <th><a href="#addDevModal" class="btn halfway-fab waves-effect waves-light red tooltipped" data-position="top" data-delay="100" data-tooltip="Add new Device"><i class="material-icons">add</i></a></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($finalProducts) > 0)
                                    @foreach ($finalProducts as $product)
                                        <tr>
                                            <td>{{ $product['brand'] }} {{ $product['model'] }}</td>
                                            <td>{{ $product['serial'] }}</td>
                                            <td>{{ $product['created_at'] }}</td>
                                            <td>{{ $product['status'] }}</td>
                                            <td><a href="{{ asset('/product/'.$product['id']) }}" class="btn wave-effect tooltipped lime accent-3 amber-text" data-position="top" data-delay="100" data-tooltip="Open Device"><i class="large material-icons">link</i></a></td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-fixed-footer" id="addDevModal">
        <div class="modal-content">
            <div class="row">
                <form class="col m12 s12">
                    <div class="row">
                        <div class="col s12 typeCheckBox" id="typeCheckBox">
                            @foreach($types as $type)
                                <div class="col s5 hoverable waves-block waves-green waves-effect z-depth-2 center typeButton">
                                    <input type="hidden" name="type" id="{{ $type['id'] }}" value="{{ $type['id'] }}" />
                                    <h4 class="">{{ $type['title'] }}</h4>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row" id="serialDiv">
                        <div class="input-field col s12">
                            <i class="material-icons prefix" id="genetareSerial">textsms</i>
                            <input id="serial" type="text" autocomplete="off" class="autocomplate">
                            <label for="serial" id="showSerial">Serial Number</label>
                            <i class="test"></i>
                        </div>
                    </div>
                    <div class="row" id="brandModelRow">
                        <div class="input-field col s6" id="brandDiv">
                            <input id="brand" type="text" autocomplete="off" class="validate">
                            <label for="brand">Input Brand</label>
                            <div class="showDiv" id="showBrand" style="display: none"></div>
                        </div>
                        <div class="input-field col s6" id="modelDiv"   >
                            <input id="model" type="text" autocomplete="off" class="validate">
                            <label for="model">Input Model</label>
                            <div class="showDiv" id="showModel" style="display: none"></div>
                        </div>
                    </div>
                    <div class="row" id="commentRow">
                        <div class="input-field col s12">
                            <textarea id="comment" class="materialize-textarea"></textarea>
                            <label for="comment">Write comment</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="clientId" id="clientId" value="{{ $client->id }}">
            <button id="saveProduct" disabled="disabled" class="modal-action modal-close waves-effect waves-green btn-flat">Save</button>
        </div>
    </div>
@endsection

@section('jsImport')
    <script src="{{ asset('js/showClient.js') }}"></script>
@endsection