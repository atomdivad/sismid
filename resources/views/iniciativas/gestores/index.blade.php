@extends('app')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <legend><i class="glyphicon glyphicon-list"></i> Gestores de Iniciativa</legend>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-sm-6">
                <input class="form-control" type="text" name="pesquisar" id="pesquisar"/>
            </div>
            <div class="col-sm-3">
                <button class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-search"></i> Pesquisar</button>
            </div>
            <div class="col-sm-3 text-right">
                <a class="btn btn-sm btn-primary" href="{{ route('gestor.create') }}"><i class="glyphicon glyphicon-plus"></i> Novo Gestor</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <table class="table table-responsive table-bordered table-striped">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Iniciativa</th>
                    <th colspan="2"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($gestores as $gestor)
                    <tr>
                        <td>{{ $gestor->nome }} {{ $gestor->sobrenome }}</td>
                        <td>{{ $gestor->email }}</td>
                        <td>{{ $gestor->nomeIniciativa }}</td>
                        <td class="text-center">
                            <a class="btn btn sm btn-primary" title="Exbir iniciativia: {{ $gestor->nome }}" href="{{ route('gestor.show', $gestor->idUsuario) }}"><i class="glyphicon glyphicon-eye-open"></i></a>
                            <a class="btn btn sm btn-success" title="Editar iniciativia: {{ $gestor->nome }}" href="{{ route('gestor.edit', $gestor->idUsuario) }}"><i class="glyphicon glyphicon-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection