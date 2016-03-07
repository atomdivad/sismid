<div class="row">
    <div class="col-sm-12">
        <div class="well well-sm">
            <small>Os campos com <b>*</b> são de preenchimento obrigatório.</small>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-10">
            {!! Form::label('nome', 'Nome*') !!}
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
            {!! Form::label('tipo_id', 'Iniciativas de Inclusão Digital*') !!}
            {!! Form::select('tipo_id', [1 => 'Programa', 2=>'Projeto', 3=>'Ação'], null, ["class" => "form-control", "v-model" => "iniciativa.tipo_id"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('email', 'E-mail*') !!}
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
            {!! Form::textarea('objetivo', null, ['rows' => '3',"class" => "form-control", "v-model" => "iniciativa.objetivo"]) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('informacaoComplementar', 'Informações Complementares') !!}
            {!! Form::textarea('informacaoComplementar', null, ['rows' => '3',"class" => "form-control", "v-model" => "iniciativa.informacaoComplementar"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('categoria_id', 'Categoria*') !!}
            {!! Form::select('categoria_id', [1 => 'Governo Federal', 2 => 'Governo Estadual', 3 => 'Governo Municipal', 4 => 'Terceiro Setor'], null, ["class" => "form-control", "v-model" => "iniciativa.categoria_id"]) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('fonte', 'Fonte*') !!}
            {!! Form::text('fonte', null, ["class" => "form-control", "v-model" => "iniciativa.fonte"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-2">
            {!! Form::label('cep', 'CEP') !!}
            {!! Form::text('cep', null, ["class" => "form-control cep", "v-model" => "iniciativa.endereco.cep"]) !!}
        </div>
        <div class="col-sm-4">
            {!! Form::label('logradouro', 'Logradouro*') !!}
            {!! Form::text('logradouro', null, ["class" => "form-control", "v-model" => "iniciativa.endereco.logradouro"]) !!}
        </div>
        <div class="col-sm-2">
            {!! Form::label('numero', 'Nº') !!}
            {!! Form::text('numero', null, ["class" => "form-control", "v-model" => "iniciativa.endereco.numero"]) !!}
        </div>
        <div class="col-sm-4">
            {!! Form::label('complemento', 'Complemento') !!}
            {!! Form::text('complemento', null, ["class" => "form-control", "v-model" => "iniciativa.endereco.complemento"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">

    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('bairro', 'Bairro*') !!}
            {!! Form::text('bairro', null, ["class" => "form-control", "v-model" => "iniciativa.endereco.bairro"]) !!}
        </div>
        <div class="col-sm-2">
            {!! Form::label('uf', 'UF*') !!}
            {!! Form::select('uf', $uf, null, ["class" => "form-control", "v-model" => "iniciativa.endereco.uf"]) !!}
        </div>
        <div class="col-sm-4">
            {!! Form::label('cidade_id', 'Cidade*') !!}
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
            {!! Form::text('latitude', null, ["class" => "form-control", "readonly", "v-model" => "iniciativa.endereco.latitude"]) !!}
        </div>
        <div class="col-sm-5">
            {!! Form::text('longitude', null, ["class" => "form-control", "readonly", "v-model" => "iniciativa.endereco.longitude"]) !!}
        </div>
        <div class="col-sm-2">
            <button class="btn btn-sm btn-primary" id="latlngSearch" type="button"><i class="glyphicon glyphicon-search"></i> Buscar Coordenadas</button>
        </div>
    </div>
</div>

{{-- Instituições Apoiadoras/Mantenedoras --}}
@include('iniciativas.partials.modal_instituicoes')
<div class="form-group">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-6"><i class="glyphicon glyphicon-list"></i> Instituições Apoiadoras/Mantenedoras</div>
                        <div class="col-sm-6 text-right">
                            <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalIntituicoes"><i class="glyphicon glyphicon-plus"></i> Instituição</button>
                        </div>
                    </div>
                </div>
                <table class="table table-responsive table-striped table-bordered"  v-show="iniciativa.instituicoes.length > 0">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Municipio</th>
                        <th>UF</th>
                        <th>Tipo Vínculo</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="i in iniciativa.instituicoes">
                        <td>@{{ i.nome }}</td>
                        <td>@{{ i.nomeCidade }}</td>
                        <td>@{{ i.uf }}</td>
                        <td>
                            <select name="tipoVinculo" id="tipoVinculo" class="form-control" v-model="i.tipoVinculo" required="required">
                                <option value="0">Selecione</option>
                                <option value="1">Apoiador</option>
                                <option value="2">Mantenendor</option>
                            </select>
                        </td>
                        <td><button class="btn btn-sm btn-danger" v-on:click="removerInstituicao($event, $index)"><i class="glyphicon glyphicon-trash"></i></button></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- Fim Instituições Apoiadoras/Mantenedoras --}}

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
    </div>
</div>
{{-- Fim Telefones --}}

{{-- Dimensoes --}}
<div class="form-group">
    <div class="panel panel-default">
        <div class="panel-heading"><i class="glyphicon glyphicon-list"></i> Dimensões de Inclusão Digital</div>
        <div class="panel-body">
            <div class="row">
                @foreach($dimensoes as $index => $dimensao)
                    <div class="col-sm-4">
                        <input type="checkbox" name="{{ $dimensao }}" value="{{ $index }}" v-model="iniciativa.dimensoes"/> {{ $dimensao }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
{{-- Fim Dimensoes --}}

@section('script')
    @parent
    <script src="{{ asset('/assets/js/cidades.js') }}"></script>
    <script src="{{ asset('/assets/js/component-listagem.js') }}"></script>
    <script src="{{ asset('/assets/js/iniciativa.js') }}"></script>
    <script src="{{ asset('/assets/js/masks.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCsOdEoVwUQhPynqvu6OeA6qC9jsVniSlE&signed_in=true&callback=initMap" async defer></script>
@stop