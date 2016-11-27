@extends('app')
@section('content')
    {!! Breadcrumbs::render('reportIndexIniciativa') !!}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <legend><i class="fa fa-bar-chart"></i> Iniciativas</legend>
    <div class="row">
        <div class="col-sm-6">
            <div class="thumbnail">
                <div class="caption">
                    <div class="row">
                        <div class="col-sm-10">
                            <small id="IniciativaTiposTitle"><strong>Iniciativas: Tipos</strong></small>
                            <a class="openModal" href="#" data-chart="IniciativaTipos" data-toggle="modal" data-target="#modalAjuda"  title="Ajuda!"><i class="fa fa-question"></i></a>
                        </div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="IniciativaTipos" data-toggle="modal" data-target="#modalConf"  title="Configurar infográfico Iniciativas: Tipos"><i class="fa fa-cog"></i></a></div>
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
                        <div class="col-sm-10">
                            <small id="IniciativaLocalizacaoTitle"><strong>Iniciativas: Localização</strong></small>
                            <a class="openModal" href="#" data-chart="IniciativaLocalizacao" data-toggle="modal" data-target="#modalAjuda"  title="Ajuda!"><i class="fa fa-question"></i></a>
                        </div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="IniciativaLocalizacao" data-toggle="modal" data-target="#modalConf"  title="Configurar infográfico Iniciativas: Localização"><i class="fa fa-cog"></i></a></div>
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
                        <div class="col-sm-10">
                            <small id="IniciativaDimensaoTitle"><strong>Iniciativas: Dimensões</strong></small>
                            <a class="openModal" href="#" data-chart="IniciativaDimensao" data-toggle="modal" data-target="#modalAjuda"  title="Ajuda!"><i class="fa fa-question"></i></a>
                        </div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="IniciativaDimensao" data-toggle="modal" data-target="#modalConf"  title="Configurar infográfico Iniciativas: Dimensões"><i class="fa fa-cog"></i></a></div>
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
                        <div class="col-sm-10">
                            <small id="IniciativaCategoriasTitle"><strong>Iniciativas: Categorias</strong></small>
                            <a class="openModal" href="#" data-chart="IniciativaCategorias" data-toggle="modal" data-target="#modalAjuda"  title="Ajuda!"><i class="fa fa-question"></i></a>
                        </div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="IniciativaCategorias" data-toggle="modal" data-target="#modalConf"  title="Configurar infográfico Iniciativas: Categorias"><i class="fa fa-cog"></i></a></div>
                    </div>
                </div>
                <div id="iniciativaCategoria"></div>
                @piechart('IniciativaCategorias', 'iniciativaCategoria')
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="thumbnail">
                <div class="caption">
                    <div class="row">
                        <div class="col-sm-10">
                            <small id="IniciativaInstituicaoTitle"><strong>Iniciativas: Instituições</strong></small>
                            <a class="openModal" href="#" data-chart="IniciativaInstituicao" data-toggle="modal" data-target="#modalAjuda"  title="Ajuda!"><i class="fa fa-question"></i></a>
                        </div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="IniciativaInstituicao" data-toggle="modal" data-target="#modalConf"  title="Configurar infográfico Iniciativas: Instituições"><i class="fa fa-cog"></i></a></div>
                    </div>
                </div>
                <div id="iniciativaInstituicao"></div>
                @columnchart('IniciativaInstituicao', 'iniciativaInstituicao')
            </div>
        </div>
    </div>

    @include('relatorios.partials.modal_conf')
    @include('relatorios.partials.modal_ajuda')
@endsection
    @section('script')
        @parent
        <script src="{{ asset('assets/js/cidades.js') }}"></script>
        <script src="{{ asset('assets/js/reports.js') }}"></script>
    @endsection
