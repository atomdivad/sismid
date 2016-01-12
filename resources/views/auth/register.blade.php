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

    {!! Form::open(['method' => 'POST', 'route' => 'auth.register']) !!}

    <div class="form-group">
        {!! Form::label('nome', 'Nome') !!}
        {!! Form::text('nome', null, ['class' => 'form-control']) !!}
        {!! Form::label('sobrenome', 'Sobrenome') !!}
        {!! Form::text('sobrenome', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('email', 'Email') !!}
        {!! Form::input('email', 'email', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('password', 'Senha') !!}
        {!! Form::password('password', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('password_confirmation', 'Confirme a senha') !!}
        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
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

    <button class="btn btn-success" type="submit">Registrar</button>
    {!! Form::close() !!}
@endsection