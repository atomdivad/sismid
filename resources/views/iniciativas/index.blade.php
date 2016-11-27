@extends('app')
@section('content')
    {!! Breadcrumbs::render('iniciativa') !!}
    <div class="row">
        <div class="col-sm-12">
            <legend><i class="glyphicon glyphicon-list"></i> Iniciativas</legend>
        </div>
    </div>

    <form name="pesquisar" id="pesquisar" action="{{ route('iniciativa.index') }}" method="GET">
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
        <div class="form-group">
            <div class="row"><div class="col-sm-6"><label for="nome">Nome</label></div></div>
            <div class="row">
                <div class="col-sm-5">
                    <input class="form-control" type="text" name="nome" id="nome" value="{{ Input::get('nome') }}"/>
                </div>
                <div class="col-sm-3">
                    <button class="btn btn-md btn-block btn-primary" type="submit" title="Pesquisar em iniciativas"><i class="glyphicon glyphicon-search"></i> Pesquisar</button>
                </div>
                <div class="col-sm-4 text-right">
                    <a class="btn btn-md btn-primary" href="{{ route('iniciativa.create') }}" title="Cadastrar nova Iniciativa"><i class="glyphicon glyphicon-plus"></i> Nova Iniciativa</a>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-sm-12 text-right">
            <strong>Exibindo {{ (($iniciativas->perPage() * $iniciativas->currentPage()) - $iniciativas->perPage())+1 }} - @if(!$iniciativas->hasMorePages()) {{ $iniciativas->total() }} @else {{ $iniciativas->count() *  $iniciativas->currentPage() }} @endif de {{ $iniciativas->total() }}</strong>
        </div>
        <div class="col-sm-12">
            @if(count($iniciativas) > 0)
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
                    @foreach($iniciativas as $iniciativa)
                        <tr>
                            <td>{{ $iniciativa->nome }}</td>
                            <td>{{ $iniciativa->nomeCidade}} / {{ $iniciativa->uf }}</td>
                            <td>{{ $iniciativa->email }}</td>
                            <td class="text-center">
                                <a class="show-modal btn btn sm btn-primary" title="Exbir iniciativia: {{ $iniciativa->nome }}" href="#" data-id="{{ $iniciativa->idIniciativa }}" data-toggle="modal" data-target="#modalInfo"><i class="glyphicon glyphicon-eye-open"></i></a>
                                <a class="btn btn sm btn-success" title="Editar iniciativia: {{ $iniciativa->nome }}" href="{{ route('iniciativa.edit', $iniciativa->idIniciativa) }}"><i class="glyphicon glyphicon-edit"></i></a>
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
            {!! $iniciativas->appends(Input::query())->render() !!}
        </div>
    </div>

    @include('iniciativas.partials.modal_show')
@endsection

@section('script')
    @parent
    <script src="{{ asset('/assets/js/cidades.js') }}"></script>
    <script src="{{ asset('/assets/js/show.iniciativa.js') }}"></script>
@stop