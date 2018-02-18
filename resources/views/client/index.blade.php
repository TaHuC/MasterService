@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h2 class="title text-white">Clients</h2>
                <div class="form-group text-right">
                    <label for="filter" class="col-1 text-white">Filter:</label>
                    <input class="form-control col-2 float-right" id="filter" name="filter">
                </div>
                <table class="table table-inverse" id="clientsTable">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>ID</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($clients as $client)
                        <tr>
                            <td>{{ $client->name }}</td>
                            <td>
                                @if($client->idNumber === '0')
                                    No ID
                                @else
                                    {{ $client->idNumber }}
                                @endif
                            </td>
                            <td>{{ $client->phone }}</td>
                            <td>{{ $client->email }}</td>
                            <td>
                                <a class="btn btn-outline-info" href="client/{{ $client->id }}" data-toggle="tooltip" data-placement="top" title="Отвори"><i class="material-icons">link</i></a>
                                <a class="btn btn-outline-info" href="client/{{ $client->id }}/edit" data-toggle="tooltip" data-placement="top" title="Редактирай"><i class="material-icons">edit</i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
@endsection

@section('jsImport')
    <script src="{{ asset('js/clients.js') }}"></script>
    <script src="{{ asset('js/filters.js') }}"></script>
@endsection