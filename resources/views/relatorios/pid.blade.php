@extends('app')
@section('content')
    {!! Breadcrumbs::render('reportIndexPid') !!}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <legend><i class="fa fa-bar-chart"></i> Pontos de Inclusão Digital</legend>
    <div class="row">
        <div class="col-sm-6">
            <div class="thumbnail">
                <div class="caption">
                    <div class="row">
                        <div class="col-sm-10">
                            <small id="PidStatusTitle"><strong>Pontos de Inclusão Digital: Status</strong></small>
                            <a class="openModal" href="#" data-chart="PidStatus" data-toggle="modal" data-target="#modalAjuda"  title="Ajuda!"><i class="fa fa-question"></i></a>
                        </div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="PidStatus" data-toggle="modal" data-target="#modalConf" title="Pontos de Inclusão Digital: Status"><i class="fa fa-cog"></i></a></div>
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
                        <div class="col-sm-10">
                            <small id="PidTiposTitle"><strong>Pontos de Inclusão Digital: Tipo</strong></small>
                            <a class="openModal" href="#" data-chart="PidTipos" data-toggle="modal" data-target="#modalAjuda"  title="Ajuda!"><i class="fa fa-question"></i></a>
                        </div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="PidTipos" data-toggle="modal" data-target="#modalConf" title="Pontos de Inclusão Digital: Tipo"><i class="fa fa-cog"></i></a></div>
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
                        <div class="col-sm-10">
                            <small id="PidIniciativaTitle"><strong>Pontos de Inclusão Digital: Vinculados à Inicativas</strong></small>
                            <a class="openModal" href="#" data-chart="PidIniciativa" data-toggle="modal" data-target="#modalAjuda"  title="Ajuda!"><i class="fa fa-question"></i></a>
                        </div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="PidIniciativa" data-toggle="modal" data-target="#modalConf" title="Pontos de Inclusão Digital: Vinculados à Inicativas"><i class="fa fa-cog"></i></a></div>
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
                        <div class="col-sm-10">
                            <small id="PidInstituicaoTitle"><strong>Pontos de Inclusão Digital: Instituições Mantenedoras</strong></small>
                            <a class="openModal" href="#" data-chart="PidInstituicao" data-toggle="modal" data-target="#modalAjuda"  title="Ajuda!"><i class="fa fa-question"></i></a>
                        </div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="PidInstituicao" data-toggle="modal" data-target="#modalConf" title="Pontos de Inclusão Digital: Instituições Mantenedoras"><i class="fa fa-cog"></i></a></div>
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
                        <div class="col-sm-10">
                            <small id="PidLocalizcaoTitle"><strong>Pontos de Inclusão Digital: Localização</strong></small>
                            <a class="openModal" href="#" data-chart="PidLocalizcao" data-toggle="modal" data-target="#modalAjuda"  title="Ajuda!"><i class="fa fa-question"></i></a>
                        </div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="PidLocalizcao" data-toggle="modal" data-target="#modalConf" title="Pontos de Inclusão Digital: Localização"><i class="fa fa-cog"></i></a></div>
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
                        <div class="col-sm-10">
                            <small id="PidLocalidadeTitle"><strong>Pontos de Inclusão Digital: Localidade</strong></small>
                            <a class="openModal" href="#" data-chart="PidLocalidade" data-toggle="modal" data-target="#modalAjuda"  title="Ajuda!"><i class="fa fa-question"></i></a>
                        </div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="PidLocalidade" data-toggle="modal" data-target="#modalConf" title="Pontos de Inclusão Digital: Localidade"><i class="fa fa-cog"></i></a></div>
                    </div>
                </div>
                <div id="pidLocalidade"></div>
                @piechart('PidLocalidade', 'pidLocalidade')
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="thumbnail">
                <div class="caption">
                    <div class="row">
                        <div class="col-sm-10">
                            <small id="PidServicoTitle"><strong>Pontos de Inclusão Digital: Serviços</strong></small>
                            <a class="openModal" href="#" data-chart="PidServico" data-toggle="modal" data-target="#modalAjuda"  title="Ajuda!"><i class="fa fa-question"></i></a>
                        </div>
                        <div class="col-sm-2 text-right"><a class="openModal" href="#" data-chart="PidServico" data-toggle="modal" data-target="#modalConf" title="Pontos de Inclusão Digital: Serviços"><i class="fa fa-cog"></i></a></div>
                    </div>
                </div>
                <div id="pidServico"></div>
                @piechart('PidServico', 'pidServico')
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
