@extends('app')
@section('content')
    {!! Breadcrumbs::render('email') !!}
    <div class="row">
        <div class="col-sm-12">
            <legend><i class="glyphicon glyphicon-list"></i> Configurar E-mail de Contato</legend>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-12">
            @include("errors.list")
            <table class="table table-responsive table-bordered table-striped">
                <thead>
                <tr>

                    <th colspan="2">E-mail</th>

                </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>
                        {{ $dados[0]->email }}
                        </td>
                        <td class="text-center">

                            <a class="btn btn sm btn-success" title="Editar E-mail" href="{{ route('admin.email.edit',$dados[0]->id) }}"><i class="glyphicon glyphicon-edit"></i></a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
@endsection