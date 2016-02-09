@extends('app')
@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div id="login" class="login">
        {!! Form::open(['method' => 'POST', 'route' => 'auth.login']) !!}

        <div class="form-group">
            {!! Form::label('email', 'Email') !!}
            {!! Form::input('email', 'email', null, ['class' => 'form-control', 'autofocus', 'required']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('password', 'Senha') !!}
            {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <label for="CaptchaCode">Reescreva os caracteres da imagem</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <input type="text" id="CaptchaCode" name="CaptchaCode" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <!-- show captcha image html-->
                            {!! $captchaHtml !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="form-group">
            {!! Form::label('remember', 'Lembrar-me') !!}
            {!! Form::checkbox('remember', null, null, []) !!}
        </div>

        <div class="row">
            <div class="col-sm-6">
                <button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-send"></i> Entrar</button>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('password.formPassword') }}">Esqueci minha senha</a>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
@endsection