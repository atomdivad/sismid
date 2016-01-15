@extends('app')
@section('content')
    {!! Breadcrumbs::render('endContatoEditTelefone') !!}
    <div class="row">
        <div class="col-sm-12">
            <legend><i class="glyphicon glyphicon-edit"></i> Editar Telefone</legend>
        </div>
    </div>

    @include('errors.list')

    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <div class="row" id="endContato">


        <div class="col-sm-12">
            {!! Form::model($dados[0],['route'=>['admin.endContato.updateTelefone',$dados[0]->id],'method'=>'post']) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('telefone', 'Telefone') !!}
                        {!! Form::input('telefone', 'telefone', null, ["class" => "form-control telefone", "required"]) !!}
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-save"></span> Salvar</button>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a class="btn btn-default" href="{{route('admin.endContato.index')}}">Cancerlar</a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@section('script')
    @parent
    <script src="{{ asset('/assets/js/masks.js') }}"></script>
@stop