@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="jumbotron">
            <div class="row">
                <div class="col-6">
                    <h4 class="title">{{ $product->brand->title }} {{ $product->model->title }}
                            @if(count($product->orders) != 0)
                                <span class="badge badge-primary"> {{ $product->orders->last()->status->status }}</span>
                            @endif
                        </h4>
                    <p class="text-secondary"><i class="material-icons">fingerprint</i>  {{ $product->serial }}</p>
                    <hr>
                    <h5><i class="material-icons">comment</i> <small>{{ $product->comment }}</small></h5>
                    <hr>
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">{{ $product->client->name }}</strong>
                            <a class="btn btn-outline-dark float-right" data-toggle="tooltip" data-placement="top" title="Отвори" href="{{ asset('/client/'.$product->client->id) }}"><i class="material-icons">link</i></a>
                        </div>
                        <div class="card-body">
                            <p><i class="material-icons">phone</i> {{ $product->client->phone }}</p>
                            <p><i class="material-icons text">email</i> {{ $product->client->email }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 bg-dark mb-3 text-white">
                    @if(count($product->orders) === 0 || $product->orders->last()->statusId === 4)
                        <form class="" method="post" action="{{ route('order.store') }}" id="orderForm" novalidate>
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label for="problem">Проблем</label>
                                    <input type="text" class="form-control" autocomplete="off" name="problem" id="problem" placeholder="Проблем..." required>
                                </div>
                                <div class="col-6 form-group">
                                    <label for="Now">Състояние</label>
                                    <input type="text" class="form-control" autocomplete="off" name="now" id="now" placeholder="Състояние..." required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label for="password">Парола</label>
                                    <input type="text" name="password" class="form-control" autocomplete="off" id="password" placeholder="password...">
                                </div>
                                <div class="col-6 form-group">
                                    <label for="description">Информация</label>
                                    <textarea class="form-control" id="description" autocomplete="off" name="description"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 input-group">
                                    <label for="price">Цена</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control text-right" autocomplete="off" name="price" id="price" placeholder="20..." value="0">
                                        <div class="input-group-addon">
                                            <span class="input-group-text">лв.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 input-group">
                                    <label for="deposit">Депосит</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control text-right" id="deposit" autocomplete="off" name="deposit" placeholder="10..." value="0">
                                        <div class="input-group-addon">лв.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 form-group text-right">
                                <input type="hidden" name="productId" value="{{ $product->id }}">
                                <button class="btn btn-outline-primary" type="submit" data-toggle="tooltip" data-placement="top" title="Запамети"><i class="material-icons">done</i></button>
                            </div>
                        </form>
                    @else
                        @if($product->orders->last()->statusId === 3)

                            <div class="row d-flex justify-content-center" style="height: 100%;">
                                <h4 class="text-center">Тази поръчка е пруключена!</h4>
                            </div>

                        @elseif($product->orders->last()->statusId > 0)
                            <form class="" id="repairForm" method="post" action="{{ route('repair.store') }}">
                                {{ csrf_field() }}
                                <div class="col-12 form-group">
                                    <label for="repair">Ремонт</label>
                                    <input type="text" class="form-control" autocomplete="off" name="repair" id="repair" placeholder="Ремонт..." required>
                                </div>
                                <div class="col-12 form-group">
                                    <label for="description">Информация</label>
                                    <textarea class="form-control" autocomplete="off" name="description" id="description"></textarea>
                                </div>
                                <div class="col-12 form-group">
                                    <label for="price">Цена</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control text-right" autocomplete="off" name="price" id="price" placeholder="20..." value="{{ $product->orders[count($product->orders) - 1]->price }}">
                                        <div class="input-group-addon">лв.</div>
                                    </div>
                                </div>
                                <div class="form-group col-12 text-right">
                                    <input type="hidden" name="orderId" value="{{ $product->orders->last()->id }}">
                                    <input type="hidden" name="productId" value="{{ $product->id }}">
                                    <button class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Запамети" type="submit"><i class="material-icons">done</i></button>
                                </div>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row border border-info">
                <div class="col-1 text-center bg-light" id="orderColBtn">
                    <div class="nav flex-column-reverse nav-pills" id="repairTab" role="tablist">
                        @if(count($product->orders) != 0)
                            @foreach($product->orders as $order)
                                @if($order->id === $product->orders->last()->id)
                                    <a href="#{{$order->id}}" aria-expanded="true" data-toggle="pill" role="tab" aria-controls="{{ $order->id }}" class="nav-link active">#{{ $order->id }}</a>
                                @else
                                    <a href="#{{$order->id}}" aria-expanded="true" data-toggle="pill" role="tab" aria-controls="{{ $order->id }}" class="nav-link">#{{ $order->id }}</a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-11 bg-white">
                    @if(count($product->orders) != 0)
                        <div class="tab-content" id="repairTabContent">
                            @foreach($product->orders as $order)
                                @if($order->id === $product->orders->last()->id)
                                    <div class="tab-pane fade show active" id="{{ $order->id }}" role="tabpanel" aria-labelledby="">
                                        <div class="row">
                                            <div class="card bg-dark" style="width: 100%;">
                                                <table class="table table-inverse">
                                            <thead>
                                            <tr>
                                                <th>{{ $order->problem }}</th>
                                                <th>{{ $order->now }}</th>
                                                <th>{{ $order->password }}</th>
                                                <th>{{ $order->description }}</th>
                                                <th class="float-right">
                                                    <table class="table-inverse">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-right">{{ $order->deposit }} lv.</th>
                                                            <th class="text-right">{{ $order->price }} lv.</th>
                                                            <th class="text-right">{{ $order->price - $order->deposit }} lv.</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>Депосит</td>
                                                            <td>Цена</td>
                                                            <td>Всичко</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="text-center">Проблем</td>
                                                <td class="text-center">Състояние</td>
                                                <td class="text-center">Парола</td>
                                                <td class="text-center">Информация</td>
                                                <td class="">
                                                    <div class="col-4 text-right float-right">
                                                        <i class="material-icons text-right" data-toggle="tooltip" data-placement="top" title="Поръчката е приета от: {{ $order->user->name }}">face</i>
                                                        <i class="material-icons text-right" data-toggle="tooltip" data-placement="top" data-html="true" title="Поръчката е приета на: <b>{{ $order->created_at }}</b> <br> Последно редактирана на: <b>{{ $order->updated_at }}</b>">access_time</i>
                                                    </div>
                                                    <div class="row col-8 float-right">


                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title float-left"><i class="material-icons">build</i> Ремонти</h5>
                                                        <span class="float-right">
                                                            @if($order->statusId < 2)
                                                                <form action="{{ route('order.changeStatus') }}" method="post" class="col-3">
                                                                {{ csrf_field() }}
                                                                    <input type="hidden" name="orderId" value="{{ $order->id }}">
                                                                <input type="hidden" name="productId" value="{{ $product->id }}">
                                                                <input type="hidden" name="status" value="5">
                                                                <button type="submit" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="За части"><i class="material-icons">extension</i></button>
                                                            </form>
                                                            @endif

                                                            @if($order->statusId === 2 || $order->statusId === 5)
                                                                <form action="{{ route('order.changeStatus') }}" method="post" class="col-4">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="orderId" value="{{ $order->id }}">
                                                                <input type="hidden" name="productId" value="{{ $product->id }}">
                                                                <input type="hidden" name="status" value="3">
                                                                <button type="submit" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Приключи"><i class="material-icons">done</i></button>
                                                            </form>
                                                            @endif

                                                            @if($order->statusId === 3)
                                                                <form action="{{ route('order.changeStatus') }}" method="post" class="col-3">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="orderId" value="{{ $order->id }}">
                                                                <input type="hidden" name="productId" value="{{ $product->id }}">
                                                                <input type="hidden" name="status" value="4">
                                                                <button type="submit" class="btn btn-sm btn-info"><i class="material-icons" data-toggle="tooltip" data-placement="top" title="Взета">exit_to_app</i></button>
                                                            </form>
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-group">
                                                            @foreach($product->repairs as $repair)
                                                                @if($repair->orderId === $order->id)
                                                                    <li class="list-group-item list-group-item-info ">
                                                                        <div class="d-flex w-100 justify-content-between">
                                                                            <h5 class="mb-1">{{ $repair->repair }}</h5>
                                                                            <small>{{ $repair->created_at }}</small>
                                                                        </div>
                                                                        <p class="mb-1">{{ $repair->description }}</p>
                                                                        <small>{{ $repair->user->name }}</small>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                                <h5 class="card-title float-left"><i class="material-icons">note</i> Забележки</h5>
                                                            @if($order->statusId !== 4)
                                                                        <button id="noteAddBtn" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#noteModal"><i class="material-icons">note_add</i></button>
                                                            @endif
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-group notesList" data-orderId="{{ $order->id }}"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="tab-pane fade" id="{{ $order->id }}" role="tabpanel" aria-labelledby="">
                                        <div class="row">
                                            <div class="card bg-dark" style="width: 100%;">
                                                <table class="table table-inverse">
                                            <thead>
                                            <tr>
                                                <th>{{ $order->problem }}</th>
                                                <th>{{ $order->now }}</th>
                                                <th>{{ $order->password }}</th>
                                                <th>{{ $order->created_at }}</th>
                                                <th>{{ $order->description }}</th>
                                                <th class="float-right">
                                                    <table class="table-inverse">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-right">{{ $order->deposit }} lv.</th>
                                                            <th class="text-right">{{ $order->price }} lv.</th>
                                                            <th class="text-right">{{ $order->price - $order->deposit }} lv.</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>Депосит</td>
                                                            <td>Цена</td>
                                                            <td>Всичко</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="text-center">Проблем</td>
                                                <td class="text-center">Състояние</td>
                                                <td class="text-center">Парола</td>
                                                <td class="text-center">Приета</td>
                                                <td class="text-center">Информация</td>
                                                <td class="text-center">{{ $order->user->name }} | <small>{{ $order->updated_at }}</small></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title"><i class="material-icons">build</i> Ремонти</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-group">
                                                            @foreach($product->repairs as $repair)
                                                                @if($repair->orderId === $order->id)
                                                                    <li class="list-group-item list-group-item-info ">
                                                                        <div class="d-flex w-100 justify-content-between">
                                                                            <h5 class="mb-1">{{ $repair->repair }}</h5>
                                                                            <small>{{ $repair->created_at }}</small>
                                                                        </div>
                                                                        <p class="mb-1">{{ $repair->description }}</p>
                                                                        <small>{{ $repair->user->name }}</small>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title"><i class="material-icons">note</i> Забележки</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-group notesList" data-orderId="{{ $order->id }}">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                       <h3 class="title text-center">Няма Ремонти</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(count($product->orders) != 0)
        <!-- Modal NOTE ORDER -->
        <div class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="noteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="noteModalLabel">Бележка</h5>
                        <button type="button" class="close" data-toggle="tooltip" data-placement="top" title="Затвори" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('notes.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <textarea name="note" class="form-control" id="" cols="30" rows="10" required></textarea>
                            <input type="hidden" name="orderId" value="{{ $order->id }}">
                            <input type="hidden" name="productId" value="{{ $product->id }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" data-toggle="tooltip" data-placement="top" title="Затвори"><i class="material-icons">close</i></button>
                            <button type="submit" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Запамети"><i class="material-icons">save</i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('jsImport')
    <script src="{{ asset('js/showProduct.js') }}"></script>
@endsection