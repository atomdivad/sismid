@extends('app')
@section('content')
@is('admin')
    <h3>Administrador</h3>
@endis
@is('gestor')
    <h3>Usuario Gestor</h3>
@endis
Bem vindo {{ Auth::user()->present()->nomeCompleto }}!

@endsection