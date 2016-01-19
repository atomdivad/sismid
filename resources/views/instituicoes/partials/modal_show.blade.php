<!-- Modal Info -->
<div class="modal fade"     id="modalInfo" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="glyphicon glyphicon-info-sign"></i> @{{ info.nome | uppercase }}</h4>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Informações</a></li>
                    <li role="presentation"><a href="#endereco" aria-controls="endereco" role="tab" data-toggle="tab">Endereço</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane active" id="home">
                        <br/>
                        <div class="row">
                            <div class="col-sm-6">
                                <p v-show="info.naturezaJuridica.length > 0 "><strong>Natureza Jurídica:</strong> @{{ info.naturezaJuridica | uppercase }}</p>
                                <p v-show="info.url.length > 0 "><i class="glyphicon glyphicon-link"></i> <a href="@{{ info.url }}">@{{ info.url }}</a></p>
                                <p v-show="info.email.length > 0"><i class="glyphicon glyphicon-envelope"></i> <a href="mailto:@{{ info.email }}">@{{ info.email }}</a></p>
                            </div>

                            <div class="col-sm-6">
                                <div v-for="t in info.telefones">
                                    <i class="glyphicon" v-bind:class="{'glyphicon-phone': t.telefoneTipo_id == 1,'glyphicon-phone-alt': t.telefoneTipo_id == 2,'glyphicon-earphone': t.telefoneTipo_id == 3 }"></i> @{{ t.telefone }} - @{{ t.responsavel }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="endereco">
                        <br/>
                        <div class="row">
                            <div class="col-sm-6">
                                @{{ info.endereco.logradouro | uppercase }},
                                @{{ info.endereco.numero }},
                                @{{ info.endereco.complemento | uppercase }} <br/>
                                @{{ info.endereco.bairro | uppercase }} <br/>
                                @{{ info.endereco.cep }} - @{{ info.endereco.cidade | uppercase }} - @{{ info.endereco.uf }}
                            </div>
                            <div class="col-sm-6">

                                <strong>Localidade:</strong> @{{ info.endereco.localidade | uppercase }} <br/>
                                <strong>Localização:</strong> @{{ info.endereco.localizacao | uppercase }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fim Modal Info -->