@extends('app')
@section('content')
    {!! Breadcrumbs::render('gestor') !!}
    <div class="row">
        <div class="col-sm-12">
            <legend><i class="glyphicon glyphicon-list"></i> Gestores de Iniciativa</legend>
        </div>
    </div>

    <form name="pesquisar" id="pesquisar" action="{{ route('gestor.index') }}" method="GET">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-8">
                    <label for="nome">Nome</label>
                    <input class="form-control" type="text" name="nome" id="nome" value="{{ Input::get('nome') }}"/>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-sm-6">
                    <label for="iniciativa">Iniciativa</label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <select name="iniciativa[]" id="iniciativa" class="form-control" multiple="multiple">
                        @if(in_array(0, $selected))
                            <option selected value="0">Qualquer Iniciativa</option>
                        @else
                            <option value="0">Qualquer Iniciativa</option>
                        @endif
                        @foreach($iniciativas as $index => $ini)
                            @if(in_array($index, $selected))
                                <option selected value="{{ $index }}">{{ $ini}}</option>
                            @else
                                <option value="{{ $index }}">{{ $ini }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <button class="btn btn-md btn-block btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i> Pesquisar</button>
                </div>
                <div class="col-sm-4 text-right">
                    <a class="btn btn-md btn-primary" href="{{ route('gestor.create') }}"><i class="glyphicon glyphicon-plus"></i> Novo Gestor</a>
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-sm-12">
            @if(count($gestores))
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
            @else
                <div class="alert alert-info"><strong>Nenhuma informação encontrada!</strong></div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            {!! $gestores->appends(Input::query())->render() !!}
        </div>
    </div>
@endsection
@section('script')
    @parent
    <script src="{{ asset('/assets/js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $("#iniciativa").select2();
    </script>
@endsection
@section('css')
    <link href="{{ asset('/assets/css/select2.min.css') }}" rel="stylesheet">
@stop