Vue.http.headers.common['X-CSRF-TOKEN'] = jQuery('meta[name=csrf-token]').attr('content');

var app = new Vue({
    el: "#PID",

    data: {
        pid: {
            nome: '',
            email: '',
            url: '',
            endereco: {
                cep: '',
                logradouro: '',
                numero: '',
                complemento: '',
                bairro: '',
                cidade_id: '',
                latitude: '',
                longitude: '',
                localidade_id: '',
                localizacao_id: ''
            },
            telefones: [],
            instituicoes: [],
            iniciativas: []
        },
        novoTelefone: {
            telefone: '',
            responsavel: '',
            tipoTelefone_id: ''
        }
    },

    methods: {
        cadastrarTelefone: function(ev) {
            ev.preventDefault();
            var self = this;
            self.pid.telefones.push(jQuery.extend({}, self.novoTelefone));
            self.novoTelefone.telefone = '';
            self.novoTelefone.responsavel = '';
            self.novoTelefone.tipoTelefone_id = '';
            jQuery('#novoTelefone').modal('toggle');
        },

        cancelarTelefone: function(ev) {
            ev.preventDefault();
            var self = this;
            self.novoTelefone.telefone = '';
            self.novoTelefone.responsavel = '';
            self.novoTelefone.tipoTelefone_id = '';
            jQuery('#novoTelefone').modal('toggle');
        },

        removerTelefone: function(ev, index) {
            ev.preventDefault();
            var self = this;
            self.pid.telefones.splice(index, 1);
            /* Retirar no BD */
        },

        cancelarInstituicoes: function(ev) {
            ev.preventDefault();
            jQuery('#modalIntituicoes').modal('toggle');
        }
    },

    ready: function() {},

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
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}

/* Busca as cidades do estado selecionado */
function getCidades(uf)
{
    $.get("/api/uf/"+uf+"/cidades/",
        function (data) {
            var cidade = $('#cidade_id');
            cidade.empty();

            cidade.append('<option value="" selected>Selecione a cidade</a>');
            for ($i = 0; $i < data.length; $i++) {
                cidade.append('<option value="' + data[$i].idCidade + '">' + data[$i].nomeCidade + '</a>');
            }
        }
    );
}

(function() {
    $("#uf").change(function() {

        var uf =  $(this)
        getCidades(uf.val());

    });
}).call(this);

$(getCidades($("#uf").val()));