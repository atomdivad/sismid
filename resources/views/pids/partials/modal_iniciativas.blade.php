<!-- Modal Iniciativas -->
<div class="modal fade" id="modalIniciativas" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="glyphicon glyphicon-list"></i> Iniciativas</h4>
            </div>
            <div class="modal-body">
                <div id="filtrarIniciativas">
                    <div class="form-group">
                        <label for="buscaNome">Nome</label>
                        <input type="text" name="iniciativaBuscaNome" id="iniciativaBuscaNome" class="form-control"/>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('iniciativaBuscaUF', 'UF') !!}
                                <select name="iniciativaBuscaUF" id="iniciativaBuscaUF" class="form-control">
                                    <option value="0">Todos UF</option>
                                    @foreach($uf as $index => $u)
                                        <option value="{{ $index }}">{{ $u }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                {!! Form::label('iniciativaBuscaCidade', 'Município') !!} <i class="fa fa-refresh fa-spin" style="display: none;" id="iniciativaBuscaCidadeLoading"></i>
                                {!! Form::select('iniciativaBuscaCidade', [], null, ["class" => "form-control"]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-sm btn-primary" v-on:click="pesquisarIniciativas($event)"><i class="glyphicon glyphicon-search"></i> Pesquisar</button>
                    </div>

                </div>

                <div id="gridLoading1" class="text-center" style="display: none;">
                    <i class="fa fa-refresh fa-spin fa-3x"></i>
                </div>
                <div id="gridLoaded1">
                    <listagem :lista="iniciativas" :container.sync="pid.iniciativas" v-ref:lista-iniciativas></listagem>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-default" v-on:click="cancelarIniciativas($event)"><span class="glyphicon glyphicon-close"></span> Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fim Modal Iniciativas -->