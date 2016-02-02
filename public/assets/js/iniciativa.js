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
            telefoneTipo_id: '1'
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
            jQuery('#gridLoaded').hide();
            jQuery('#gridLoading').show();
            var self = this;
            var busca = {
                nome: jQuery('input[name="buscaNome"]').val(),
                uf: jQuery('select[name="buscaUF"]').val(),
                cidade_id: jQuery('select[name="buscaCidade"]').val()
            }

            self.$http.post('/api/pesquisar/instituicoes', busca, function(response){
                self.$set('instituicoes', _.chunk(response,5));
                iniciativa.$refs.listaInstituicoes.$data.page = 0;
                jQuery('#gridLoading').hide();
                jQuery('#gridLoaded').show();
            });
        },

        removerInstituicao: function(ev, index) {
            ev.preventDefault();
            var self = this;
            self.iniciativa.instituicoes.splice(index, 1);
        },

        cancelarInstituicoes: function(ev) {
            jQuery('#modalIntituicoes').modal('toggle');
            iniciativa.$refs.listaInstituicoes.$data.page = 0;
        },

        cadastrarTelefone: function(ev) {
            ev.preventDefault();
            var self = this;
            self.iniciativa.telefones.push(jQuery.extend({}, self.novoTelefone));
        },

        removerTelefone: function(ev, index) {
            ev.preventDefault();
            var self = this;
            self.iniciativa.telefones.splice(index, 1);
        },

        salvarIniciativa: function(ev) {
            ev.preventDefault();
            jQuery('#loading').modal('show');
            var self = this;
            self.$set('iniciativa.endereco.latitude', jQuery("#latitude").val());
            self.$set('iniciativa.endereco.longitude', jQuery("#longitude").val());
            if(self.iniciativa.idIniciativa === null) {
                self.$http.post('/iniciativa/store', self.iniciativa, function (response){
                    self.alerta(false, {msg:['Salvo com sucesso!']});
                    self.$set('iniciativa', response);
                    window.location.pathname = '/iniciativa/'+response.idIniciativa+'/edit';

                }).error(function (response){
                    jQuery('#loading').modal('hide');
                    self.alerta(true, response);
                });
            }
            else {
                self.$http.post('/iniciativa/update', self.iniciativa, function (response){
                    jQuery('#loading').modal('hide');
                    self.alerta(false, {msg:['Atualizado com sucesso!']})
                    self.$set('iniciativa', response);

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
            url = '/iniciativa/'+param+'/show';

            self.$http.get(url, function(response) {
                /* Adicionando os dados retornados */
                self.$set('iniciativa', response);
                jQuery(getCidades(self.iniciativa.endereco.uf,self.iniciativa.endereco.cidade_id ));
                if (typeof google === 'object' && typeof google.maps === 'object')
                    jQuery(setPosition(self.iniciativa.endereco.latitude, self.iniciativa.endereco.longitude, map));
                jQuery('#loading').modal('hide');
            });
        }
    },

    attached: function() {}
});
var map;
function initMap() {
     map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: {lat: -15.8753366, lng: -52.261551399999995}
    });
    var geocoder = new google.maps.Geocoder();

    document.getElementById('latlngSearch').addEventListener('click', function() {
        geocodeAddress(geocoder, map);
    });

    var param = window.location.pathname.split( '/' )[2];
    if(param != 'create') {
        setPosition(iniciativa.$data.iniciativa.endereco.latitude, iniciativa.$data.iniciativa.endereco.longitude, map);
    }
    else {
        //HTML5 geolocation.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                map.setCenter(pos);
            });
        }
    }

    /*Desativa o zoom com duplo click p/ pegar a posição*/
    map.set("disableDoubleClickZoom", true);
    google.maps.event.addListener(map,"dblclick", function (e) { setNewPosition(e.latLng, map); });
}

var marker;

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
            marker.setPosition(results[0].geometry.location);
            /*Adiconar o valor de lat a lng aos inputs*/
            var latlng = results[0].geometry.location.toJSON();
            $("#latitude").val(latlng.lat);
            $("#longitude").val(latlng.lng);
        } else {
            alert('Falha ao buscar endereço!');
        }
    });
}

function setPosition(lat, long, map) {
    latLng = new google.maps.LatLng(lat, long);
    marker = new google.maps.Marker({
        map: map,
        position: latLng,
        visible: true
    });
    map.setCenter(latLng);
}

function setNewPosition(pos, map) {
    marker.setPosition(pos);
    map.setCenter(pos);
    $("#latitude").val(pos.lat);
    $("#longitude").val(pos.lng);
}