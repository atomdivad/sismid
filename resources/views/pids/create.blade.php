@extends('app')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <legend><i class="glyphicon glyphicon-edit"></i> Cadastrar PID</legend>
        </div>
    </div>

    @include('errors.list')

    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <div class="row" id="PID">
        <div class="col-sm-12">


            @include('pids.partials.form', $uf)

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-save"></span> Cadastrar</button>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a class="btn btn-default" href="{{route('home')}}">Cancerlar</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection