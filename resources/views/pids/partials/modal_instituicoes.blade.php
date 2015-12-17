<!-- Modal Instituicoes -->
<div class="modal fade" id="modalIntituicoes" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="glyphicon glyphicon-list"></i> Instituções Responsaveis</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" v-show="">
                    Erro ao Cadastrar...
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>


            </div>
            <div class="modal-footer">
                <button class="btn btn-success" v-on:click="cadastrarInstituicoes($event)"><span class="glyphicon glyphicon-save"></span> Salvar</button>
                <button class="btn btn-danger" v-on:click="cancelarInstituicoes($event)"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fim Modal Instituicoes -->