@extends('app')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <legend><i class="glyphicon glyphicon-edit"></i> Editar PID</legend>
        </div>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    @include('partials.template_listagem')

    <div class="row" id="PID">

        {{-- Div Mensagem Alerta --}}
        <div class="col-sm-12">
            <div class="alert" v-bind:class="{ 'alert-danger':response.error, 'alert-success':!response.error }" v-show="response.show">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <div v-for="er in response.msg"><strong>@{{ er }}</strong><br/></div>
            </div>
        </div>
        {{-- Fim Div Mensagem Alerta --}}

        <div class="col-sm-12">

            @include('pids.partials.form')

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <button class="btn btn-success" type="submit" v-on:click="salvarPid($event)"><span class="glyphicon glyphicon-save"></span> Salvar</button>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a class="btn btn-default" href="{{route('pid.index')}}">Cancerlar</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection