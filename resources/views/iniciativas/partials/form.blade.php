<div class="form-group">
    <div class="row">
        <div class="col-sm-10">
            {!! Form::label('nome', 'Nome') !!}
            {!! Form::text('nome', null, ["class" => "form-control", "autofocus", "v-model" => "iniciativa.nome"]) !!}
        </div>
        <div class="col-sm-2">
            {!! Form::label('sigla', 'Sigla') !!}
            {!! Form::text('sigla', null, ["class" => "form-control", "v-model" => "iniciativa.sigla"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('tipo_id', 'Tipo') !!}
            {!! Form::select('tipo_id', [1 => 'Programa', 2=>'Projeto', 3=>'Ação'], null, ["class" => "form-control", "v-model" => "iniciativa.tipo_id"]) !!}
        </div>

        <div class="col-sm-6">
            {!! Form::label('naturezaJuridica_id', 'Natureza Jurídica') !!}
            {!! Form::select('naturezaJuridica_id', $naturezasJuridicas, null, ["class" => "form-control", "v-model" => "iniciativa.naturezaJuridica_id"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('email', 'E-mail') !!}
            {!! Form::input('email', 'email', null, ["class" => "form-control", "v-model" => "iniciativa.email"]) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('url', 'URL') !!}
            {!! Form::input('url', 'url', null, ["class" => "form-control", "v-model" => "iniciativa.url"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('objetivo', 'Objetivo') !!}
            {!! Form::textarea('objetivo', null, ["class" => "form-control", "v-model" => "iniciativa.objetivo"]) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('informacaoComplementar', 'Informações Complementares') !!}
            {!! Form::textarea('informacaoComplementar', null, ["class" => "form-control", "v-model" => "iniciativa.informacaoComplementar"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('categoria_id', 'Categoria') !!}
            {!! Form::select('categoria_id', [1 => 'Governo Federal', 2 => 'Governo Estadual', 3 => 'Governo Municipal', 4 => 'Terceiro Setor'], null, ["class" => "form-control", "v-model" => "iniciativa.categoria_id"]) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('fonte', 'Fonte') !!}
            {!! Form::text('fonte', null, ["class" => "form-control", "v-model" => "iniciativa.fonte"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('cep', 'CEP') !!}
            {!! Form::text('cep', '78600-000', ["class" => "form-control", "v-model" => "iniciativa.endereco.cep"]) !!}
        </div>
        <div class="col-sm-4">
            {!! Form::label('logradouro', 'Logradouro') !!}
            {!! Form::text('logradouro', 'Rua 27', ["class" => "form-control", "v-model" => "iniciativa.endereco.logradouro"]) !!}
        </div>
        <div class="col-sm-2">
            {!! Form::label('numero', 'Nº') !!}
            {!! Form::text('numero', '74', ["class" => "form-control", "v-model" => "iniciativa.endereco.numero"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('complemento', 'Complemento') !!}
            {!! Form::text('complemento', null, ["class" => "form-control", "v-model" => "iniciativa.endereco.complemento"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('bairro', 'Bairro') !!}
            {!! Form::text('bairro', 'Santo Antonio', ["class" => "form-control", "v-model" => "iniciativa.endereco.bairro"]) !!}
        </div>
        <div class="col-sm-2">
            {!! Form::label('uf', 'UF') !!}
            {!! Form::select('uf', $uf, null, ["class" => "form-control", "v-model" => "iniciativa.endereco.uf"]) !!}
        </div>
        <div class="col-sm-4">
            {!! Form::label('cidade_id', 'Cidade') !!}
            {!! Form::select('cidade_id', [], null, ["class" => "form-control", "v-model" => "iniciativa.endereco.cidade_id"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-12">
            <div id="map" style="width: 100%; height: 250px;"></div>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-5">
            {!! Form::label('latitude', 'Latitude') !!}
        </div>
        <div class="col-sm-5">
            {!! Form::label('longitude', 'Longitude') !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            {!! Form::text('latitude', null, ["class" => "form-control", "readonly"]) !!}
        </div>
        <div class="col-sm-5">
            {!! Form::text('longitude', null, ["class" => "form-control", "readonly"]) !!}
        </div>
        <div class="col-sm-2">
            <button class="btn btn-sm btn-primary" id="latlngSearch" type="button"><i class="glyphicon glyphicon-search"></i> Buscar Coordenadas</button>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('localizacao', 'Localização') !!}
            {!! Form::select('localizacao_id', $localizacoes, null, ["class" => "form-control", "v-model" => "iniciativa.endereco.localizacao_id"]) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('localidade', 'Localidades') !!}
            {!! Form::select('localidade_id', $localidades, null, ["class" => "form-control", "v-model" => "iniciativa.endereco.localidade_id"]) !!}
        </div>
    </div>
</div>

{{-- Instituições Apoiadoras/Mantenedoras --}}
@include('pids.partials.modal_instituicoes')
<div class="form-group">
    <div class="row">
        <div class="col-sm-10">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="glyphicon glyphicon-list"></i> Instituições Apoiadoras/Mantenedoras</div>
                <table class="table table-responsive table-striped table-bordered"  v-show="pid.instituicoes.length > 0">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Municipio</th>
                        <th>UF</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-repeat="inst in pid.instituicoes">
                        <td>@{{  }}</td>
                        <td>@{{  }}</td>
                        <td>@{{  }}</td>
                        <td><button class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></button></td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-center" v-else><strong>Nenhuma instituição está associada</strong></div>
            </div>
        </div>
        <div class="col-sm-2 text-right">
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalIntituicoes"><i class="glyphicon glyphicon-plus"></i> Adicionar Instituição</button>
        </div>
    </div>
</div>
{{-- Fim Instituições Apoiadoras/Mantenedoras --}}

{{-- Telefones --}}
@include('partials.modal_novo_telefone')

<div class="form-group">
    <div class="row">
        <div class="col-sm-10">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="glyphicon glyphicon-phone-alt"></i> Telefones</div>
                <table class="table table-responsive table-striped table-bordered" v-show="iniciativa.telefones.length > 0">
                    <thead>
                    <tr>
                        <th>Telefone</th>
                        <th>Responsavel</th>
                        <th>Tipo Telefone</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="t in iniciativa.telefones">
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
    <script src="{{ asset('/assets/js/iniciativa.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCsOdEoVwUQhPynqvu6OeA6qC9jsVniSlE&signed_in=true&callback=initMap" async defer></script>
@stop