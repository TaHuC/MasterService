@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Dashboard</h4>
                    <div class="row">

                        <div class="col-12">
                            
                        </div>

                        <div class="col-12">
                                <table id="orderTable" class="table table-inverse">
                                    <thead class="">
                                    <tr>
                                        <th>Order</th>
                                        <th>Client / ID</th>
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
