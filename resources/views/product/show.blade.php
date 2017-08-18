@extends('layouts.app')

@section('content')
    <div class="container" >
        <div class="row">
            <div class="col m12 s12">
                <div class="row">
                    <div class="card hoverable">
                        <div class="card-content blue accent-1 white-text">
                            <div class="row">
                                <div class="col m4 s4">
                                    <span class="card-title">{{ $brand->title }} {{ $model->title }}</span>
                                    <p class="">Serial NO: {{ $product->serial }}</p>
                                    <a href="#" id="newOrderShow" class="btn-floating halfway-fab waves-effect waves-light red tooltipped" data-position="top" data-delay="100" data-tooltip="New Problem"><i class="material-icons">add</i></a>
                                </div>
                                @if(count($orders) > 0)
                                    <div class="col m8 s8 green z-depth-1" id="orderDetails">
                                        <h5># {{ $orders[0]->id }}</h5>
                                        <table>
                                            <thead>
                                            <td>Now</td>
                                            <td>Password</td>
                                            <td>Problem</td>
                                            <td>Description</td>
                                            <td>Price</td>
                                            <td>Actions</td>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>{{$orders[0]->now}}</td>
                                                <td>{{$orders[0]->password}}</td>
                                                <td>{{$orders[0]->problem}}</td>
                                                <td>{{$orders[0]->description}}</td>
                                                <td class="left">
                                                    <p>Price:<span class="right">{{$orders[0]->price}}</span></p>
                                                    <p>Deposit:<span class="right">{{$orders[0]->deposit}}</span></p>
                                                    <p>Remaing:<span class="right">{{$orders[0]->price - $orders[0]->deposit}}</span></p>
                                                </td>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-action blue accent-2">
                            <span class="white-text">{{ $client->name }} {{ $client->phone }}</span>
                        </div>
                    </div>
                </div>

                @if(count($orders) > 0)

                @endif
            </div>
        </div>

        <div class="row">
            <div class="col m4 s4 z-depth-3">
                <div class="row">
                    <div class="col m12 s12">
                        <h5 class="">All Orders</h5>
                        <table id="orderTable">
                            <thead>
                            <tr>
                                <th>Order</th>
                                <th>Data</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            @if(count($orders) > 0)
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order['created_at'] }}</td>
                                    <td data-status="{{$order->statusId}}">
                                        @foreach($statuses as $status)
                                            @if($order->statusId === $status->id)
                                                {{ $status->status }}
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

            @if(count($orders) > 0)
            <div class="col m7 s7 z-depth-3 right" id="repairForm">
                <h4>Repair</h4>
                <div class="row">
                    <form class="col m12 s12" id="repairForm">
                        <div class="row">
                            <div class="input-field col m12 s12">
                                <input id="repair" name="repair" value="" type="text">
                                <label for="repair">Repair</label>
                            </div>
                            <div class="input-field col m12 s12">
                                <textarea id="description" class="materialize-textarea"></textarea>
                                <label for="description">Description</label>
                            </div>
                            <div class="input-field col m12 s12">
                                <input id="price" name="price" value="{{$orders[0]->price}}" type="text">
                                <label for="price">Repair</label>
                            </div>
                            <div class="input-field col m12 s12 right-align">
                                <button id="saveRepair" class="btn waves-effect waves-light blue"><i class="material-icons">save</i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <div class="col m8 s8 z-depth-3" id="formOrder">
                    <div class="col m12 s12">
                        <h5>New Problem</h5>
                        <div class="row">
                            <div class="input-field col m12">
                                <input type="text" class="" name="problem" id="problem">
                                <label for="problem">Problem</label>
                            </div>
                            <div class="input-field col m6">
                                <input type="text" class="" name="now" id="now">
                                <label for="now">Now</label>
                            </div>
                            <div class="input-field col m6">
                                <input type="text" class="" name="password" id="password">
                                <label for="password">Password Device</label>
                            </div>
                            <div class="input-field col m12">
                                <textarea class="materialize-textarea" name="description" id="description"></textarea>
                                <label for="description">Description</label>
                            </div>
                            <div class="input-field col m12">
                                <input name="price" type="text" id="price">
                                <label for="price">Price</label>
                            </div>
                            <div class="input-field col m12">
                                <input name="deposit" type="text" id="deposit">
                                <label for="deposit">Deposit</label>
                            </div>
                            <div class="input-field col m12 right-align">
                                <input type="hidden" id="productId" value="{{ $product->id }}">
                                <button class="btn halfway-fab waves-effect blue" id="saveNewProblem"><i class="material-icons">save</i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('jsImport')
    <script src="{{ asset('js/showProduct.js') }}"></script>
@endsection
