<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISMID</title>

    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/assets/css/bootstrap-theme.min.css') }}" rel="stylesheet">

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
            <a class="navbar-brand" href="/">SisMid</a>
        </div>

        @if(!Auth::guest())
            <div class="collapse navbar-collapse navbar-ex1-collapse" id="navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Cadastrar <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('pid.create') }}">Cadastrar PID</a></li>
                            <li><a href="#">Sub-menu 2</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown" role="menuitem">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">Sua Conta <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('auth.logout') }}">Sair</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        @else
            <div class="collapse navbar-collapse navbar-ex1-collapse" id="navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ route('auth.formLogin') }}">Entrar</a></li>
                    <li><a href="{{ route('auth.formRegister') }}">Cadastrar-se</a></li>
                </ul>
            </div>
        @endif
    </div>
</nav>

<div class="container" style="padding-top:70px;">
    @include('errors.list')
    @yield('content')
</div>

<hr/>
<footer>
    &copy;
</footer>

<script src="{{ asset('/assets/js/jquery-1.11.3.js') }}"></script>
<script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
@yield('script')

</body>
</html>