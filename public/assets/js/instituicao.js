Vue.http.headers.common['X-CSRF-TOKEN'] = jQuery('meta[name=csrf-token]').attr('content');

var instituicao = new Vue({
    el: "#instituicao",

    data: {
        instituicao: {
            idInstituicao: null,
            nome: '',
            email: '',
            url: '',
            endereco: {
                cep: '',
                logradouro: '',
                numero: '',
                complemento: '',
                bairro: '',
                uf: '',
                cidade_id: '',
                localidade_id: '',
                localizacao_id: ''
            },
            telefones: []
        },
        novoTelefone: {
            idTelefone: null,
            telefone: '',
            responsavel: '',
            telefoneTipo_id: ''
        }
    },

    methods: {
        cadastrarTelefone: function(ev) {
            ev.preventDefault();
            var self = this;
            self.instituicao.telefones.push(jQuery.extend({}, self.novoTelefone));
            self.novoTelefone.telefone = '';
            self.novoTelefone.responsavel = '';
            self.novoTelefone.telefoneTipo_id = '';
            jQuery('#novoTelefone').modal('toggle');
        },

        cancelarTelefone: function(ev) {
            ev.preventDefault();
            var self = this;
            self.novoTelefone.telefone = '';
            self.novoTelefone.responsavel = '';
            self.novoTelefone.telefoneTipo_id = '';
            jQuery('#novoTelefone').modal('toggle');
        },

        removerTelefone: function(ev, index) {
            ev.preventDefault();
            var self = this;
            self.instituicao.telefones.splice(index, 1);
            /* Retirar no BD */
        },

        salvarInstituicao: function(ev) {
            ev.preventDefault();
            var self = this;
            if(self.instituicao.idInstituicao === null) {
                self.$http.post('/instituicao/', self.instituicao, function (response){
                    alert("Salvo");
                    self.$set('instituicao', response);
                    window.location.pathname = '/instituicao/'+response.idInstituicao+'/edit';

                }).error(function (response){
                    alert('ERROR');
                });
            }
            else {
                self.$http.put('/instituicao/', self.instituicao, function (response){
                    alert("Atualizado");
                    self.$set('instituicao', response);
                    //window.location.pathname = '/instituicao/'+response.idInstituicao+'/edit';

                }).error(function (response){
                    alert('ERROR');
                });
            }
        }
    },

    ready: function() {
        var self = this, url;

        var param = window.location.pathname.split( '/' )[2];

        if(param != 'create') {
            url = '/instituicao/'+param+'/show/';

            self.$http.get(url, function(response) {
                /* Adicionando os dados retornados */
                self.$set('instituicao', response);
                jQuery(getCidades(self.instituicao.endereco.uf,self.instituicao.endereco.cidade_id ));

            });
        }
    },

    attached: function() {}
});