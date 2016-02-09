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

<nav class="navbar navbar-default navbar-fixed-top">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-ex1-collapse" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">SisMID</a>
        </div>

            <div class="collapse navbar-collapse navbar-ex1-collapse" id="navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('mapa.index') }}">Mapa Inclusão Digital</a></li>
                </ul>

                <ul class="nav navbar-nav">
                    <li><a href="{{ route('consulta.index') }}">Consultas</a></li>
                </ul>

                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Infográficos <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('report.indexPid') }}">Infográficos PIDs</a></li>
                            <li><a href="{{ route('report.pivoteamento.index') }}">Infográficos PIDs Pivoteamento</a></li>
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
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Iniciativa <span class="caret"></span></a>
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
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Configurações <span class="caret"></span></a>
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
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">Sua Conta <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('password.getNewpassword') }}">Alterar Senha</a></li>
                                <li><a href="{{ route('auth.logout') }}">Sair</a></li>
                            </ul>
                        </li>
                    </ul>
                @else
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{ route('auth.formLogin') }}">Entrar</a></li>
                        {{--<li><a href="{{ route('auth.formRegister') }}">Cadastrar-se</a></li>--}}
                    </ul>
            </div>
        @endif
    </div>
</nav>

<div class="container-fluid" style="padding-top:70px;">
    <div class="modal fade" id="feedBackModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-comment"></i> Feedback</h4>
                </div>
                <div class="modal-body">
                    <form action="/feedback" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="nome">Nome</label>
                                    <input type="text" id="nome" name="nome" class="form-control" required="required"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="email" id="email" name="email" class="form-control" required="required"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="msg">Reporte algum erro ou deixe a sua sugestão!</label>
                                    <textarea name="msg" id="msg" class="form-control" rows="10" required="required"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                        <button id="confirm" class="btn btn-primary"><i class="fa fa-send"></i> Enviar</button>
                        <button id="cancel" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <button title="FeedBack" class="btn btn-info btn-sm" style="position:fixed; margin-left:0;" data-toggle="modal" data-target="#feedBackModal"><i class="fa fa-comment"></i></button>
</div>
<div class="container" style="padding-top:0px;">

    <div class="modal fade" id="loading">
        <div class="centro">
            <i style="color: white;" class="fa fa-cog fa-spin fa-5x"></i>
        </div>
    </div>

    @yield('content')

    <hr/>

    <footer class="text-center">
        <small>
            <p>
                <strong>Instituto Brasileiro de Informação em Ciência e Tecnologia (IBICT)</strong><br/>
                Em Brasília: Setor de Autarquias Sul (SAUS) - Quadra 05 Lote 06 Bloco H <br/>
                CEP: 70070-912 - Plano Piloto - DF <br/>
                No Rio de Janeiro: Rua Lauro Muller, 455 - 4º Andar <br/>
                CEP: 22290-160 - Botafogo - RJ
            </p>
        </small>
    </footer>
</div>

<script src="{{ asset('/assets/js/jquery-1.11.3.js') }}"></script>
<script src="{{ asset('/assets/js/lodash.min.js') }}"></script>
<script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/assets/js/vue.min.js') }}"></script>
<script src="{{ asset('/assets/js/vue-resource.min.js') }}"></script>
<script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>
<script src="{{ asset('/assets/js/feedback.js') }}"></script>
@yield('script')

</body>
</html>