<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('nome', 'Nome*') !!}
            {!! Form::text('nome', null, ["class" => "form-control", "autofocus", "v-model" => "gestor.nome"]) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('sobrenome', 'Sobrenome*') !!}
            {!! Form::text('sobrenome', null, ["class" => "form-control", "v-model" => "gestor.sobrenome"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('email', 'E-mail*') !!}
            {!! Form::input('email', 'email', null, ["class" => "form-control", "v-model" => "gestor.email"]) !!}
        </div>
    </div>
</div>

{{-- Iniciativas Vinculadas --}}
@include('iniciativas.gestores.partials.modal_iniciativas')
<div class="form-group">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-6"><i class="glyphicon glyphicon-list"></i> Iniciativa Vinculada</div>
                        <div class="col-sm-6 text-right" v-show="gestor.iniciativa.length == 0">
                            <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalIniciativas"><i class="glyphicon glyphicon-plus"></i> Iniciativa</button>
                        </div>
                    </div>
                </div>
                <table class="table table-responsive table-striped table-bordered" v-show="gestor.iniciativa.length > 0">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Municipio</th>
                        <th>UF</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="i in gestor.iniciativa">
                        <td>@{{ i.nome }}</td>
                        <td>@{{ i.nomeCidade }}</td>
                        <td>@{{ i.uf }}</td>
                        <td><button class="btn btn-sm btn-danger" v-on:click="removerIniciativa($event, $index)"><i class="glyphicon glyphicon-trash"></i></button></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- Fim Iniciativas Vinculadas --}}

@section('script')
    @parent
    <script src="{{ asset('/assets/js/cidades.js') }}"></script>
    <script src="{{ asset('/assets/js/component-listagem.js') }}"></script>
    <script src="{{ asset('/assets/js/gestor.js') }}"></script>
    <script src="{{ asset('/assets/js/masks.js') }}"></script>
@stop

