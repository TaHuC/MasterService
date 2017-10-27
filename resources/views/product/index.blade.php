@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h2 class="title text-white">Devices</h2>
                <div class="form-group text-right">
                    <label for="filter" class="col-1 text-white">Filter:</label>
                    <input class="form-control col-2 float-right" id="filter" name="filter">
                </div>
                <table class="table table-inverse" id="devicesTable">
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>Device</th>
                        <th>Serial</th>
                        <th>Comment</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->type->title }}</td>
                            <td>{{ $product->brand->title }} {{ $product->model->title }}</td>
                            <td>{{ $product->serial }}</td>
                            <td>{{ $product->comment }}</td>
                            <td><a class="btn btn-outline-info" href="product/{{ $product->id }}">Open</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
@endsection

@section('jsImport')
    <script type="text/javascript" src="{{ asset('js/filters.js') }}"></script>
@endsection