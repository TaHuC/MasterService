@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col m12 s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Dashboard</span>
                    <div class="row">
                        <div class="col m6 s12" id="finalOrders">
                            <ul class="collection with-header z-depth-2">
                                <li class="collection-header indigo lighten-3">
                                    <h5 class="title">Completed orders</h5>
                                </li>
                            </ul>
                        </div>
                        <div class="col m6 s12" id="lastOrders">
                            <ul class="collection with-header z-depth-2">
                                <li class="collection-header indigo lighten-3">
                                    <h5 class="title">Last five orders</h5>
                                </li>
                            </ul>
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
