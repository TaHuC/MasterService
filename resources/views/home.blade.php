@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col m12 s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title white-text">Dashboard</span>
                    <div class="row">
                        <div class="col m6 s12" id="finalOrders">
                            <ul class="collapsible" data-collapsible="accordion">
                                <li>
                                    <div class="collapsible-header"><i class="material-icons">reorder</i>Completed orders</div>
                                    <div class="collapsible-body">
                                        <ul class="collection with-header z-depth-2" id="completedOrders"></ul>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="col m6 s12" id="lastOrders">
                            <ul class="collapsible" data-collapsible="accordion">
                                <li>
                                    <div class="collapsible-header"><i class="material-icons">reorder</i>Last five orders</div>
                                    <div class="collapsible-body">
                                        <ul class="collection with-header z-depth-2" id="lastOrder"></ul>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="com s12 ">
                            <table id="orderTable" class="white-text grey highlight responsive-table">
                                <thead class="">
                                <tr>
                                    <th>Order</th>
                                    <th>Client</th>
                                    <th>Phone</th>
                                    <th>Serial</th>
                                    <th>Problem</th>
                                    <th>Status</th>
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
        </div>
    </div>
@endsection

@section('jsImport')
    <script src="{{ asset('js/home.js') }}"></script>
@endsection
