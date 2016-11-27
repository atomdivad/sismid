<!-- Novo Telefone -->
<div class="modal fade" id="novoTelefone" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="glyphicon glyphicon-edit"></i> Cadastrar Novo Telefone</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" v-show="novoTelefone.error">
                    Erro ao Cadastrar novo Telefone
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                <div class="form-group">
                    <label for="name">Telefone</label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="text" name="telefone" class="form-control" v-model="novoTelefone.telefone"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Responsavel</label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="text" name="reponsavel" class="form-control" v-model="novoTelefone.responsavel"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Tipo Telefone</label>
                    <div class="row">
                        <div class="col-sm-12">
                            <select name="telefoneTipo_id" class="form-control" v-model="novoTelefone.telefoneTipo_id">
                                @foreach($telefoneTipos as $index => $tipo)
                                    <option value="{{ $index }}">{{ $tipo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-success" v-on:click="cadastrarTelefone($event)"><span class="glyphicon glyphicon-save"></span> Salvar</button>
                <button class="btn btn-danger" v-on:click="cancelarTelefone($event)"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fim Novo Telefone -->