<!-- Modal Info -->
<div class="modal fade"     id="modalInfoPid" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="glyphicon glyphicon-info-sign"></i> @{{ info.nome | uppercase }}</h4>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Informações</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Endereço</a></li>
                    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Iniciativa</a></li>
                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Fotos</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <br/>
                        <p v-show="info.url.length > 6 "><i class="glyphicon glyphicon-link"></i> <a href="@{{ info.url }}">@{{ info.url }}</a></p>
                        <p v-show="info.email != ''"><i class="glyphicon glyphicon-envelope"></i> <a href="mailto:@{{ info.email }}">@{{ info.email }}</a></p>
                        <p>
                            <div v-for="t in info.telefones">
                            <i class="glyphicon"
                               v-bind:class="{
                               'glyphicon-phone': t.telefoneTipo_id == 1,
                               'glyphicon-phone-alt': t.telefoneTipo_id == 2,
                               'glyphicon-earphone': t.telefoneTipo_id == 3 }">
                            </i> @{{ t.telefone }}
                            </div>
                        </p>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="profile">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="thumbnail">
                                    <img src="https://maps.googleapis.com/maps/api/staticmap?zoom=15&size=800x350&maptype=roadmap&markers=color:red%7Clabel:%7C@{{ info.endereco.latitude }},@{{ info.endereco.longitude }}&key=AIzaSyCsOdEoVwUQhPynqvu6OeA6qC9jsVniSlE" alt="Localização"/>
                                </div>
                                <strong>
                                    @{{ info.endereco.logradouro }}
                                    @{{ info.endereco.numero }}
                                    @{{ info.endereco.complemento }}
                                    @{{ info.endereco.bairro }} <br/>
                                    CEP @{{ info.endereco.cep }} <br/>
                                    @{{ info.endereco.cidade_id }} - @{{ info.endereco.uf }}
                                </strong>
                            </div>
                        </div>
                    </div>
                    
                    <div role="tabpanel" class="tab-pane" id="messages">
                        @{{ iniciativas | json }}
                    </div>
                    
                    <div role="tabpanel" class="tab-pane" id="settings">
                        <br/>
                        <div class="row" v-show="info.fotos.length > 0">
                            <div class="col-xs-6 col-md-3" v-for="foto in info.fotos">
                                <a href="#" class="thumbnail" v-on:click.prevent>
                                    <img src="/api/@{{ id }}/fotos/@{{ foto.nome }}" alt="@{{ foto.nome }}">
                                </a>
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