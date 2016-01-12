@extends('app')
@section('content')
    {!! Breadcrumbs::render('instituicao') !!}
    <div class="row">
        <div class="col-sm-12">
            <legend><i class="glyphicon glyphicon-list"></i> Instituição</legend>
        </div>
    </div>

    <form name="pesquisar" id="pesquisar" action="{{ route('instituicao.index') }}" method="GET">
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
                    <button class="btn btn-md btn-block btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i> Pesquisar</button>
                </div>
                <div class="col-sm-4 text-right">
                    <a class="btn btn-md btn-primary" href="{{ route('instituicao.create') }}"><i class="glyphicon glyphicon-plus"></i> Nova Instituicao</a>
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-sm-12">
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
                @foreach($instituicoes as $instituicao)
                    <tr>
                        <td>{{ $instituicao->nome }}</td>
                        <td>{{ $instituicao->nomeCidade}} / {{ $instituicao->uf }}</td>
                        <td>{{ $instituicao->email }}</td>
                        <td class="text-center">
                            <a class="btn btn sm btn-primary" title="Exbir instituição: {{ $instituicao->nome }}" href="{{ route('instituicao.show', $instituicao->idInstituicao) }}"><i class="glyphicon glyphicon-eye-open"></i></a>
                            <a class="btn btn sm btn-success" title="Editar instituição: {{ $instituicao->nome }}" href="{{ route('instituicao.edit', $instituicao->idInstituicao) }}"><i class="glyphicon glyphicon-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    @parent
    <script src="{{ asset('/assets/js/cidades.js') }}"></script>
@stop