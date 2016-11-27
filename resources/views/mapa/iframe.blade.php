<link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet">

<link href="{{ asset('/assets/css/bootstrap-theme.min.css') }}" rel="stylesheet">

<link href="{{ asset('/assets/css/font-awesome.min.css') }}" rel="stylesheet">

<link href="{{ asset('/assets/css/jquery.bootgrid.min.css') }}" rel="stylesheet">

<link href="{{ asset('/assets/css/custom.css') }}" rel="stylesheet">


{{-- Loading --}}
<div class="modal fade" id="loading">
    <div class="centro">
        <i style="color: white;" class="fa fa-cog fa-spin fa-5x"></i>
    </div>
</div>


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="form-group">
        <div class="row">
            <div class="col-sm-2">
                {!! Form::label('uf', 'UF') !!}
            </div>
            <div class="col-sm-4">
                {!! Form::label('cidade_id', 'Cidade') !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label('agrupamento', 'Agrupamento') !!}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <select name="uf" id="uf" class="form-control">
                    <option value="0">Todos UF</option>
                    @foreach($uf as $index => $u)
                        <option value="{{ $index }}">{{ $u }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4">
                {!! Form::select('cidade_id', [], null, ["class" => "form-control"]) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::select('agrupamento', [0 => 'Sem Agrupamento', 'estado' => 'Agrupar por estado', 'regiao' => 'Agrupar por região'], '', ["class" => "form-control"]) !!}
            </div>
            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-6 text-right">
                        <button class="btn btn-sm btn-primary" id="btnFiltrar" title="Realizar Consulta"><i class="fa fa-search"></i> Consultar</button>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button class="btn btn-sm btn-default" id="btnClear" title="Limpar Consulta">Limpar</button>
                    </div>
                </div>
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

    <script src="{{ asset('/assets/js/jquery-1.11.3.js') }}"></script>
    <script src="{{ asset('/assets/js/lodash.min.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/js/vue.min.js') }}"></script>
    <script src="{{ asset('/assets/js/vue-resource.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('/assets/js/select2.min.js') }}"></script>
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
    <script src="{{ asset('/assets/js/jquery.bootgrid.min.js') }}"></script>
    <script src="{{ asset('/assets/js/mapa.js') }}"></script>

    <link href="{{ asset('/assets/css/select2.min.css') }}" rel="stylesheet">

