@extends('app')
@section('content')
    <div id="verify">
        <div class="modal-content" style="min-height: 500px;">
            <div class="modal-header">
                <h4 class="modal-title"><i class="glyphicon glyphicon-info-sign"></i> @{{ info.nome | uppercase }}</h4>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Informações</a></li>
                    <li role="presentation"><a href="#endereco" aria-controls="endereco" role="tab" data-toggle="tab">Endereço</a></li>
                    <li role="presentation"><a href="#instituicoes" aria-controls="instituicoes" role="tab" data-toggle="tab">Instituições</a></li>
                    <li role="presentation"><a href="#iniciativas" aria-controls="iniciativas" role="tab" data-toggle="tab">Iniciativa</a></li>
                    <li role="presentation"><a href="#servicos" aria-controls="servicos" role="tab" data-toggle="tab">Serviços</a></li>
                    <li role="presentation"><a href="#fotos" aria-controls="fotos" role="tab" data-toggle="tab">Fotos</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane active" id="home">
                        <br/>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><i class="fa fa-info"></i> Informações</div>
                                    <div class="panel-body">
                                        <p>
                                            <strong>Tipo:</strong> @{{ info.tipo | uppercase }}
                                            <span v-show="info.tipo == null " class="alert-warning">Tipo não Informado</span>
                                        </p>

                                        <p>
                                            <i class="glyphicon glyphicon-link" title="URL"></i> <a href="@{{ info.url }}">@{{ info.url }}</a>
                                            <span v-show="info.url.length == 0 " class="alert-info">URL não Informado</span>
                                        </p>

                                        <p>
                                            <i class="glyphicon glyphicon-envelope" title="E-mail"></i> <a href="mailto:@{{ info.email }}">@{{ info.email }}</a>
                                            <span v-show="info.email.length == 0 " class="alert-info">E-mail não Informado</span>
                                        </p>

                                        <p>
                                            <strong>Status:</strong> <i class="fa"v-bind:class="{'fa-check': info.ativo == 1, 'fa-ban': info.ativo == 0}"></i>
                                        </p>

                                        <p>
                                            <strong>Prêmiado/Destaque: </strong>
                                            <i v-if="info.destaque == 1" class="fa fa-star fa-2x gold-star" title="PID Prêmiado/Destaque"></i>
                                            <span v-if="info.destaque == 0">Não</span>
                                        </p>

                                        <p>
                                            <strong>Última Atualização:</strong> @{{ info.updated_at }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><i class="fa fa-phone"></i> Telefone</div>
                                    <div class="panel-body">
                                        <div v-for="t in info.telefones">
                                            <i class="glyphicon" v-bind:class="{'glyphicon-phone': t.telefoneTipo_id == 1,'glyphicon-phone-alt': t.telefoneTipo_id == 2,'glyphicon-earphone': t.telefoneTipo_id == 3 }"></i> @{{ t.telefone }} - @{{ t.responsavel }}
                                        </div>
                                        <p v-show="info.telefones.length == 0" class="alert alert-info">Não há telefones cadastrados</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="endereco">
                        <div class="row">
                            <div class="col-sm-6">
                                <strong>Logradouro:</strong> @{{ info.endereco.logradouro | uppercase }} <br/>
                                <strong>Numero:</strong> @{{ info.endereco.numero }} <br/>
                                <strong>Complemento:</strong> @{{ info.endereco.complemento | uppercase }} <br/>
                                <strong>Bairro:</strong> @{{ info.endereco.bairro | uppercase }} <br/>
                                <strong>CEP:</strong> @{{ info.endereco.cep }} <br/>
                            </div>
                            <div class="col-sm-6">
                                <strong>Cidade:</strong> @{{ info.endereco.cidade | uppercase }} <br/>
                                <strong>UF:</strong> @{{ info.endereco.uf }} <br/>
                                <strong>Localidade:</strong> @{{ info.endereco.localidade | uppercase }} <br/>
                                <strong>Localização:</strong> @{{ info.endereco.localizacao | uppercase }}
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="thumbnail">
                                    <img src="https://maps.googleapis.com/maps/api/staticmap?zoom=15&size=400x250&maptype=roadmap&markers=color:red%7Clabel:%7C@{{ info.endereco.latitude }},@{{ info.endereco.longitude }}&key=AIzaSyCsOdEoVwUQhPynqvu6OeA6qC9jsVniSlE" alt="Localização"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="instituicoes">
                        <br/>
                        <ul class="list-group">
                            <li class="list-group-item" v-for="it in info.instituicoes">
                                @{{ it.nome }} - @{{ it.nomeCidade }} - @{{ it.uf }}
                            </li>
                        </ul>
                        <p v-show="info.instituicoes.length == 0" class="alert alert-info">Nenhuma Instituição.</p>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="iniciativas">
                        <br/>
                        <div class="row">
                            <div class="col-sm-12">
                                <ul class="list-group">
                                    <li class="list-group-item" v-for="inic in info.iniciativas">
                                        @{{ inic.nome }} - @{{ inic.nomeCidade }} - @{{ inic.uf }}
                                    </li>
                                </ul>
                                <p v-show="info.iniciativas.length == 0" class="alert alert-info">Nenhuma Iniciativa.</p>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="servicos">
                        <br/>
                        <div class="row">
                            <div class="col-sm-12">
                                <ul class="list-group">
                                    <li class="list-group-item" v-for="sv in info.servicos">
                                        @{{ sv }}
                                    </li>
                                </ul>
                                <p v-show="info.servicos.length == 0" class="alert alert-info">Nenhuma Serviço.</p>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="fotos">
                        <br/>
                        <div class="row">
                            <div class="col-xs-6 col-md-3" v-for="foto in info.fotos">
                                <a href="#" class="thumbnail" v-on:click.prevent>
                                    <img src="/api/@{{ id }}/fotos/@{{ foto.nome }}" alt="@{{ foto.nome }}">
                                </a>
                            </div>
                            <div class="col-sm-12" v-show="info.fotos.length == 0" >
                                <p class="alert alert-info">Nenhuma Foto.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
@section('script')
    @parent
    <script type="text/javascript">
        var info = new Vue({
            el: '#verify',

            data:{
                id: null,
                info: ''
            },

            methods: {},

            ready: function() {
                var param = window.location.pathname.split( '/' )[2];
                var self = this;
                self.$http.get('/api/pid/'+param+'/show', function(response){
                        self.$set('info', response);
                });
            }
        });
    </script>
@endsection