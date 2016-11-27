<div class="form-group">
    {!! Form::label('nome', 'Nome') !!}
    {!! Form::text('nome', null, ["class" => "form-control", "autofocus", "v-model" => "instituicao.nome"]) !!}
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('email', 'E-mail') !!}
            {!! Form::input('email', 'email', null, ["class" => "form-control", "v-model" => "instituicao.email"]) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('url', 'URL') !!}
            {!! Form::input('url', 'url', null, ["class" => "form-control", "v-model" => "instituicao.url"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('naturezaJuridica_id', 'Natureza Jurídica') !!}
            {!! Form::select('naturezaJuridica_id', $naturezasJuridicas, null, ["class" => "form-control", "v-model" => "instituicao.naturezaJuridica_id"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('cep', 'CEP') !!}
            {!! Form::text('cep', null, ["class" => "form-control cep", "v-model" => "instituicao.endereco.cep"]) !!}
        </div>
        <div class="col-sm-4">
            {!! Form::label('logradouro', 'Logradouro') !!}
            {!! Form::text('logradouro', null, ["class" => "form-control", "v-model" => "instituicao.endereco.logradouro"]) !!}
        </div>
        <div class="col-sm-2">
            {!! Form::label('numero', 'Nº') !!}
            {!! Form::text('numero', null, ["class" => "form-control", "v-model" => "instituicao.endereco.numero"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('complemento', 'Complemento') !!}
            {!! Form::text('complemento', null, ["class" => "form-control", "v-model" => "instituicao.endereco.complemento"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('bairro', 'Bairro') !!}
            {!! Form::text('bairro', null, ["class" => "form-control", "v-model" => "instituicao.endereco.bairro"]) !!}
        </div>
        <div class="col-sm-2">
            {!! Form::label('uf', 'UF') !!}
            {!! Form::select('uf', $uf, null, ["class" => "form-control", "v-model" => "instituicao.endereco.uf"]) !!}
        </div>
        <div class="col-sm-4">
            {!! Form::label('cidade_id', 'Cidade ') !!} <i class="fa fa-refresh fa-spin" id="cidadeLoading"></i>
            {!! Form::select('cidade_id', [], null, ["class" => "form-control", "v-model" => "instituicao.endereco.cidade_id"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('localizacao', 'Localização') !!}
            {!! Form::select('localizacao_id', $localizacoes, null, ["class" => "form-control", "v-model" => "instituicao.endereco.localizacao_id"]) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('localidade', 'Localidades') !!}
            {!! Form::select('localidade_id', $localidades, null, ["class" => "form-control", "v-model" => "instituicao.endereco.localidade_id"]) !!}
        </div>
    </div>
</div>

{{-- Telefones --}}
<div class="form-group">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-6">
                            <i class="glyphicon glyphicon-phone-alt"></i> Telefones
                        </div>
                        <div class="col-sm-6 text-right">
                            <button class="btn btn-xs btn-primary" v-on:click="cadastrarTelefone($event)"><i class="glyphicon glyphicon-plus"></i> Telefone</button>
                        </div>
                    </div>
                </div>
                <table class="table table-responsive table-striped table-bordered" v-show="instituicao.telefones.length > 0">
                    <thead>
                    <tr>
                        <th>Telefone</th>
                        <th>Responsavel</th>
                        <th>Tipo Telefone</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="t in instituicao.telefones">
                        <td><input type="text" class="form-control telefone" v-model="t.telefone"/></td>
                        <td><input type="text" class="form-control" v-model="t.responsavel"/></td>
                        <td>
                            <select name="telefoneTipo_id" class="form-control" v-model="t.telefoneTipo_id">
                                @foreach($telefoneTipos as $index => $tipo)
                                    <option value="{{ $index }}">{{ $tipo }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><button class="btn btn-sm btn-danger" title="Remover Telefone" v-on:click="removerTelefone($event, $index)"><i class="glyphicon glyphicon-trash"></i></button></td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-center" v-else><strong>Nenhum telefone cadastrado</strong></div>
            </div>
        </div>

        {{--<div class="col-sm-2 text-right">
            <button class="btn btn-sm btn-primary" v-on:click="cadastrarTelefone($event)"><i class="glyphicon glyphicon-plus"></i> Cadastrar Telefone</button>
        </div>--}}
    </div>
</div>

{{-- Fim Telefones --}}

@section('script')
    @parent
    <script src="{{ asset('/assets/js/cidades.js') }}"></script>
    <script src="{{ asset('/assets/js/instituicao.js') }}"></script>
    <script src="{{ asset('/assets/js/masks.js') }}"></script>
@stop