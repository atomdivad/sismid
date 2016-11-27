@extends('app')
@section('content')
    {!! Breadcrumbs::render('gerenciaAdminEdit') !!}
    <div class="row">
        <div class="col-sm-12">
            <legend><i class="glyphicon glyphicon-edit"></i> Editar Administrador</legend>
        </div>
    </div>


    <div class="row" id="adminitrador">
        {!! Form::model($dados[0],['route'=>['admin.gerencia.update',$dados[0]->idUsuario],'method'=>'post']) !!}
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
            <div class="col-sm-12">
                @include("errors.list")
                @include('admin.gerencia.partials.form')
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-save"></span> Salvar</button>
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