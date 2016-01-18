@extends('app')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <legend><i class="glyphicon glyphicon-edit"></i> Cadastrar Gestror de Iniciativa</legend>
        </div>
    </div>


    <div class="row" id="adminitrador">
        <form name="cadastrar" id="cadastro" action="{{ route('admin.gerencia.store') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        <div class="col-sm-12">
            @include("errors.list")
            @include('admin.gerencia.partials.form')
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-save"></span> Cadastrar</button>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a class="btn btn-default" href="{{route('admin.gerencia.index')}}">Cancerlar</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </form>
@endsection