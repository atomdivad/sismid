@extends('app')
@section('content')
    {!! Breadcrumbs::render('consulta') !!}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <legend><i class="fa fa-bar-chart"></i> Iniciativas</legend>
    <div class="row">
        <div class="col-sm-6">
            <div class="thumbnail">
                <div class="caption">
                    <div class="row">
                        <div class="col-sm-10"><small><strong>Iniciativas: Tipos</strong></small></div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="IniciativaTipos" data-toggle="modal" data-target="#modalConf"><i class="fa fa-cog"></i></a></div>
                    </div>
                </div>
                <div id="iniciativaTipo"></div>
                @barchart('IniciativaTipos', 'iniciativaTipo')
            </div>
        </div>

        <div class="col-sm-6">
            <div class="thumbnail">
                <div class="caption">
                    <div class="row">
                        <div class="col-sm-10"><small><strong>Iniciativas: Localização</strong></small></div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="IniciativaLocalizacao" data-toggle="modal" data-target="#modalConf"><i class="fa fa-cog"></i></a></div>
                    </div>
                </div>
                <div id="iniciativaLocalizacao"></div>
                @piechart('IniciativaLocalizacao', 'iniciativaLocalizacao')
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="thumbnail">
                <div class="caption">
                    <div class="row">
                        <div class="col-sm-10"><small><strong>Iniciativas: Dimensões</strong></small></div>
                        <div class="col-sm-2 text-right"><a href="#"><i class="fa fa-cog"></i></a></div>
                    </div>
                </div>
                <div id="iniciativaDimensao"></div>
                @piechart('IniciativaDimensao', 'iniciativaDimensao')
            </div>
        </div>

        <div class="col-sm-6">
            <div class="thumbnail">
                <div class="caption">
                    <div class="row">
                        <div class="col-sm-10"><small><strong>Iniciativas: Serviços</strong></small></div>
                        <div class="col-sm-2 text-right"><a href="#"><i class="fa fa-cog"></i></a></div>
                    </div>
                </div>
                <div id="iniciativaServico"></div>
                @piechart('IniciativaServico', 'iniciativaServico')
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="thumbnail">
                <div class="caption">
                    <div class="row">
                        <div class="col-sm-10"><small><strong>Iniciativas: Categorias</strong></small></div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="IniciativaCategorias" data-toggle="modal" data-target="#modalConf"><i class="fa fa-cog"></i></a></div>
                    </div>
                </div>
                <div id="iniciativaCategoria"></div>
                @piechart('IniciativaCategorias', 'iniciativaCategoria')
            </div>
        </div>

        <div class="col-sm-6">
            <div class="thumbnail">
                <div class="caption">
                    <div class="row">
                        <div class="col-sm-10"><small><strong>Iniciativas: Natureza Jurídica</strong></small></div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="InicativaNaturezas" data-toggle="modal" data-target="#modalConf"><i class="fa fa-cog"></i></a></div>
                    </div>
                </div>
                <div id="iniciativaNatureza"></div>
                @piechart('InicativaNaturezas', 'iniciativaNatureza')
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="thumbnail">
                <div class="caption">
                    <div class="row">
                        <div class="col-sm-10"><small><strong>Iniciativas: Instituições</strong></small></div>
                        <div class="col-sm-2 text-right"><a href="#"><i class="fa fa-cog"></i></a></div>
                    </div>
                </div>
                <div id="iniciativaInstituicao"></div>
                @columnchart('IniciativaInstituicao', 'iniciativaInstituicao')
            </div>
        </div>
    </div>
    @include('relatorios.partials.modal_conf')
@endsection
@section('script')
    @parent
    <script src="{{ asset('assets/js/cidades.js') }}"></script>
    <script src="{{ asset('assets/js/reports.js') }}"></script>
@endsection
    {{--
    @section('script')
        @parent
        <script src="{{ asset('assets/js/reports.js') }}"></script>
    @endsection--}}
