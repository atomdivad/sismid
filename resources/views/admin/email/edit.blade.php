@extends('app')
@section('content')
    {!! Breadcrumbs::render('emailEdit') !!}
    <div class="row">
        <div class="col-sm-12">
            <legend><i class="glyphicon glyphicon-edit"></i> Editar Email</legend>
        </div>
    </div>

    @include('errors.list')

    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <div class="row" id="email">


        <div class="col-sm-12">
            {!! Form::model($email[0],['route'=>['admin.email.update',$email[0]->id],'method'=>'post']) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('email', 'E-mail') !!}
                        {!! Form::input('email', 'email', null, ["class" => "form-control", "required"]) !!}
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-save"></span> Salvar</button>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a class="btn btn-default" href="{{route('admin.email.index')}}">Cancerlar</a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection