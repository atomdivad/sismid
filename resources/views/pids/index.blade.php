@extends('app')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <legend><i class="glyphicon glyphicon-list"></i> Pontos de Inclusão Digital</legend>
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
                <a class="btn btn-sm btn-primary" href="{{ route('pid.create') }}"><i class="glyphicon glyphicon-plus"></i> Novo PID</a>
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
                @foreach($pids as $pid)
                    <tr>
                        <td class="col-md-3">{{ $pid->nome }}</td>
                        <td class="col-md-1">{{ $pid->nomeCidade}} / {{ $pid->uf }}</td>
                        <td class="col-md-1">{{ $pid->email }}</td>
                        <td class="col-md-1 text-center">
                            <a class="btn btn sm btn-primary" title="Exbir PID: {{ $pid->nome }}" href="{{ route('pid.show', $pid->idPid) }}"><i class="glyphicon glyphicon-eye-open"></i></a>
                            <a class="btn btn sm btn-success" title="Editar PID: {{ $pid->nome }}" href="{{ route('pid.edit', $pid->idPid) }}"><i class="glyphicon glyphicon-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            {!! $pids->render() !!}
        </div>
    </div>
@endsection