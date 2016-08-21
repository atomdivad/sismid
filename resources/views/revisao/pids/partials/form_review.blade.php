<div class="form-group">
    {!! Form::label('nome', 'Nome') !!} <span class="label label-info">@{{ pidOriginal.nome }}</span>
    {!! Form::text('nome', null, ["class" => "form-control", "autofocus", 'v-model' => 'pid.nome']) !!}
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('email', 'E-mail') !!} <span class="label label-info">@{{ pidOriginal.email }}</span>
            {!! Form::input('email', 'email', null, ["class" => "form-control", 'v-model' => 'pid.email']) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('url', 'URL') !!}  <span class="label label-info">@{{ pidOriginal.url }}</span>
            {!! Form::input('url', 'url', null, ["class" => "form-control", 'v-model' => 'pid.url']) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('tipo_id', 'Tipo') !!} <span class="label label-info">@{{ pidOriginal.tipo }}</span>
            {!! Form::select('tipo_id', $pidTipos, null, ["class" => "form-control", 'v-model' => 'pid.tipo_id']) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('destaque', 'Prêmiado/Destaque') !!} <span class="label label-info">@{{ pidOriginal.destaque }}</span>
            <input type="checkbox" name="destaque" class="form-control" v-model="pid.destaque"/>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('cep', 'CEP') !!} <span class="label label-info">@{{ pidOriginal.endereco.cep }}</span>
            {!! Form::text('cep', null, ["class" => "form-control cep", 'v-model' => 'pid.endereco.cep']) !!}
        </div>
        <div class="col-sm-4">
            {!! Form::label('logradouro', 'Logradouro') !!} <span class="label label-info">@{{ pidOriginal.endereco.logradouro }}</span>
            {!! Form::text('logradouro', null, ["class" => "form-control", 'v-model' => 'pid.endereco.logradouro']) !!}
        </div>
        <div class="col-sm-2">
            {!! Form::label('numero', 'Nº') !!} <span class="label label-info">@{{ pidOriginal.endereco.numero }}</span>
            {!! Form::text('numero', null, ["class" => "form-control", 'v-model' => 'pid.endereco.numero']) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('complemento', 'Complemento') !!} <span class="label label-info">@{{ pidOriginal.endereco.complemento }}</span>
            {!! Form::text('complemento', null, ["class" => "form-control", 'v-model' => 'pid.endereco.complemento']) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('bairro', 'Bairro') !!} <span class="label label-info">@{{ pidOriginal.endereco.bairro }}</span>
            {!! Form::text('bairro', null, ["class" => "form-control", 'v-model' => 'pid.endereco.bairro']) !!}
        </div>
        <div class="col-sm-2">
            {!! Form::label('uf', 'UF') !!} <span class="label label-info">@{{ pidOriginal.endereco.uf }}</span>
            {!! Form::select('uf', $uf, $json['endereco']['uf'], ["class" => "form-control"]) !!}
        </div>
        <div class="col-sm-4">
            {!! Form::label('cidade_id', 'Cidade') !!} <span class="label label-info">@{{ pidOriginal.endereco.cidade }}</span>
            {!! Form::select('cidade_id', [], null, ["class" => "form-control", 'v-model' => 'pid.endereco.cidade_id']) !!}
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
            {!! Form::label('latitude', 'Latitude') !!}  <span class="label label-info">@{{ pidOriginal.endereco.latitude }}</span>
        </div>
        <div class="col-sm-5">
            {!! Form::label('longitude', 'Longitude') !!}  <span class="label label-info">@{{ pidOriginal.endereco.longitude }}</span>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            {!! Form::text('latitude', null, ["class" => "form-control", "readonly", 'v-model' => 'pid.endereco.latitude']) !!}
        </div>
        <div class="col-sm-5">
            {!! Form::text('longitude', null, ["class" => "form-control", "readonly", 'v-model' => 'pid.endereco.longitude']) !!}
        </div>
        <div class="col-sm-2">
            <button class="btn btn-sm btn-primary" id="latlngSearch" type="button" title="Buscar coordenadas do endereço"><i class="glyphicon glyphicon-search"></i> Buscar Coordenadas</button>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('localizacao', 'Localização') !!}  <span class="label label-info">@{{ pidOriginal.endereco.localizacao }}</span>
            {!! Form::select('localizacao_id', $localizacoes, null, ["class" => "form-control", 'v-model' => 'pid.endereco.localizacao_id']) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('localidade', 'Localidades') !!}  <span class="label label-info">@{{ pidOriginal.endereco.localidade }}</span>
            {!! Form::select('localidade_id', $localidades, null, ["class" => "form-control", 'v-model' => 'pid.endereco.localidade_id']) !!}
        </div>
    </div>
</div>

{{-- Telefones --}}
<div class="form-group">
    <div class="row">
        <div class="col-sm-7">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-6">
                            <i class="glyphicon glyphicon-phone-alt"></i> Telefones
                        </div>
                        <div class="col-sm-6 text-right">
                            <button class="btn btn-xs btn-primary" v-on:click="cadastrarTelefone($event)" title="Cadastrar Telelcone"><i class="glyphicon glyphicon-plus"></i> Telefone</button>
                        </div>
                    </div>
                </div>
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
                        <td><input type="text" class="form-control telefone" v-model="t.telefone"/></td>
                        <td><input type="text" class="form-control" v-model="t.responsavel"/></td>
                        <td>
                            <select name="telefoneTipo_id" class="form-control" v-model="t.telefoneTipo_id">
                                @foreach($telefoneTipos as $index => $tipo)
                                    <option value="{{ $index }}">{{ $tipo }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><button class="btn btn-sm btn-danger" title="Remover Telefone" v-on:click="removerTelefone($event, $index)" title="Remover Telefone"><i class="glyphicon glyphicon-trash"></i></button></td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-center" v-else><strong>Nenhum telefone cadastrado</strong></div>
            </div>
        </div>
        <div class="col-sm-5">
            <div v-for="i in pid.telefones">
                <span class="label label-info">@{{ i.telefone }} @{{ i.responsavel }}</span>
            </div>
        </div>
    </div>
</div>
{{-- Fim Telefones --}}

{{-- Instituições Responsaveis --}}
@include('pids.partials.modal_instituicoes')
<div class="form-group">
    <div class="row">
        <div class="col-sm-7">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-6"><i class="glyphicon glyphicon-list"></i> Instituições Responsaveis</div>
                        <div class="col-sm-6 text-right">
                            <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalIntituicoes" title="Adicionar Instituição"><i class="glyphicon glyphicon-plus"></i> Instituição</button>
                        </div>
                    </div>
                </div>
                <table class="table table-responsive table-striped table-bordered"  v-show="pid.instituicoes.length > 0">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Municipio</th>
                        <th>UF</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="i in pid.instituicoes">
                        <td>@{{ i.nome }}</td>
                        <td>@{{ i.nomeCidade }}</td>
                        <td>@{{ i.uf }}</td>
                        <td><button class="btn btn-sm btn-danger" v-on:click="removerInstituicao($event, $index)" title="Remover Instituição"><i class="glyphicon glyphicon-trash"></i></button></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-sm-5">
            <div v-for="i in pidOriginal.instituicoes">
                <span class="label label-info">@{{ i.nome }} - @{{ i.nomeCidade }} - @{{ i.uf }}</span>
            </div>
        </div>
    </div>
</div>
{{-- Fim Instituições Responsaveis --}}

{{-- Iniciativas Vinculadas --}}
@include('pids.partials.modal_iniciativas')
<div class="form-group">
    <div class="row">
        {{-- Iniciativas vinculadas revisao--}}
        <div class="col-sm-7">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-6"><i class="glyphicon glyphicon-list"></i> Iniciativas Vinculadas</div>
                        <div class="col-sm-6 text-right">
                            <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalIniciativas" title="Adicionar Iniciativa"><i class="glyphicon glyphicon-plus"></i> Iniciativas</button>
                        </div>
                    </div>
                </div>
                <table class="table table-responsive table-striped table-bordered"  v-show="pid.iniciativas.length > 0">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Municipio</th>
                        <th>UF</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="i in pid.iniciativas">
                        <td>@{{ i.nome }}</td>
                        <td>@{{ i.nomeCidade }}</td>
                        <td>@{{ i.uf }}</td>
                        <td><button class="btn btn-sm btn-danger" v-on:click="removerIniciativa($event, $index)" title="Remover Iniciativa"><i class="glyphicon glyphicon-trash"></i></button></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Iniciativas ja vinculadas --}}
        <div class="col-sm-5">
            <div v-for="i in pidOriginal.iniciativas">
                <span class="label label-info">@{{ i.nome }} - @{{ i.nomeCidade }} - @{{ i.uf }}</span>
            </div>
        </div>
    </div>
</div>
{{-- Fim Iniciativas Vinculadas --}}

{{-- Servicos --}}
<div v-for="i in pid.servicos">
    <span class="label label-info">@{{ i }}</span>
</div>
<div class="form-group">
    <div class="panel panel-default">
        <div class="panel-heading"><i class="glyphicon glyphicon-list"></i> Servicos</div>
        <div class="panel-body">
            <div class="row">
                @foreach($servicos as $index => $servico)
                    <div class="col-sm-6">
                        <input type="checkbox" name="{{ $servico }}" value="{{ $index }}" v-model="pid.servicos"/> {{ $servico }}
                        {{--@if($index == 23)
                            <input type="text" class="form-control input-sm" placeholder="Especifique"/>
                        @endif--}}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
{{-- Fim Servicos --}}

{{-- Fotos --}}
@include('pids.partials.modal_fotos')
<div class="form-group" v-show="pid.idPid != null">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-6" v-show="pid.fotos.length < 10"><i class="glyphicon glyphicon-picture"></i> Fotos</div>
                        <div class="col-sm-6 text-right">
                            <button class="btn btn-xs btn-primary"  data-toggle="modal" data-target="#modalFotos"><i class="glyphicon glyphicon-plus"></i> Fotos</button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row" v-show="pid.fotos.length > 0">
                        <div class="col-xs-6 col-md-3" v-for="foto in pid.fotos">
                            <div class="thumbnail">
                                <button type="button" id="removeFoto-@{{ $index }}" class="close" aria-label="Remover" v-on:click="removerFoto($event, $index)"><span>&times;</span></button>
                                <img src="/pid/@{{ pid.idPid }}/fotos/@{{ foto.nome }}" alt="@{{ foto.nome }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Fim Fotos --}}

@section('script')
    @parent
    <script src="{{ asset('/assets/js/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.fileupload.js') }}"></script>
    <script src="{{ asset('/assets/js/cidades.js') }}"></script>
    <script src="{{ asset('/assets/js/component-listagem.js') }}"></script>
    <script src="{{ asset('/assets/js/pidReview.js') }}"></script>
    <script src="{{ asset('/assets/js/masks.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCsOdEoVwUQhPynqvu6OeA6qC9jsVniSlE&signed_in=true&callback=initMap" async defer></script>
@endsection

@section('css')
    @parent
    <link href="{{ asset('/assets/css/jquery.fileupload.css') }}" rel="stylesheet">
@stop

