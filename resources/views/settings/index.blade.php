@extends('layouts.app')

@section('content')

    <div class="">
        <div class="card bg-dark text-white mb-3" style="width: 25rem">
            <div class="card-body">
                <h5 class="card-title">Настройки</h5>
                <form class="" role="form" method="POST" action="{{ route('settings.update') }}">
                    {{ csrf_field() }}
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="no_reg" {{ $settings[0]->no_reg ? 'checked' : '' }} value="1" id="no_reg">
                        <label class="form-check-label" for="no_reg">Без регистация</label>
                    </div>
                    <div class="form-group text-right">
                        <input type="hidden" name="_method" value="put">
                        <button type="submit" class="btn btn-outline-light">
                            <i class="material-icons">save</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('jsImport')
@endsection