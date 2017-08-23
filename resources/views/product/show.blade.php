@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col m12 s12">
            <div class="card blue-grey darken-1" id="product" data-content="{{ $product }}">
                <div class="card-content white-text">
                    <div class="row">
                        <div class="col m6 s6" id="productInfo">
                            <span class="card-title"></span>
                        </div>
                        <div class="col m6 s6" id="addOrder">
                            <div class="row">
                                <form class="col m12 s12">
                                    <div class="input-field col m6 s6">
                                        <input type="text" id="problem" name="problem">
                                        <label for="problem">Problem...</label>
                                    </div>
                                    <div class="input-field col m6 s6">
                                        <input type="text" id="now" name="now">
                                        <label for="now">Now...</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <textarea class="materialize-textarea" name="description"></textarea>
                                        <label for="description">Description...</label>
                                    </div>
                                    <div class="input-field col m6 s6">
                                        <input type="text" id="price" name="price">
                                        <label for="price">Price</label>
                                    </div>
                                    <div class="input-field col m6 s6">
                                        <input type="text" id="deposit" name="deposit">
                                        <label for="deposit">Deposit</label>
                                    </div>
                                    <div class="input-field col m12 s12 right-align">
                                        <button class="btn waves-effect waves-button-input"><i class="material-icons">save</i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col m6 s6" id="addRepair">
                            <div class="row">
                                <form class="col m12 s12">
                                    <div class="input-field col m12 s12">
                                        <input type="text" id="repair" name="repair">
                                        <label for="repair">Repair...</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <textarea class="materialize-textarea" name="description"></textarea>
                                        <label for="description">Description...</label>
                                    </div>
                                    <div class="input-field col m12 s12">
                                        <input type="text" id="price" name="price">
                                        <label for="price">Price</label>
                                    </div>
                                    <div class="input-field col m12 s12 right-align">
                                        <button class="btn waves-effect waves-button-input"><i class="material-icons">save</i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-action" id="orders">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('jsImport')
    <script src="{{ asset('js/showProduct.js') }}"></script>
@endsection
