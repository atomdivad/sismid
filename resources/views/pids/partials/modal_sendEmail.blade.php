<!-- Modal SendEmail -->
<div class="modal fade" id="modalSendLink" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="glyphicon glyphicon-send"></i></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <p>
                        <strong>Link para visualização dos dados deste PID:</strong> <a href="/pid/@{{ pid.idPid }}/ver" target="_blank">{{ url('/') }}/pid/@{{ pid.idPid }}/ver</a>
                    </p>
                </div>
                <label for="sendEmail">Enviar p/ o e-mail:</label>
                <input type="text" name="sendEmail" class="form-control" value="@{{ pid.email }}" v-model="sendEmail.email"/>
                <div v-show="sendEmail.error" class="alert alert-danger">Não foi possivel enviar o e-mail.</div>
                <div v-show="sendEmail.success" class="alert alert-success">E-mail enviado com sucesso.</div>

            </div>
            <div class="modal-footer">
                <button id="btnSendLink" class="btn btn-success" v-on:click="enviarLink($event)""><span class="glyphicon glyphicon-send"></span> Enviar</button>
                <button class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fim Modal SendEmail -->