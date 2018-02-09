@extends('layouts.app')

@section('content')

    <div class="container">
        <br>
        <div class="row col-12 height: 100px;">
            <div class="col-6 bg-dark mb-3 text-white align-middle" id="add-client-col">
                <h4 class="title">Настройки</h4>
                <form class="" role="form" method="POST" action="{{ route('settings.update') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="checkbox" name="no_reg" {{ $settings[0]->no_reg ? 'checked' : '' }} value="1" class="control-input" id="no_reg">
                        <label class="custom-control-label" for="no_reg">Без регистация</label>
                    </div>
                    <div class="form-group text-right">
                        <input type="hidden" name="_method" value="put">
                        <button type="submit" class="btn btn-primary">
                            <i class="material-icons">save</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

@endsection

@section('jsImport')
@endsection