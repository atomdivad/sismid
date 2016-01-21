@extends('app')
@section('content')
    {!! Breadcrumbs::render('consulta') !!}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <legend><i class="fa fa-bar-chart"></i> Pontos de Inclusão Digital</legend>
    <div class="row">
        <div class="col-sm-6">
            <div class="thumbnail">
                <div class="caption">
                    <div class="row">
                        <div class="col-sm-10"><small id="PidStatusTitle"><strong>Pontos de Inclusão Digital: Status</strong></small></div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="PidStatus" data-toggle="modal" data-target="#modalConf"><i class="fa fa-cog"></i></a></div>
                    </div>
                </div>
                <div id="pidStatus"></div>
                @barchart('PidStatus', 'pidStatus')
            </div>
        </div>

        <div class="col-sm-6">
            <div class="thumbnail">
                <div class="caption">
                    <div class="row">
                        <div class="col-sm-10"><small id="PidTiposTitle"><strong>Pontos de Inclusão Digital: Tipo</strong></small></div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="PidTipos" data-toggle="modal" data-target="#modalConf"><i class="fa fa-cog"></i></a></div>
                    </div>
                </div>
                <div id="pidTipo"></div>
                @piechart('PidTipos', 'pidTipo')
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="thumbnail">
                <div class="caption">
                    <div class="row">
                        <div class="col-sm-10"><small id="PidIniciativaTitle"><strong>Pontos de Inclusão Digital: Inicativas</strong></small></div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="PidIniciativa" data-toggle="modal" data-target="#modalConf"><i class="fa fa-cog"></i></a></div>
                    </div>
                </div>
                <div id="pidIniciativa"></div>
                @piechart('PidIniciativa', 'pidIniciativa')
            </div>
        </div>

        <div class="col-sm-6">
            <div class="thumbnail">
                <div class="caption">
                    <div class="row">
                        <div class="col-sm-10"><small id="PidInstituicaoTitle"><strong>Pontos de Inclusão Digital: Instituições</strong></small></div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="PidInstituicao" data-toggle="modal" data-target="#modalConf"><i class="fa fa-cog"></i></a></div>
                    </div>
                </div>
                <div id="pidInstituicao"></div>
                @columnchart('PidInstituicao', 'pidInstituicao')
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="thumbnail">
                <div class="caption">
                    <div class="row">
                        <div class="col-sm-10"><small id="PidLocalizcaoTitle"><strong>Pontos de Inclusão Digital: Localização</strong></small></div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="PidLocalizcao" data-toggle="modal" data-target="#modalConf"><i class="fa fa-cog"></i></a></div>
                    </div>
                </div>
                <div id="pidLocalizcao"></div>
                @piechart('PidLocalizcao', 'pidLocalizcao')
            </div>
        </div>

        <div class="col-sm-6">
            <div class="thumbnail">
                <div class="caption">
                    <div class="row">
                        <div class="col-sm-10"><small id="PidLocalidadeTitle"><strong>Pontos de Inclusão Digital: Localidade</strong></small></div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="PidLocalidade" data-toggle="modal" data-target="#modalConf"><i class="fa fa-cog"></i></a></div>
                    </div>
                </div>
                <div id="pidLocalidade"></div>
                @piechart('PidLocalidade', 'pidLocalidade')
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
