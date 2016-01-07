{{--Modal Fotos--}}
<div class="modal fade" id="modalFotos" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="glyphicon glyphicon-list"></i> Upload de fotos</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel-body">
                            <!-- The fileinput-button span is used to style the file input field as button -->
                                <span class="btn btn-success fileinput-button">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    <span>Selecionar arquivos...</span>
                                    <!-- The file input field used as target for the file upload widget -->
                                    <input id="fileupload" type="file" name="foto" multiple>
                                </span>
                            <br>
                            <br>
                            <!-- The global progress bar -->
                            <div id="progress" class="progress">
                                <div class="progress-bar progress-bar-success"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" v-on:click="limparModalFotos"><span class="glyphicon glyphicon-close"></span> Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{--Fim Modal Fotos--}}