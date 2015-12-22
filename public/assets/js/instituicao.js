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
        },

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
            self.instituicao.telefones.push(jQuery.extend({}, self.novoTelefone));
            self.novoTelefone.telefone = '';
            self.novoTelefone.responsavel = '';
            self.novoTelefone.telefoneTipo_id = '';
        },

        removerTelefone: function(ev, index) {
            ev.preventDefault();
            var self = this;
            self.instituicao.telefones.splice(index, 1);
        },

        salvarInstituicao: function(ev) {
            ev.preventDefault();
            var self = this;
            if(self.instituicao.idInstituicao === null) {
                self.$http.post('/instituicao/store', self.instituicao, function (response){
                    self.alerta(false, {msg:['Salvo com sucesso!']})
                    self.$set('instituicao', response);
                    window.location.pathname = '/instituicao/'+response.idInstituicao+'/edit';

                }).error(function (response){
                    self.alerta(true, response);
                });
            }
            else {
                self.$http.post('/instituicao/update', self.instituicao, function (response){
                    self.alerta(false, {msg:['Atualizado com sucesso!']})
                    self.$set('instituicao', response);

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