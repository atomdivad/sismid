@extends('app')
@section('content')
    <div class=""></div>
    {!! Form::open(['method' => 'POST', 'route' => 'auth.login']) !!}

    <div class="form-group">
        {!! Form::label('email', 'Email') !!}
        {!! Form::input('email', 'email', null, ['class' => 'form-control', 'autofocus', 'required']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('password', 'Senha') !!}
        {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('remember', 'Lembrar-me') !!}
        {!! Form::checkbox('remember', null, null, []) !!}
    </div>

    <button class="btn btn-success" type="submit">Login</button>
    {!! Form::close() !!}
@endsection