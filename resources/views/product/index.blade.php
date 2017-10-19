@extends('layouts.app')

@section('content')

    @foreach($products as $product)
        <h1>{{ $product->type->title }} {{ $product->brand->title }} {{ $product->model->title }}</h1>
    @endforeach
    
@endsection