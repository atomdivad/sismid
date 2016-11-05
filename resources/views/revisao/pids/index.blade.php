@extends('app')
@section('content')
    {{ \Carbon\Carbon::setLocale('pt') }}

    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    {!! Breadcrumbs::render('pidReview') !!}

    <div class="row">
        <div class="col-sm-12">
            <legend><i class="glyphicon glyphicon-list"></i> Revisão de PIDs</legend>
        </div>
    </div>


    <div class="row right">
        <div class="col-sm-8">
            {{-- Div Mensagem Alerta --}}
            <div class="col-sm-12">
                <div id="alerta" class="alert alert-info alert-dismissable" style="display: none;">
                    <div id="mensagem"><strong>Mensagem aqui</strong><br/></div>
                </div>
            </div>
            {{-- Fim Div Mensagem Alerta --}}
        </div>
        <div class="col-sm-4">
            <div class="input-group">
                <span id="filter-addon" class="input-group-addon"><i class="glyphicon glyphicon-filter"></i></span>
                <select name="filter" id="filter" class="form-control" aria-describedby="filter-addon">
                    <option value="3">Todos</option>
                    <option value="1">Submetidos p/ Revisão da Administração</option>
                    <option value="0">Não Submetidos</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <table id="grid-data" class="table table-bordered tabel-responsive table-striped">
                <thead>
                <tr>
                    <th data-header-css-class="col-md-2" data-column-id="idPid" data-visible="false" data-type="numeric" data-searchable="false" data-sortable="false">ID</th>
                    <th data-header-css-class="col-md-5" data-column-id="nome">Nome</th>
                    <th data-header-css-class="col-md-5" data-column-id="email">E-mail</th>
                    <th data-header-css-class="col-md-2" data-column-id="submetido" data-converter="boolean" data-visible="false">Submetido</th>
                    <th data-header-css-class="col-md-3" data-column-id="created_at" data-converter="datetime">Enviado p/ revisão</th>
                    <th data-header-css-class="col-md-2" data-column-id="commands" data-formatter="commands" data-searchable="false" data-sortable="false">Ações</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    </div>

    @include('revisao.pids.partials.remove_review_modal')
@endsection
@section('script')
    @parent
    <script src="{{ asset('/assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.bootgrid.min.js') }}"></script>
    <script src="{{ asset('/assets/js/pidReview.js') }}"></script>
@endsection