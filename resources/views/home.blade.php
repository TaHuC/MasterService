@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col m12 s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title white-text">Dashboard</span>
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
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <table id="orderTable" class="white-text">
                        <thead class="">
                        <tr>
                            <th>Order</th>
                            <th>Client</th>
                            <th>Phone</th>
                            <th>Serial</th>
                            <th>Status</th>
                            <th>Problem</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody class="black-text">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('jsImport')
    <script src="{{ asset('js/home.js') }}"></script>
@endsection
