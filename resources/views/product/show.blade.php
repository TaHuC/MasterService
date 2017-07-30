@extends('layouts.app')

@section('content')
    <div class="container" >
        <div class="row">
            <div class="col m12 s12">
                <div class="row">
                    <div class="card hoverable">
                        <div class="card-content blue accent-1 white-text">
                            <span class="card-title">{{ $brand->title }} {{ $model->title }}</span>
                            <p class="">Serial NO: {{ $product->serial }}</p>
                            <a href="#" id="newOrderShow" class="btn-floating halfway-fab waves-effect waves-light red tooltipped" data-position="top" data-delay="100" data-tooltip="New Problem"><i class="material-icons">add</i></a>
                        </div>
                        <div class="card-action blue accent-2">
                            <span class="white-text">{{ $client->name }} {{ $client->phone }}</span>
                        </div>
                    </div>
                </div>
            </div>
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
                        </table>
                    </div>
                </div>
            </div>

            <div class="col m8 s8" id="orderInfo">
                <div class="card blue">
                    <div class="card-content center-align">
                        <div class="row white-text">
                            <div class="col m3 s3">
                                <span class="card-title">Problem</span>
                            </div>
                            <div class="col m3 s3">
                                <span class="card-title">Now</span>
                            </div>
                            <div class="col m3 s3">
                                <span class="card-title">Description</span>
                            </div>
                            <div class="col m3 s3">
                                <span class="card-title">Price</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-action grey lighten-3">

                    </div>
                </div>
            </div>

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

    <!-- Modal Structure -->
    <div id="saveOrder" class="modal">
        <div class="modal-content center-align">
            <h4 class="light-green-text" style="display: none">Order Complate</h4>
            <h5 id="orderNumber" style="display: none"></h5>
        </div>
    </div>
@endsection
@section('jsImport')
    <script src="{{ asset('js/showProduct.js') }}"></script>
@endsection
