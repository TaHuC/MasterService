@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="jumbotron">
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-4">
                            <a class="" href="#">
                                <img class="media-object z- dp img-circle" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" style="width: 180px;height:180px;">
                            </a>
                        </div>
                        <div class="col-8">
                            <h1 class="align-text-bottom">
                                {{ $client->name }}
                                <a href="{{ route('client.edit', ['id' => $client->id]) }}" data-toggle="tooltip" data-placement="top" title="Редактирай" class="btn btn-outline-dark"><i class="material-icons">edit</i></a>
                            </h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 text-right">
                            <p>Email:</p>
                        </div>
                        <div class="col-10 text-left">
                            <p> {{ $client->email }} </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 text-right">
                            <p>Phone:</p>
                        </div>
                        <div class="col-10 text-left">
                            <p> {{ $client->phone }} </p>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="card text-white bg-dark mb-3">
                        <div class="card-header">Добавяне на ново устройство</div>
                        <div class="card-body">

                            <form class="">
                                <div class="form-group align-middle justify-content-between row typeCheckBox col-12" id="typeCheckBox">
                                    @foreach($types as $type)
                                        <div class="col-5 border border-primary text-center typeButton">
                                            <input type="hidden" name="type" id="{{ $type['id'] }}" value="{{ $type['id'] }}" />
                                            <h4 class="title">{{ strtoupper($type['title']) }}</h4>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-group row" id="serialDiv">
                                    <div class="col-10">
                                        <input id="serial" type="text" placeholder="Serial Number" autocomplete="off" class="form-control">
                                    </div>
                                    <div class="col-2">
                                        <button id="randomSerial" class="btn btn-outline-info btn-sm" data-toggle="tooltip" data-placement="top" title="Генерирай случаен"><i class="material-icons">loop</i></button>
                                    </div>
                                </div>
                                <div class="form-group row" id="brandModelRow">
                                    <div class="col-6" id="brandDiv">
                                        <input id="brand" type="text" autocomplete="off" placeholder="Brand" class="form-control">
                                        <div class="showDiv" id="showBrand" style="display: none"></div>
                                    </div>
                                    <div class="col-6" id="modelDiv">
                                        <input id="model" type="text" autocomplete="off" placeholder="Model" class="form-control">
                                        <div class="showDiv" id="showModel" style="display: none"></div>
                                    </div>
                                </div>
                                <div class="form-group row" id="commentRow">
                                    <div class="col-12">
                                        <textarea id="comment" class="form-control" placeholder="Write comment"></textarea>
                                    </div>
                                </div>
                                <div class="form-group float-right row">
                                    <div class="col-12">
                                        <input type="hidden" name="clientId" id="clientId" value="{{ $client->id }}">
                                        <button id="saveProduct" disabled="disabled" class="btn btn-outline-success" data-toggle="tooltip" data-placement="top" title="Запамети"><i class="material-icons">save</i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row" id="show">
                <table class="table table-inverse">
                    <thead>
                    <tr>
                        <th>Devices</th>
                        <th>Date add</th>
                        <th>Serial</th>
                        <th>Status</th>
                        <th>Options</th>
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
                                <td><a href="{{ asset('/product/'.$product['id']) }}" class="btn btn-outline-info" data-toggle="tooltip" data-placement="top" title="Отвори"><i class="large material-icons">link</i></a></td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('jsImport')
    <script src="{{ asset('js/showClient.js') }}"></script>
@endsection