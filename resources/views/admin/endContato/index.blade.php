@extends('app')
@section('content')
    {!! Breadcrumbs::render('endContato') !!}
    <div class="row">
        <div class="col-sm-12">
            <legend><i class="glyphicon glyphicon-list"></i> Gerenciar Telefone e Endereço</legend>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-12">
            @include("errors.list")
            <table class="table table-responsive table-bordered table-striped">
                <thead>
                <tr>

                    <th colspan="2">Endereço</th>

                </tr>




                </thead>
                <tbody>

                    <tr>
                        <td width="95%">
                        {{ $dados[0]->endereco }}
                        </td>
                        <td class="text-center">

                            <a class="btn btn sm btn-success" title="Editar Endereço" href="{{ route('admin.endContato.editEndereco',$dados[0]->id) }}"><i class="glyphicon glyphicon-edit"></i></a>
                        </td>

                    </tr>

                </tbody>
            </table>
            <table class="table table-responsive table-bordered table-striped">
                <thead>
                <tr>

                    <th colspan="2">Telefone</th>

                </tr>




                </thead>
                <tbody>

                <tr>
                    <td width="95%">
                        {{ $dados[0]->telefone }}
                    </td>
                    <td class="text-center">

                        <a class="btn btn sm btn-success" title="Editar Telefone" href="{{ route('admin.endContato.editTelefone',$dados[0]->id) }}"><i class="glyphicon glyphicon-earphone"></i></a>
                    </td>

                </tr>

                </tbody>
            </table>
        </div>
    </div>
@endsection