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
                                        <button class="btn btn-success" data-toggle="modal" data-target="#addDevModal">Add Device</button>
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

    <div class="modal fade" tabindex="-1" id="addDevModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Device</h4>
                </div>
                <div class="modal-body" id="productModalDiv">
                    <div id="formDiv">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('client.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('serial') ? ' has-error' : '' }}">
                            <label for="serial" class="col-md-4 control-label">Serial</label>
                            <div class="col-md-6 input-group">
                                <input id="serial" type="text" autocomplete="off" class="form-control" name="serial" value="{{ old('serial') }}" required>
                                <span class="input-group-btn">
                                    <button class="btn btn-success" id="setSerial" type="button">Set</button>
                                </span>
                                @if ($errors->has('serial'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('serial') }}</strong>
                                    </span>
                                @else
                                    <span id="showSerial" class="help-block"></span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group text-center" id="typeDiv">
                            <div class="btn-group" data-toggle="buttons" id="typeDivRadio">
                                @foreach($types as $type)
                                    <label class="btn btn-primary">
                                        <input type="radio" name="type" id="type" value="{{ $type->id }}"> {{ $type->title }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('brand') ? ' has-error' : '' }}" id="brandDiv">
                            <label for="brand" class="col-md-4 control-label">Brand</label>

                            <div class="col-md-6" id="brandInputDiv">
                                <input id="brand" type="brand" autocomplete="off" class="form-control" name="brand" value="{{ old('brand') }}" required>

                                @if ($errors->has('brand'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('brand') }}</strong>
                                    </span>
                                @else
                                    <span id="showBrand" class="help-block"></span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('model') ? ' has-error' : '' }}" id="modelDiv">
                            <label for="model" class="col-md-4 control-label">Model</label>

                            <div class="col-md-6" id="modelInputDiv">
                                <input id="model" type="text" autocomplete="off" class="form-control" name="model" value="{{ old('model') }}" required>

                                @if ($errors->has('model'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('model') }}</strong>
                                    </span>
                                @else
                                    <span id="showModel" class="help-block"></span>
                                @endif
                            </div>
                        </div>

                        <div id="orderDiv">
                            <div class="form-group{{ $errors->has('now') ? ' has-error' : '' }}">
                                <label for="model" class="col-md-4 control-label">Now</label>

                                <div class="col-md-6">
                                    <input id="now" type="text" autocomplete="off" class="form-control" name="now" value="{{ old('now') }}" required>

                                    @if ($errors->has('now'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('now') }}</strong>
                                        </span>
                                    @else
                                        <span id="showSerial" class="help-block"></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="text" autocomplete="off" class="form-control" name="password" value="{{ old('password') }}">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('problem') ? ' has-error' : '' }}">
                                <label for="problem" class="col-md-4 control-label">Problem</label>

                                <div class="col-md-6">
                                    <input id="problem" type="text" autocomplete="off" class="form-control" name="problem" value="{{ old('problem') }}" required>

                                    @if ($errors->has('problem'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('problem') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="col-md-4 control-label">Description</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="description" id="description">{{ old('description') }}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                <label for="price" class="col-md-4 control-label">Price</label>
                                <div class="col-md-6">
                                    <input type="text" autocomplete="off" class="form-control" name="price" id="price" value="{{ old('price') }}">
                                    @if ($errors->has('price'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('price') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="window.location.reload()" data-dismiss="modal">Close</button>
                    <button type="button" id="addProductButton" onclick="addPrandOrder('{{$client->id}}')" class="btn btn-primary">Save</button>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('jsImport')
    <script src="{{ asset('js/showClient.js') }}"></script>
    <script>
        var token = $('input[name=_token]').val();

        function addNewBrand() {
            var getTypeId = $('#type').val();
            var getBrand = $('#brand').val();
            $.post('{{ asset('brand/') }}', {_token: token, type: getTypeId, brand: getBrand}, function (data) {
                $('#brand').val(data.id).hide();
                $('#brandInputDiv').append("<input class='form-control' type='text' value='"+data.title+"' disabled>");
                $('#showBrand').hide();
                $('#modelDiv').fadeIn('slow');
            });
        }

        function addNewModel() {
            var getBrandId = $('#brand').val();
            var getModel = $('#model').val();
            $.post('{{ asset('model/') }}', {_token: token, brand: getBrandId, model: getModel}, function (data) {
                $('#model').val(data.id).hide();
                $('#modelInputDiv').append("<input class='form-control' type='text' value='"+data.title+"' disabled>");
                $('#showModel').hide();
                $('#orderDiv').fadeIn('slow');
            });
        }

        function selectBrand(id, brand) {
            $('#brand').val(id).hide();
            $('#brandInputDiv').append("<input class='form-control' type='text' value='"+brand+"' disabled>");
            $('#showBrand').hide();
            $('#modelDiv').fadeIn('slow');
        }

        function selectModel(id, model) {
            $('#model').val(id).hide();
            $('#modelInputDiv').append("<input class='form-control' type='text' value='"+model+"' disabled>");
            $('#showModel').hide();
            $('#orderDiv').fadeIn('slow');
        }

        function addPrandOrder(id) {
            var serial = $('#serial').val();
            var type = $('#type').val();
            var brand = $('#brand').val();
            var model = $('#model').val();
            var now = $('#now').val();
            var password = $('#password').val();
            var problem = $('#problem').val();
            var description = $('#description').val();
            var price = $('#price').val();
            var client = id;
            var _token = $('input[name=_token]').val();

            if(serial != '' && type != '' && brand != '' && model != '' && now != '' && problem != '' && client != '') {
                $.post('../product/', {
                    _token: _token,
                    serial: serial,
                    type: type,
                    brand: brand,
                    model: model,
                    now: now,
                    password: password,
                    problem: problem,
                    description: description,
                    price: price,
                    client: client
                },
                    function (data) {
                    $('#formDiv').fadeOut('slow');
                    $('#addProductButton').fadeOut('slow');
                    $('#productModalDiv').addClass('text-center');
                    $('#productModalDiv').html(
                        "<h3>Order: "+data+"</h3>"
                    );
                });
            }
        }
    </script>
@endsection