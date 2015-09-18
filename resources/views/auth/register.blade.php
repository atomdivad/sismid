@extends('app')
@section('content')
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

    <button class="btn btn-success" type="submit">Registrar</button>
    {!! Form::close() !!}
@endsection