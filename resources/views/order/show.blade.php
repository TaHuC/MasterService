@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Order Details</div>
                        <div class="panel-body text-left">
                            <div class="row">
                                <div class="col-md-2 col-xs-4" style="border-right: 1px solid black">
                                    <h3 class="panel-title">{{ $order['client'] }}</h3>
                                    <p></p>
                                    <p><i class="glyphicon-headphones"></i> {{ $order['clientPhone'] }}</p>
                                    <p><i class="glyphicon-send"></i> {{ $order['clientEmail'] }}</p>
                                    <p class="text-right">
                                        <a href="{{ route('client.show', $order['clientId']) }}" class="btn btn-link btn-xs">Open</a>
                                    </p>
                                </div>
                                <div class="col-md-10 col-xs-8">
                                    <h3 class="panel-title">{{ $order['brand'] }} {{  $order['model'] }} <small class="text-uppercase text-danger"><strong>N: </strong>{{ $order['serial'] }} <strong>| Pass: </strong>{{ $order['password'] }}</small></h3>
                                    <p class="table-bordered"></p>
                                        <p><strong>Now: </strong> {{ $order['now'] }}</p>
                                        <p><strong>Problem: </strong>{{ $order['problem'] }}</p>
                                        <p><strong>Desc: </strong>{{ $order['description'] }}</p>
                                    <p>
                                        <button class="btn btn-xs btn-warning">Repair</button>
                                        <button class="btn btn-xs btn-danger">Close</button>
                                    </p>
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

@endsection