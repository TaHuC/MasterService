@extends('layouts.app')

@section('cssImport')
    <link rel="stylesheet" href="{{ asset('css/home.css')}}">
@endsection

@section('content')
    <div class="row" id="homeRow">
        
        <!-- <div class="col-12 tableCol bg-light border border-success">
            <table id="orderTable" class="table table-dark dt-responsive nowrap" style="width: 100%;">
                <thead class="">
                    <tr>
                        <th><i class="fas fa-list-ol fa-2x"></i></th>
                        <th><i class="fas fa-users fa-2x"></i> | <i class="fas fa-id-card-alt fa-2x"></i></th>
                        <th><i class="fas fa-phone-volume fa-2x"></i></th>
                        
                        <th><i class="fas fa-barcode fa-2x"></i></th>
                        {{--  <th>Problem</th>  --}}
                        <th><i class="fas fa-cogs fa-2x"></i></th>
                        {{--  <th>Price</th>  --}}
                        <th class="text-left"><i class="fas fa-exclamation-triangle fa-2x"></i></th>
                        
                    </tr>
                </thead>
                <tbody class=""></tbody>
            </table>
        </div> -->
        <div class="col-8 offset-1 tableCol bg-light border border-success">
            <table id="devicesTable" class="table table-dark dt-responsive nowrap" style="width: 100%">
            <thead class="">
                <tr>
                    <th>Клиенти</th>
                    <th>Телефон</th>
                    <th>Устройство</th>
                    <th>Сериен N</th>
                    <th>Опций</th>
                </tr>
            </thead>
            <tbody></tbody>
            </table>
        </div>
        <div class="col-1 offset-2">
        <div class="row">
        <div class="col-xs-3">
                    <div class="offer offer-primary">
                        <div class="shape">
                            <div class="shape-text">
                                Last							
                            </div>
                        </div>
                        <div class="offer-content">
                            <h2 class="lead">
                                <span class="badge badge-primary">
                                    {{ $lastOrder->id }}
                                </span>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection

@section('jsImport')
    <script src="{{ asset('js/home.js') }}"></script>
@endsection
