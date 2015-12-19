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
            {!! Form::text('cep', '78600-000', ["class" => "form-control", "v-model" => "instituicao.endereco.cep"]) !!}
        </div>
        <div class="col-sm-4">
            {!! Form::label('logradouro', 'Logradouro') !!}
            {!! Form::text('logradouro', 'Rua 27', ["class" => "form-control", "v-model" => "instituicao.endereco.logradouro"]) !!}
        </div>
        <div class="col-sm-2">
            {!! Form::label('numero', 'Nº') !!}
            {!! Form::text('numero', '74', ["class" => "form-control", "v-model" => "instituicao.endereco.numero"]) !!}
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
            {!! Form::text('bairro', 'Santo Antonio', ["class" => "form-control", "v-model" => "instituicao.endereco.bairro"]) !!}
        </div>
        <div class="col-sm-2">
            {!! Form::label('uf', 'UF') !!}
            {!! Form::select('uf', $uf, null, ["class" => "form-control", "v-model" => "instituicao.endereco.uf"]) !!}
        </div>
        <div class="col-sm-4">
            {!! Form::label('cidade_id', 'Cidade') !!}
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
@include('partials.modal_novo_telefone')

<div class="form-group">
    <div class="row">
        <div class="col-sm-10">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="glyphicon glyphicon-phone-alt"></i> Telefones</div>
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
                        <td>@{{ t.telefone }}</td>
                        <td>@{{ t.responsavel }}</td>
                        <td>@{{ t.telefoneTipo_id }}</td>
                        <td><button class="btn btn-sm btn-danger" title="Remover Telefone" v-on:click="removerTelefone($event, $index)"><i class="glyphicon glyphicon-trash"></i></button></td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-center" v-else><strong>Nenhum telefone cadastrado</strong></div>
            </div>
        </div>

        <div class="col-sm-2 text-right">
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#novoTelefone"><i class="glyphicon glyphicon-plus"></i> Cadastrar Telefone</button>
        </div>
    </div>
</div>
{{-- Fim Telefones --}}

@section('script')
    @parent
    <script src="{{ asset('/assets/js/cidades.js') }}"></script>
    <script src="{{ asset('/assets/js/instituicao.js') }}"></script>
@stop