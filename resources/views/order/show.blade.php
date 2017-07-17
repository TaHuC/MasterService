@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col m12">
                <div class="card horizontal blue-grey-text brown lighten-5">
                    <div class="card-stacked">
                        <div class="card-content">
                            <span class="card-title">{{ $order['brand'] }} {{  $order['model'] }}
                                <a href="{{ route('client.show', $order['clientId']) }}" class="btn-flat waves-effect waves-light">
                                <i class="material-icons">launch</i>
                            </a>
                        </span>
                            <p class="text-uppercase text-danger"><strong>N: </strong>{{ $order['serial'] }} </p>
                            <p><strong>Pass: </strong>{{ $order['password'] }}</p>
                            <p class="table-bordered"></p>
                            <p><strong>Now: </strong> {{ $order['now'] }}</p>
                            <p><strong>Problem: </strong>{{ $order['problem'] }}</p>
                            <p><strong>Desc: </strong>{{ $order['description'] }}</p>
                        </div>
                    </div>
                    <div class="card-panel" id="order-client-info">
                        <ul class="">
                            <li>
                                <strong>{{ $order['client'] }} </strong>
                                <a href="{{ route('client.show', $order['clientId']) }}" class="btn-flat waves-effect waves-light">
                                    <i class="material-icons">launch</i>
                                </a>
                            </li>
                            <li>
                                <i class="tiny material-icons">contact_phone</i> {{ $order['clientPhone'] }}
                            </li>
                            <li>
                                <i class="tiny material-icons">message</i> {{ $order['clientEmail'] }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col m8">

            </div>
        </div>
    </div>
@endsection

@section('jsImport')

@endsection