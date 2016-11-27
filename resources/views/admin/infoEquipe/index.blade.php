@extends('app')
@section('content')
    {!! Breadcrumbs::render('infoEquipe') !!}
    <div class="row">
        <div class="col-sm-12">
            <legend><i class="glyphicon glyphicon-list"></i> Gerenciar Informações de Equipe</legend>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-12">
            @include("errors.list")
            <table class="table table-responsive table-bordered table-striped">
                <thead>
                <tr>

                    <th colspan="2">Informações</th>

                </tr>




                </thead>
                <tbody>

                    <tr>
                        <td class="col-md-11">
                        {{ $dados[0]->info_equipe }}
                        </td>
                        <td class="text-center" >

                            <a class="btn btn sm btn-success" title="Editar Informações" href="{{ route('admin.infoEquipe.editInfoEquipe',$dados[0]->id) }}"><i class="glyphicon glyphicon-edit"></i></a>
                        </td>

                    </tr>

                </tbody>
            </table>
            <table class="table table-responsive table-bordered table-striped">

            </table>
        </div>
    </div>
@endsection