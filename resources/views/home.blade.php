@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Dashboard</h4>
                    <div class="row">
                        <div class="col-6" id="finalOrders">
                            <div class="card">
                                <div class="card-header" role="tab" id="headingOne">
                                    <h5 class="mb-0">
                                        <a data-toggle="collapse" href="#collapseComp" aria-expanded="true" aria-controls="collapseComp">
                                            Completed orders
                                        </a>
                                    </h5>
                                </div>

                                <div id="collapseComp" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <ul class="collection with-header z-depth-2" id="completedOrders"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6" id="lastOrders">
                            <div class="card">
                                <div class="card-header" role="tab" id="headingOne">
                                    <h5 class="mb-0">
                                        <a data-toggle="collapse" href="#collapseLast" aria-expanded="true" aria-controls="collapseLast">
                                            Last five orders
                                        </a>
                                    </h5>
                                </div>

                                <div id="collapseLast" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <ul class="collection with-header z-depth-2" id="lastOrder"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                                <table id="orderTable" class="table table-inverse">
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
                                    <tbody class="">
                                    </tbody>
                                </table>
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
