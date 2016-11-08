@extends('app')
@section('content')
    {!! Breadcrumbs::render('home') !!}
    <h5>Bem vindo {{ Auth::user()->present()->nome }}!</h5>
@is('admin')
    <legend><h6>Administrador</h6></legend>
    <div class="row">
        <div class="col-sm-4"><!-- Graph --></div>
        <div class="col-sm-2"> </div>
        @if($review >= 0)
            <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-11">
                            <span class="glyphicon glyphicon-flag"></span> Pontos de Inclusão Digital em revisão
                        </div>
                        <div class="col-sm-1" id="loading-data">
                            <i style="color: white;" class="fa fa-refresh fa-spin fa-1x"></i>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    {{--Manipuladores da tabela--}}
                    <div class="row">
                        {{--Filtro--}}
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span id="filter-addon" class="input-group-addon"><i class="glyphicon glyphicon-filter"></i></span>
                                <select name="filter" id="filter" class="form-control" aria-describedby="filter-addon">
                                    <option value="3">Todos</option>
                                    <option value="1">Submetidos p/ Revisão da Administração</option>
                                    <option value="0">Não Submetidos</option>
                                </select>
                            </div>
                        </div>
                        {{--Fim Filtro--}}

                        {{-- Div Mensagem Alerta --}}
                        <div class="col-sm-6">
                            <div id="alerta" class="alert alert-info alert-dismissable text-center" style="display: none;">
                                <div id="mensagem"><strong>Mensagem aqui</strong><br/></div>
                            </div>
                            {{-- Fim Div Mensagem Alerta --}}
                        </div>

                    </div>
                    {{--Fim Manipuladores da tabela--}}

                </div>
                {{--Tabela--}}
                <div class="row">
                    <div class="col-sm-12">
                        <table id="grid-data" class="table table-bordered tabel-responsive table-striped">
                            <thead>
                            <tr>
                                <th data-header-css-class="col-md-2" data-column-id="idPid" data-visible="false" data-type="numeric" data-searchable="false" data-sortable="false">ID</th>
                                <th data-header-css-class="col-md-6" data-column-id="nome">Nome</th>
                                <th data-header-css-class="col-md-6" data-column-id="created_at" data-converter="datetime">Enviado p/ revisão</th>
                                <th data-header-css-class="col-md-2" data-column-id="commands" data-formatter="commands" data-searchable="false" data-sortable="false">Ações</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                {{--Fim Tabela--}}
            </div>
        </div>
        @endif
    </div>
    @include('revisao.pids.partials.remove_review_modal')
    @section('script')
        @parent
        <script src="{{ asset('/assets/js/moment.min.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery.bootgrid.min.js') }}"></script>
        <script src="{{ asset('/assets/js/home.js') }}"></script>
    @endsection
@endis
@is('gestor')
    <h5>Usuario Gestor</h5>
@endis

@endsection