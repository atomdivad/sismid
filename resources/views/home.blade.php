@extends('app')
@section('content')
    {!! Breadcrumbs::render('home') !!}
    <h3>Bem vindo {{ Auth::user()->present()->nomeCompleto }}!</h3>
@is('admin')
    <h5>Administrador</h5>
@endis
@is('gestor')
    <h5>Usuario Gestor</h5>
@endis

@endsection