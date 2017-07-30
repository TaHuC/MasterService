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
    </div>

    <div class="modal modal-fixed-footer" id="addDevModal">
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
                    <div class="row" id="serialDiv">
                        <div class="input-field col s12">
                            <i class="material-icons prefix" id="genetareSerial">textsms</i>
                            <input id="serial" type="text" class="autocomplate">
                            <label for="serial" id="showSerial">Serial Number</label>
                            <i class="test"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6" id="brandDiv">
                            <input id="brand" type="text" class="validate">
                            <label for="brand">Input Brand</label>
                            <div class="showDiv" id="showBrand" style="display: none"></div>
                        </div>
                        <div class="input-field col s6" id="modelDiv"   >
                            <input id="model" type="text" class="validate">
                            <label for="model">Input Model</label>
                            <div class="showDiv" id="showModel" style="display: none"></div>
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
            <input type="hidden" name="clientId" id="clientId" value="{{ $client->id }}">
            <button id="saveProduct" disabled="disabled" class="modal-action modal-close waves-effect waves-green btn-flat">Save</button>
        </div>
    </div>
@endsection

@section('jsImport')
    <script>
        let brandId = 0;

        function getBrand(text, id) {
            $('#brand').val(text);
            $('#brand').attr('disabled', 'disabled');
            $('#showBrand').fadeOut('slow');
            $('#modelDiv').fadeIn('slow');
            $('#model').focus();

            brandId = id;

            return brandId;
        }

        $('#model').keyup(() => {
            let getModel = $('#model').val();
            let showModelDiv = $('#showModel');

            if(getModel.length >= 1){
                $.get('/model/select/'+getModel + '/' + brandId, function (data) {
                    if(!showModelDiv.is(':visible')) {
                        showModelDiv.fadeIn('slow');
                    }
                    if(data.length !== 0) {
                        for (let resultB of data) {
                        showModelDiv.html(`<p onclick="getModel('${resultB.title}')">${resultB.title}</p>`);
                        }
                    } else {
                        showModelDiv.html('');
                        showModelDiv.fadeOut('slow');
                        let setTime = setTimeout(function () {
                            $('#model').attr('disabled', 'disabled');
                            $('#saveProduct').removeAttr('disabled');
                            $('#comment').focus();
                        }, 2000);
                        $('#model').keyup(() => {
                            clearTimeout(setTime);
                        });
                    }
                });
            } else {
                showModelDiv.html('');
                showModelDiv.fadeOut('slow');
            }
        });

        function getModel(text) {
            $('#model').val(text);
            $('#model').attr('disabled', 'disabled');
            $('#showModel').fadeOut('slow');
            $('#comment').focus();
            $('#saveProduct').removeAttr('disabled');
        }
    </script>
    <script src="{{ asset('js/showClient.js') }}"></script>
@endsection