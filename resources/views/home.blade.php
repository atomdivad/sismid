@extends('app')
@section('content')
@is('admin')
    <h3>Administrador</h3>
@endis
@is('A2')
    <h3>Usuario</h3>
@endis
{{ Auth::user()->present()->nomeCompleto }}
@endsection