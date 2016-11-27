@extends('app')
@section('content')
    {!! Breadcrumbs::render('gerenciaAdmin') !!}
    <div class="row">
        <div class="col-sm-12">
            <legend><i class="glyphicon glyphicon-list"></i> Gerenciar Administradores</legend>
        </div>
    </div>
    @include("errors.list")
    <form name="pesquisar" id="pesquisar" action="{{ route('admin.gerencia.index') }}" method="GET">
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

                <div class="col-sm-3">
                    <button class="btn btn-md btn-block btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i> Pesquisar</button>
                </div>
                <div class="col-sm-9 text-right">
                    <a class="btn btn-md btn-primary" href="{{ route('admin.gerencia.create') }}"><i class="glyphicon glyphicon-plus"></i> Novo Administrador</a>
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
                        <th colspan="2">E-mail</th>


                    </tr>
                    </thead>
                    <tbody>
                    @foreach($gestores as $gestor)
                        <tr>
                            <td>{{ $gestor->nome }} {{ $gestor->sobrenome }}</td>
                            <td>{{ $gestor->email }}</td>
                            <td class="text-center">
                                <a class="btn btn sm btn-success" title="Editar Administrador: {{ $gestor->nome }}" href="{{ route('admin.gerencia.edit', $gestor->idUsuario) }}"><i class="glyphicon glyphicon-edit"></i></a>
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