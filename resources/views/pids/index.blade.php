@extends('app')
@section('content')
    {!! Breadcrumbs::render('pid') !!}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="row">
        <div class="col-sm-12">
            <legend><i class="glyphicon glyphicon-list"></i> Pontos de Inclusão Digital</legend>
        </div>
    </div>

    <form name="pesquisar" id="pesquisar" action="{{ route('pid.index') }}" method="GET">
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="uf">UF</label>
                    <select name="uf" id="uf" class="form-control">
                        <option value="0">Todos UF</option>
                        @foreach($ufs as $index => $u)
                            @if(Input::get('uf') == $index)
                                <option selected value="{{ $index }}">{{ $u }}</option>
                            @else
                                <option value="{{ $index }}">{{ $u }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="col-sm-5">
                <div class="form-group">
                    <label for="cidade_id">Município</label>
                    <select name="cidade_id" id="cidade_id" class="form-control" data-selected="{{ Input::get('cidade_id') }}"></select>
                </div>
            </div>
        </div>
        @is('admin')
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-8">
                        <label for="iniciativa">Iniciativa</label>
                        <select name="iniciativa[]" id="iniciativa" class="form-control" multiple="multiple">
                            @if(in_array(0, $selected))
                                <option selected value="0">Qualquer Iniciativa</option>
                            @else
                                <option value="0">Qualquer Iniciativa</option>
                            @endif
                            @foreach($iniciativas as $index => $ini)
                                @if(in_array($index, $selected))
                                    <option selected value="{{ $index }}">{{ $ini}}</option>
                                @else
                                    <option value="{{ $index }}">{{ $ini }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endis

        <div class="form-group">
            <div class="row">
                <div class="col-sm-5">
                    <label for="nome">Nome</label>
                    <input class="form-control" type="text" name="nome" id="nome" value="{{ Input::get('nome') }}"/>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row"><div class="col-sm-6"><label for="ativo">Buscar</label></div></div>
            <div class="row">
                <div class="col-sm-3">
                    <select name="ativo" id="ativo" class="form-control">
                        <option {{ (Input::get('ativo') == 1)? 'selected' : '' }} value="1">Ativos</option>
                        <option {{ (Input::get('ativo') == 2)? 'selected' : '' }} value="2">Desativados</option>
                        <option {{ (Input::get('ativo') == 3)? 'selected' : '' }} value="3">Todos</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <button class="btn btn-md btn-block btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i> Pesquisar</button>
                </div>
                <div class="col-sm-4 text-right">
                    <a class="btn btn-md btn-primary" href="{{ route('pid.create') }}"><i class="glyphicon glyphicon-plus"></i> Novo PID</a>
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-sm-12">
            @if(count($pids))
                <table class="table table-responsive table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Município / UF</th>
                        <th>E-mail</th>
                        <th colspan="2"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pids as $pid)
                        <tr>
                            <td class="col-md-3">{{ $pid->nome }}</td>
                            <td class="col-md-1">{{ $pid->nomeCidade}} / {{ $pid->uf }}</td>
                            <td class="col-md-1">{{ $pid->email }}</td>
                            <td class="col-md-1 text-center">
                                @if($pid->ativo)
                                    <button class="btn btn-sm btn-danger pidAtivo" data-id="{{ $pid->idPid }}"><i id="pidAtivoBtn" class="fa fa-close"></i> Desativar</button>
                                @else
                                    <button class="btn btn-sm btn-info pidAtivo" data-id="{{ $pid->idPid }}"><i id="pidAtivoBtn" class="fa fa-check"></i> Ativar</button>
                                @endif
                            </td>
                            <td class="col-md-1 text-center">
                                <a class="show-modal btn btn-sm btn-primary" title="Exbir PID: {{ $pid->nome }}" href="#" data-id="{{ $pid->idPid }}" data-toggle="modal" data-target="#modalInfo"><i class="glyphicon glyphicon-eye-open"></i></a>
                                <a class="btn btn sm btn-success" title="Editar PID: {{ $pid->nome }}" href="{{ route('pid.edit', $pid->idPid) }}"><i class="glyphicon glyphicon-edit"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info"><strong>Nenhuma informação encontrada!</strong></div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            {!! $pids->appends(Input::query())->render() !!}
        </div>
    </div>

    @include('pids.partials.modal_show')
@endsection
@section('script')
    @parent
    <script src="{{ asset('/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('/assets/js/cidades.js') }}"></script>
    <script src="{{ asset('/assets/js/show.pid.js') }}"></script>
@endsection
@section('css')
    <link href="{{ asset('/assets/css/select2.min.css') }}" rel="stylesheet">
@stop