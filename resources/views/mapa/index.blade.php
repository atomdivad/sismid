@extends('app')
@section('content')
    {!! Breadcrumbs::render('mapa') !!}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="row">
        <div class="col-sm-12">
            <legend><i class="glyphicon glyphicon-list"></i> Mapa de Inclusão Digital</legend>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6">
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
            <div class="col-sm-2">
                {!! Form::label('uf', 'UF') !!}
                <select name="uf" id="uf" class="form-control">
                    <option value="0">Todos UF</option>
                    @foreach($uf as $index => $u)
                        <option value="{{ $index }}">{{ $u }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4">
                {!! Form::label('cidade_id', 'Cidade') !!}
                {!! Form::select('cidade_id', [], null, ["class" => "form-control"]) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label('agrupamento', 'Agrupamento') !!}
                {!! Form::select('agrupamento', [0 => 'Sem Agrupamento', 'estado' => 'Agrupar por estado', 'regiao' => 'Agrupar por região'], '', ["class" => "form-control"]) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-sm-6">
                <button class="btn btn-sm btn-primary" id="btnFiltrar">Consultar</button>
                <button class="btn btn-sm btn-default" id="btnClear">Limpar</button>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-sm-12">
                <div id="map" style="width: 100%; height: 500px;"></div>
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
                        <th data-column-id="commands" data-formatter="commands" data-searchable="false" data-sortable="false">Visualizar</th>
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
    <script type="text/javascript">
        $("#tipoBusca").select2();
    </script>
    <script src="{{ asset('/assets/js/cidades.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <script src="{{ asset('/assets/js/markerclusterer.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/acCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/alCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/amCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/apCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/baCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/ceCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/dfCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/esCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/goCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/maCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/mgCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/msCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/mtCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/paCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/pbCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/peCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/piCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/prCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/rjCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/rnCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/roCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/rrCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/rsCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/scCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/seCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/spCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/toCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/regioes/coCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/regioes/nCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/regioes/neCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/regioes/sCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/regioes/seCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/infobox.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.bootgrid.min.js') }}"></script>
    <script src="{{ asset('/assets/js/mapa.js') }}"></script>
@endsection
@section('css')
    <link href="{{ asset('/assets/css/select2.min.css') }}" rel="stylesheet">
@stop