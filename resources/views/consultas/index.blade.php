@extends('app')
@section('content')
    {!! Breadcrumbs::render('consulta') !!}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="row">
        <div class="col-sm-12">
            <legend><i class="glyphicon glyphicon-list"></i> Consultas</legend>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        <label for="searchInput">Nome</label>
                        <input name="searchInput" id="searchInput" class="form-control" type="text"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        <label for="tipoBusca">Buscar</label> <small id="msg" style="display: none;" class="alert-danger">Você deve marcar pelo menos uma opção</small>
                        <select name="tipoBusca" id="tipoBusca" class="form-control" multiple required>
                            <option selected value="0">PID</option>
                            <option selected value="1">Programa</option>
                            <option selected value="2">Projeto</option>
                            <option selected value="3">Ação</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <label for="ativo">PIDs Ativos/Inativos</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <select name="ativo" id="ativo" class="form-control">
                            <option value="1">Ativos</option>
                            <option value="2">Desativados</option>
                            <option value="3">Todos</option>
                        </select>
                    </div>
                    <div class="col-sm-5 text-right">
                        <div class="row">
                            <div class="col-sm-6">
                                <button class="btn btn-sm btn-primary btn-block" id="btnFiltrar"><i class="glyphicon glyphicon-search"></i> Consultar</button>
                            </div>
                            <div class="col-sm-6">
                                <button class="btn btn-sm btn-default btn-block" id="btnClear"><i class="glyphicon glyphicon-remove"></i> Limpar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('uf', 'UF') !!}
                        <select name="uf" id="uf" class="form-control">
                            <option value="0">Todos UF</option>
                            @foreach($uf as $index => $u)
                                <option value="{{ $index }}">{{ $u }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6">
                        {!! Form::label('cidade_id', 'Cidade') !!}
                        {!! Form::select('cidade_id', [], null, ["class" => "form-control"]) !!}
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <label for="agrupamento">Região</label>
                        <select class="form-control" name="agrupamento" id="agrupamento">
                            <option value="0">Todas Regiões</option>
                            <option value="1">Centro Oeste</option>
                            <option value="2">Norte</option>
                            <option value="3">Nordeste</option>
                            <option value="4">Sul</option>
                            <option value="5">Suldeste</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="localizacao">Localização</label>
                        <select name="localizacao" id="localizacao" class="form-control">
                            <option value="3">Todas</option>
                            <option value="1">Área Urbana</option>
                            <option value="2">Área Não Urbana</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group" id="grid">
        <div class="row">
            <div class="col-sm-12">
                <table id="grid-data" class="table table-bordered tabel-responsive table-striped">
                    <thead>
                    <tr>
                        <th data-header-css-class="col-md-1" data-column-id="id" data-visible="false" data-type="numeric">ID</th>
                        <th data-header-css-class="col-md-1" data-column-id="tipo">Tipo</th>
                        <th data-header-css-class="col-md-5" data-column-id="nome">Nome</th>
                        <th data-header-css-class="col-md-2" data-column-id="endereco">Endereço</th>
                        <th data-header-css-class="col-md-2" data-column-id="nomeCidade">Município</th>
                        <th data-header-css-class="col-md-1" data-column-id="uf">UF</th>
                        <th data-header-css-class="col-md-1" data-column-id="commands" data-formatter="commands" data-searchable="false" data-sortable="false">Visualizar</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @include('mapa.partials.modal_info_pid')
    @include('mapa.partials.modal_info_iniciativa')


@endsection
@section('script')
    @parent
    <script src="{{ asset('/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('/assets/js/cidades.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.bootgrid.min.js') }}"></script>
    <script src="{{ asset('/assets/js/consulta.js') }}"></script>
@endsection
@section('css')
    <link href="{{ asset('/assets/css/select2.min.css') }}" rel="stylesheet">
@stop
