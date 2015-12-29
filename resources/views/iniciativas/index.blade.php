@extends('app')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <legend><i class="glyphicon glyphicon-list"></i> Iniciativas</legend>
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
                <a class="btn btn-sm btn-primary" href="{{ route('iniciativa.create') }}"><i class="glyphicon glyphicon-plus"></i> Nova Iniciativa</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <table class="table table-responsive table-bordered table-striped">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Município / UF</th>
                    <th>E-mail</th>
                    <th colspan="2"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($iniciativas as $iniciativa)
                    <tr>
                        <td>{{ $iniciativa->nome }}</td>
                        <td>{{ $iniciativa->nomeCidade}} / {{ $iniciativa->uf }}</td>
                        <td>{{ $iniciativa->email }}</td>
                        <td class="text-center">
                            <a class="btn btn sm btn-primary" title="Exbir iniciativia: {{ $iniciativa->nome }}" href="{{ route('iniciativa.show', $iniciativa->idIniciativa) }}"><i class="glyphicon glyphicon-eye-open"></i></a>
                            <a class="btn btn sm btn-success" title="Editar iniciativia: {{ $iniciativa->nome }}" href="{{ route('iniciativa.edit', $iniciativa->idIniciativa) }}"><i class="glyphicon glyphicon-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection