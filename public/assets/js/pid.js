Vue.http.headers.common['X-CSRF-TOKEN'] = jQuery('meta[name=csrf-token]').attr('content');

var pid = new Vue({
    el: "#PID",

    data: {
        pid: {
            idPid: null,
            nome: '',
            email: '',
            url: '',
            tipo_id: 'null',
            endereco: {
                cep: '',
                logradouro: '',
                numero: '',
                complemento: '',
                bairro: '',
                uf: '',
                cidade_id: '',
                latitude: '',
                longitude: '',
                localidade_id: '',
                localizacao_id: ''
            },
            telefones: [],
            instituicoes: [],
            iniciativas: [],
            fotos: []
        },
        novoTelefone: {
            telefone: '',
            responsavel: '',
            telefoneTipo_id: '1'
        },

        instituicoes: [],
        iniciativas: [],

        response: {
            show: false,
            error: false,
            msg:[]
        }
    },

    methods: {
        cadastrarTelefone: function(ev) {
            ev.preventDefault();
            var self = this;
            self.pid.telefones.push(jQuery.extend({}, self.novoTelefone));
        },

        removerTelefone: function(ev, index) {
            ev.preventDefault();
            var self = this;
            self.pid.telefones.splice(index, 1);
        },

        pesquisarInstituicoes: function(ev) {
            ev.preventDefault();
            var self = this;
            var busca = {
                nome: jQuery('input[name="buscaNome"]').val(),
                uf: jQuery('select[name="buscaUF"]').val(),
                cidade_id: jQuery('select[name="buscaCidade"]').val()
            }

            self.$http.post('/api/pesquisar/instituicoes', busca, function(response){
                self.$set('instituicoes', _.chunk(response,5));
                pid.$refs.listaInstituicoes.$data.page = 0;
            });
        },

        removerInstituicao: function(ev, index) {
            ev.preventDefault();
            var self = this;
            self.pid.instituicoes.splice(index, 1);
        },

        cancelarInstituicoes: function(ev) {
            this.instituicoes = [];
            jQuery('#modalIntituicoes').modal('toggle');
            pid.$refs.listaInstituicoes.$data.page = 0;
        },

        pesquisarIniciativas: function(ev) {
            ev.preventDefault();
            var self = this;
            var busca = {
                nome: jQuery('input[name="iniciativaBuscaNome"]').val(),
                uf: jQuery('select[name="iniciativaBuscaUF"]').val(),
                cidade_id: jQuery('select[name="iniciativaBuscaCidade"]').val()
            }

            self.$http.post('/api/pesquisar/iniciativas', busca, function(response){
                self.$set('iniciativas', _.chunk(response,5));
                pid.$refs.listaIniciativas.$data.page = 0;
            });
        },

        removerIniciativa: function(ev, index) {
            ev.preventDefault();
            var self = this;
            self.pid.iniciativas.splice(index, 1);
        },

        cancelarIniciativas: function(ev) {
            this.iniciativas = [];
            jQuery('#modalIniciativas').modal('toggle');
            pid.$refs.listaIniciativas.$data.page = 0;
        },

        removerFoto: function(ev, index) {
            ev.preventDefault();
            var self = this;
            jQuery('#removeFoto-'+index).html('<i class="fa fa-refresh fa-spin"></i>');
            self.$http.post('/pid/fotos/remover', {idFoto: self.pid.fotos[index].idFoto}, function(response){
                self.pid.fotos.splice(index, 1);
            }).error(function() {
                jQuery('#removeFoto-'+index).html('<span>&times;</span>');
            });
        },

        limparModalFotos: function() {
            jQuery('#progress .progress-bar').css('width', '0%');
            jQuery('#modalFotos').modal('hide');
        },

        salvarPid: function(ev) {
            jQuery('#loading').modal('show');
            ev.preventDefault();
            var self = this;
            self.$set('pid.endereco.latitude', jQuery("#latitude").val());
            self.$set('pid.endereco.longitude', jQuery("#longitude").val());
            if(self.pid.idPid === null) {
                self.$http.post('/pid/store', self.pid, function (response){
                    self.alerta(false, {msg:['Salvo com sucesso!']})
                    self.$set('pid', response);
                    window.location.pathname = '/pid/'+response.idPid+'/edit';

                }).error(function (response){
                    jQuery('#loading').modal('hide');
                    self.alerta(true, response);
                });
            }
            else {
                jQuery('#loading').modal('show');
                self.$http.post('/pid/update', self.pid, function (response){
                    self.$set('pid', response);
                    jQuery('#loading').modal('hide');
                    self.alerta(false, {msg:['Atualizado com sucesso!']})

                }).error(function (response){
                    jQuery('#loading').modal('hide');
                    self.alerta(true, response);
                });
            }
        },

        alerta: function(error, msg) {
            var self = this;
            jQuery('html,body').scrollTop(0);
            self.$set('response.error', error);
            self.$set('response.msg', msg);
            self.$set('response.show', true);
            if(!self.response.error)
                setTimeout(function(){ self.$set('response.show', false);}, 5000);
        }
    },

    ready: function() {
        var self = this, url;

        var param = window.location.pathname.split( '/' )[2];

        if(param != 'create') {
            jQuery('#loading').modal('show');
            url = '/pid/'+param+'/show';

            self.$http.get(url, function(response) {
                /* Adicionando os dados retornados */
                self.$set('pid', response);
                jQuery(getCidades(self.pid.endereco.uf,self.pid.endereco.cidade_id ));
                jQuery('#loading').modal('hide');

                /*Upload Anexos Projeto*/
                var fileUpload = jQuery('#fileupload');
                fileUpload.fileupload({
                    url: '/pid/fotos',
                    acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                    dataType: 'json',
                    formData: {
                        _token: jQuery('meta[name=csrf-token]').attr('content'),
                        idPid: self.pid.idPid
                    },
                    done: function (e, data) {
                        self.pid.fotos.push(data.result);
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        jQuery('#progress .progress-bar').css('width',progress + '%');
                    }
                });
                /* Fim do upload de anexos */
            });
        }
    },

    attached: function() {}
});


function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: {lat: -15.780, lng: -47.929}
    });
    var geocoder = new google.maps.Geocoder();

    document.getElementById('latlngSearch').addEventListener('click', function() {
        geocodeAddress(geocoder, map);
    });

    //HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            map.setCenter(pos);
        });
    }
}

function geocodeAddress(geocoder, resultsMap) {
    var logradouro = document.getElementById('logradouro').value;
    var numero = document.getElementById('numero').value;
    var bairro = document.getElementById('bairro').value;
    var cidade = $('#cidade_id').find(":selected").text();
    var uf = $('#uf').find(":selected").text();
    var cep = document.getElementById('cep').value;
    var address = logradouro+','+numero+','+bairro+','+cidade+','+uf+','+cep;
    geocoder.geocode({'address': address}, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            resultsMap.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: resultsMap,
                position: results[0].geometry.location
            });
            /*Adiconar o valor de lat a lng aos inputs*/
            var latlng = results[0].geometry.location.toJSON();
            $("#latitude").val(latlng.lat);
            $("#longitude").val(latlng.lng);
        } else {
            alert('Falha ao buscar endereço!');
        }
    });
}