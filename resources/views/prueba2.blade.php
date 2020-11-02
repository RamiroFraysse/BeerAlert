@extends('layouts.app')
@section('content')
    <!-- action es hacia donde lo queremos enviar
    method a traves de que metodo -->
    

    <div class="panel-body">
        <form class="form-horizontal" method="POST" action="{{ route('entrada_datos') }}">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="serie" class="col-md-4 control-label">Serie</label>

                <div class="col-md-6">
                    <input id="serie" type="text" class="form-control" name="serie" value="{{ old('serie') }}">
                </div>
            </div>
            <div class="form-group">
                <label for="temperatura" class="col-md-4 control-label">temperatura</label>

                <div class="col-md-6">
                    <input id="temperatura" type="text" class="form-control" name="temperatura" value="{{ old('temperatura') }}">
                </div>
            </div>
            <div class="form-group">
                <label for="ssid" class="col-md-4 control-label">SSID</label>

                <div class="col-md-6">
                    <input id="ssid" type="text" class="form-control" name="ssid" value="{{ old('ssid') }}">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        Enviar
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    
    
@endsection

