@extends('layouts.app')

@section('cssImport')
<link rel="stylesheet" href="{{ asset('css/showClient.css') }}">
@endsection

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
                        <div class="col-1">
                            <i class="material-icons">email</i>
                        </div>
                        <div class="col-11">
                            <p class=""> {{ $client->email }} </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-1">
                            <i class="material-icons">phone</i>
                        </div>
                        <div class="col-11">
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

                                        <div class="col-12" style="display: none" id="showDevice">
                                           <div class="card text-white border-danger bg-dark mb-3" style="max-width: 18rem;">
                                                <div class="card-header" id="showClientDivHeader"></div>
                                                <div class="card-body">
                                                    <p class="card-text">Това устройство е налично на профила на <b id="clientName"></b> </p>
                                                    <a href="#" class="card-link" id="setNewOwner" >Премести</a>
                                                    <input type="hidden" name="ownerId" id="ownerId" value="{{ $client->id }}">
                                                    <a href="#" class="card-link" id="openClientLink" >Отвори</a>
                                                </div>
                                            </div>
                                        </div>

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
            <div class="row" id="show">
                <div class="card bg-dark text-white border border-primary" style="width: 100%;">
                    <div class="card-header">
                        <h3>Device List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table bg-dark table-inverse">
                    <thead>
                    <tr>
                        <th><i class="material-icons">devices</i></th>
                        <th><i class="material-icons">fingerprint</i></th>
                        <th><i class="material-icons">update</i></th>
                        <th><i class="material-icons">new_releases</i></th>
                        <th><i class="material-icons">widgets</i></th>
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
        </div>
@endsection

@section('jsImport')
    <script src="{{ asset('js/showClient.js') }}"></script>
@endsection