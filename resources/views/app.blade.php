<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISMID</title>

    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/assets/css/bootstrap-theme.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/assets/css/font-awesome.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/assets/css/jquery.bootgrid.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/assets/css/custom.css') }}" rel="stylesheet">

    <!-- include the BotDetect layout stylesheet -->
    @if (class_exists('CaptchaUrls'))
        <link href="{{ CaptchaUrls::LayoutStylesheetUrl() }}" type="text/css" rel="stylesheet">
    @endif

    @yield('css')
</head>
<body>
    {{-- Top --}}
    <div class="navbar">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div id="barra-brasil" style="background:#7F7F7F; height: 20px; display:block;">
                        <ul id="menu-barra-temp" style="list-style:none;">
                            <li style="display:inline; float:left;padding-right:10px; margin-right:10px; border-right:1px solid #EDEDED">
                                <a href="http://brasil.gov.br" style="font-family:sans,sans-serif; text-decoration:none; color:white;">Portal do Governo Brasileiro</a>
                            </li>
                            <li>
                                <a style="font-family:sans,sans-serif; text-decoration:none; color:white;" href="http://epwg.governoeletronico.gov.br/barra/atualize.html">Atualize sua Barra de Governo</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="help-block"></div>
                </div>
            </div>

            <div class="row" style="margin-bottom: 5px;">
                <div class="col-sm-5">
                    <img src="{{ asset('assets/images/ibictlogo.png') }}" class="img-responsive">
                </div>
                <div class="col-sm-7 text-right">
                    <h3><a href="{{ url('/') }}">Sistema de Mapeamento de Inclusão Digital</a></h3>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">

                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#navbar-ex1-collapse" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    {{--<a class="navbar-brand" href="/">SisMID</a>--}}
                </div>

                <div class="collapse navbar-collapse navbar-ex1-collapse" id="navbar-ex1-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ route('mapa.index') }}">Mapa de Inclusão Digital</a></li>
                    </ul>

                    <ul class="nav navbar-nav">
                        <li><a href="{{ route('consulta.index') }}">Consultas</a></li>
                    </ul>

                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                               aria-expanded="false">Infográficos <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('report.indexPid') }}">Infográficos PIDs</a></li>
                                <li><a href="{{ route('report.pivoteamento.index') }}">Infográficos PIDs Pivoteamento</a>
                                </li>
                                <li><a href="{{ route('report.indexIniciativa') }}">Infográficos Iniciativas</a></li>

                            </ul>
                        </li>
                    </ul>
                    @if(Auth::guest())
                        <ul class="nav navbar-nav">
                            <li><a href="{{ route('sobre.index') }}">Sobre o SisMID</a></li>
                        </ul>
                    @endif
                    @if(!Auth::guest())
                        <ul class="nav navbar-nav">
                            @is('admin')
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">Iniciativa <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('iniciativa.index') }}">Iniciativas</a></li>
                                    <li><a href="{{ route('gestor.index') }}">Gestor de Iniciativa</a></li>
                                </ul>
                            </li>
                            @endis

                            @is('gestor')
                            <li><a href="{{ route('iniciativa.edit', Auth::user()->iniciativa_id) }}">Iniciativa</a></li>
                            @endis

                            <li><a href="{{ route('pid.index') }}">Pontos de Inclusão Digital</a></li>
                            <li><a href="{{ route('instituicao.index') }}">Instituições</a></li>
                            @is('admin')
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">Configurações <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('admin.gerencia.index') }}">Gerenciar Administradores</a></li>
                                    <li><a href="{{ route('admin.email.index') }}">Gerenciar Email</a></li>
                                    <li><a href="{{ route('admin.endContato.index') }}">Gerenciar Endereço/Telefone</a></li>
                                    <li><a href="{{ route('admin.infoEquipe.index') }}">Informações da equipe</a></li>

                                </ul>
                            </li>
                            @endis
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown" role="menuitem">
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button"
                                   aria-expanded="false">Sua Conta <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ route('password.getNewpassword') }}">Alterar Senha</a></li>
                                    <li><a href="{{ route('auth.logout') }}">Sair</a></li>
                                </ul>
                            </li>
                        </ul>
                    @else
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="{{ route('auth.formLogin') }}">Acesso Restrito</a></li>
                            {{--<li><a href="{{ route('auth.formRegister') }}">Cadastrar-se</a></li>--}}
                        </ul>
                </div>
                @endif
            </div>
        </nav>
    </div>

    {{-- Content --}}
    <div class="container" style="padding-top:0;">

        {{-- Loading --}}
        <div class="modal fade" id="loading">
            <div class="centro">
                <i style="color: white;" class="fa fa-cog fa-spin fa-5x"></i>
            </div>
        </div>

        {{-- page --}}
        @yield('content')

        <hr/>

        {{-- Rodape --}}
        <footer>
            <div class="row">
                <div class="col-sm-6 text-center">
                    <small>
                        <p>
                            <strong>Instituto Brasileiro de Informação em Ciência e Tecnologia (IBICT)</strong><br/>
                            Em Brasília: Setor de Autarquias Sul (SAUS) - Quadra 05 Lote 06 Bloco H <br/>
                            CEP: 70070-912 - Plano Piloto - DF <br/>
                            No Rio de Janeiro: Rua Lauro Muller, 455 - 4º Andar <br/>
                            CEP: 22290-160 - Botafogo - RJ
                        </p>
                    </small>
                </div>
                <div class="text-right">
                    <div class="col-sm-2 text-center">
                        <a href="http://www.mcti.gov.br/"><img src="{{ asset('assets/images/mcti.png') }}" class="img-responsive"></a>
                    </div>
                    <div class="col-sm-1 text-right">
                        <a href="http://www.fundep.ufmg.br/"><img src="{{ asset('assets/images/fundep.jpg') }}" class="img-responsive"></a>
                    </div>
                </div>

            </div>
        </footer>
    </div>

    <div class="help-block"></div>
    <script src="{{ asset('/assets/js/jquery-1.11.3.js') }}"></script>
    <script src="{{ asset('/assets/js/lodash.min.js') }}"></script>
    <script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/js/vue.min.js') }}"></script>
    <script src="{{ asset('/assets/js/vue-resource.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>
    @yield('script')
    <script src="//barra.brasil.gov.br/barra.js" type="text/javascript"></script>
</body>
</html>