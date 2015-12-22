Vue.http.headers.common['X-CSRF-TOKEN'] = jQuery('meta[name=csrf-token]').attr('content');

var iniciativa = new Vue({
    el: "#iniciativa",

    data: {
        iniciativa: {
            idIniciativa: null,
            tipo_id: '',
            nome: '',
            sigla: '',
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
            naturezaJuridica_id: '',
            email: '',
            url: '',
            objetivo: '',
            informacaoComplementar: '',
            categoria_id: '',
            fonte: '',
            telefones: [],
            instituicoes: [],
            dimensoes: [],
            servicos: []

        },
        novoTelefone: {
            idTelefone: null,
            telefone: '',
            responsavel: '',
            telefoneTipo_id: ''
        },

        instituicoes: [],

        response: {
            show: false,
            error: false,
            msg:[]
        }
    },

    methods: {

        pesquisarInstituicoes: function(ev) {
            ev.preventDefault();
            var self = this;
            var busca = {
                nome: jQuery('input[name="buscaNome"]').val(),
                uf: jQuery('select[name="buscaUF"]').val(),
                cidade_id: jQuery('select[name="buscaCidade"]').val()
            }

            self.$http.post('/api/pesquisar/instituicoes/', busca, function(response){
                self.$set('instituicoes', response);
            });
        },

        adicionarInstituicao: function(ev, index) {
            ev.preventDefault();
            var self = this;
            self.instituicoes[index].tipoVinculo = 0;
            self.iniciativa.instituicoes.push(jQuery.extend({}, self.instituicoes[index]))
        },

        removerInstituicao: function(ev, index) {
            ev.preventDefault();
            var self = this;
            self.iniciativa.instituicoes.splice(index, 1);
        },

        cancelarInstituicoes: function(ev) {
            jQuery('#modalIntituicoes').modal('toggle');
        },

        cadastrarTelefone: function(ev) {
            ev.preventDefault();
            var self = this;
            self.iniciativa.telefones.push(jQuery.extend({}, self.novoTelefone));
            self.novoTelefone.telefone = '';
            self.novoTelefone.responsavel = '';
            self.novoTelefone.telefoneTipo_id = '';
            //jQuery('#novoTelefone').modal('toggle');
        },

        removerTelefone: function(ev, index) {
            ev.preventDefault();
            var self = this;
            self.iniciativa.telefones.splice(index, 1);
        },

        salvarIniciativa: function(ev) {
            ev.preventDefault();
            var self = this;
            self.$set('iniciativa.endereco.latitude', jQuery("#latitude").val());
            self.$set('iniciativa.endereco.longitude', jQuery("#longitude").val());
            if(self.iniciativa.idIniciativa === null) {
                self.$http.post('/iniciativa/store', self.iniciativa, function (response){
                    self.alerta(false, {msg:['Salvo com sucesso!']})
                    self.$set('iniciativa', response);
                    window.location.pathname = '/iniciativa/'+response.idIniciativa+'/edit';

                }).error(function (response){
                    self.alerta(true, response);
                });
            }
            else {
                self.$http.post('/iniciativa/update', self.iniciativa, function (response){
                    self.alerta(false, {msg:['Atualizado com sucesso!']})
                    self.$set('iniciativa', response);

                }).error(function (response){
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
            url = '/iniciativa/'+param+'/show/';

            self.$http.get(url, function(response) {
                /* Adicionando os dados retornados */
                self.$set('iniciativa', response);
                jQuery(getCidades(self.iniciativa.endereco.uf,self.iniciativa.endereco.cidade_id ));

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