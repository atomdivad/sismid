@extends('app')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <legend><i class="glyphicon glyphicon-edit"></i> Editar Iniciativa</legend>
        </div>
    </div>

    @include('errors.list')

    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    @include('partials.template_listagem')

    <div class="row" id="iniciativa">

        {{-- Div Mensagem Alerta --}}
        <div class="col-sm-12"  v-show="response.show">
            <div class="alert" v-bind:class="{ 'alert-danger':response.error, 'alert-success':!response.error }">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <div v-for="er in response.msg"><strong>@{{ er }} </strong><br/></div>
            </div>
        </div>
        {{-- Fim Div Mensagem Alerta --}}

        <div class="col-sm-12">
            @include('iniciativas.partials.form')
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <button class="btn btn-success" type="submit" v-on:click="salvarIniciativa($event)"><span class="glyphicon glyphicon-save"></span> Salvar</button>
                    </div>
                    <div class="col-sm-6 text-right">
                        @is('admin')
                            <a class="btn btn-default" href="{{route('iniciativa.index')}}">Cancerlar</a>
                        @endis
                        @is('gestor')
                            <a class="btn btn-default" href="{{route('home')}}">Cancerlar</a>
                        @endis
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection