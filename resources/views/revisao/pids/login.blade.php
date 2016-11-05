@extends('app')
@section('content')
    {{ \Carbon\Carbon::setLocale('pt') }}

    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    {!! Breadcrumbs::render('pidReview') !!}


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
        {!! Form::open(['method' => 'POST', 'route' => 'review.pid.logar']) !!}

        <div class="form-group">
            {!! Form::label('email', 'Email') !!}
            {!! Form::input('email', 'email', null, ['class' => 'form-control', 'autofocus', 'required']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('password', 'Senha') !!}
            {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
        </div>

        <div class="row">
            <div class="col-sm-6">
                <button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-send"></i> Entrar</button>
            </div>
        </div>

        {!! Form::close() !!}
    </div>

@endsection
@section('script')
    @parent

@endsection