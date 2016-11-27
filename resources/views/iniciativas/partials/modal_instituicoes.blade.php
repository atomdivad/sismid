<!-- Modal Instituicoes -->
<div class="modal fade" id="modalIntituicoes" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="glyphicon glyphicon-list"></i> Instituições</h4>
            </div>
            <div class="modal-body">
                <div id="filtrarInstituicoes">
                    <div class="form-group">
                        <label for="buscaNome">Nome</label>
                        <input type="text" name="buscaNome" class="form-control"/>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('buscaUF', 'UF') !!}
                                <select name="buscaUF" id="buscaUF" class="form-control">
                                    <option value="0">Todos UF</option>
                                    @foreach($uf as $index => $u)
                                        <option value="{{ $index }}">{{ $u }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                {!! Form::label('buscaCidade', 'Município') !!} <i class="fa fa-refresh fa-spin" style="display: none;" id="buscaCidadeLoading"></i>
                                {!! Form::select('buscaCidade', [], null, ["class" => "form-control"]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-sm btn-primary" v-on:click="pesquisarInstituicoes($event)"><i class="glyphicon glyphicon-search"></i> Pesquisar</button>
                    </div>

                </div>
                <div id="gridLoading" class="text-center" style="display: none;">
                    <i class="fa fa-refresh fa-spin fa-3x"></i>
                </div>
                <div id="gridLoaded">
                    <listagem :lista="instituicoes" :container.sync="iniciativa.instituicoes" v-ref:lista-instituicoes></listagem>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" v-on:click="cancelarInstituicoes($event)"><span class="glyphicon glyphicon-remove"></span> Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fim Modal Instituicoes -->