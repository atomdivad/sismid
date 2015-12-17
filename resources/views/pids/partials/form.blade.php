<div class="form-group">
    {!! Form::label('nome', 'Nome') !!}
    {!! Form::text('nome', null, ["class" => "form-control", "autofocus"]) !!}
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('email', 'E-mail') !!}
            {!! Form::input('email', 'email', null, ["class" => "form-control"]) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('url', 'URL') !!}
            {!! Form::input('url', 'url', null, ["class" => "form-control"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('tipo', 'Tipo') !!}
            {!! Form::text('tipo', null, ["class" => "form-control"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('cep', 'CEP') !!}
            {!! Form::text('cep', '78600-000', ["class" => "form-control"]) !!}
        </div>
        <div class="col-sm-4">
            {!! Form::label('logradouro', 'Logradouro') !!}
            {!! Form::text('logradouro', 'Rua 27', ["class" => "form-control"]) !!}
        </div>
        <div class="col-sm-2">
            {!! Form::label('numero', 'Nº') !!}
            {!! Form::text('numero', '74', ["class" => "form-control"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('complemento', 'Complemento') !!}
            {!! Form::text('complemento', null, ["class" => "form-control"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('bairro', 'Bairro') !!}
            {!! Form::text('bairro', 'Santo Antonio', ["class" => "form-control"]) !!}
        </div>
        <div class="col-sm-2">
            {!! Form::label('uf', 'UF') !!}
            {!! Form::select('uf', $uf, null, ["class" => "form-control"]) !!}
        </div>
        <div class="col-sm-4">
            {!! Form::label('cidade_id', 'Cidade') !!}
            {!! Form::select('cidade_id', [], null, ["class" => "form-control"]) !!}
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
            {!! Form::select('localizacao_id', $localizacoes, null, ["class" => "form-control"]) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('localidade', 'Localidades') !!}
            {!! Form::select('localidade_id', $localidades, null, ["class" => "form-control"]) !!}
        </div>
    </div>
</div>

{{-- Telefones --}}
@include('pids.partials.modal_novo_telefone')

<div class="form-group">
    <div class="row">
        <div class="col-sm-10">
            <div class="panel panel-primary">
                <div class="panel-heading"><i class="glyphicon glyphicon-phone-alt"></i> Telefones</div>
                <table class="table table-responsive table-striped table-bordered" v-show="pid.telefones.length > 0">
                    <thead>
                    <tr>
                        <th>Telefone</th>
                        <th>Responsavel</th>
                        <th>Tipo Telefone</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="t in pid.telefones">
                        <td>@{{ t.telefone }}</td>
                        <td>@{{ t.responsavel }}</td>
                        <td>@{{ t.tipoTelefone_id }}</td>
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

{{-- Instituicoes Responsaveis --}}
@include('pids.partials.modal_instituicoes')
<div class="form-group">
    <div class="row">
        <div class="col-sm-10">
            <div class="panel panel-primary">
                <div class="panel-heading"><i class="glyphicon glyphicon-list"></i> Instituições Responsaveis</div>
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
                <div class="text-center" v-else><strong>Nenhuma instituição está associada ao Ponto de Inclusão Digital</strong></div>
            </div>
        </div>
        <div class="col-sm-2 text-right">
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalIntituicoes"><i class="glyphicon glyphicon-plus"></i> Adicionar Instituição</button>
        </div>
    </div>
</div>
{{-- Fim Instituiçoes respoensaveis --}}

{{-- Iniciativas Vinculadas --}}
<div class="form-group">
    <div class="row">
        <div class="col-sm-10">
            <div class="panel panel-primary">
                <div class="panel-heading"><i class="glyphicon glyphicon-list"></i> Iniciativas Vinculadas</div>
                <table class="table table-responsive table-striped table-bordered" v-if="pid.iniciativas.length > 0">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Municipio</th>
                        <th>UF</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-repeat="iniciativa in pid.iniciativas">
                        <td>@{{  }}</td>
                        <td>@{{  }}</td>
                        <td>@{{  }}</td>
                        <td><button class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></button></td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-center" v-else><strong>Nenhuma iniciativa está associada ao Ponto de Inclusão Digital</strong></div>
            </div>
        </div>
        <div class="col-sm-2 text-right">
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#"><i class="glyphicon glyphicon-plus"></i> Vincular Iniciativa</button>
        </div>
    </div>
</div>
{{-- Fim Iniciativas Vinculadas --}}

@section('script')
    @parent
<script src="{{ asset('/assets/js/pid.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCsOdEoVwUQhPynqvu6OeA6qC9jsVniSlE&signed_in=true&callback=initMap" async defer></script>
@stop
