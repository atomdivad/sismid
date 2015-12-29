Vue.http.headers.common['X-CSRF-TOKEN'] = jQuery('meta[name=csrf-token]').attr('content');

var gestor = new Vue({
    el: "#gestor",

    data: {
        gestor: {
            idUsuario: null,
            nome: '',
            sobrenome: '',
            email: '',
            iniciativa: []
        },

        iniciativas: [],

        response: {
            show: false,
            error: false,
            msg:[]
        }
    },

    methods: {

        pesquisarIniciativas: function(ev) {
            ev.preventDefault();
            var self = this;
            var busca = {
                nome: jQuery('input[name="iniciativaBuscaNome"]').val(),
                uf: jQuery('select[name="iniciativaBuscaUF"]').val(),
                cidade_id: jQuery('select[name="iniciativaBuscaCidade"]').val()
            }

            self.$http.post('/api/pesquisar/iniciativas/', busca, function(response){
                self.$set('iniciativas', _.chunk(response,5));
                gestor.$refs.listaIniciativas.$data.page = 0;
            });
        },

        removerIniciativa: function(ev, index) {
            ev.preventDefault();
            var self = this;
            self.gestor.iniciativa.splice(index, 1);
        },

        cancelarIniciativas: function(ev) {
            this.iniciativas = [];
            jQuery('#modalIniciativas').modal('toggle');
            gestor.$refs.listaIniciativas.$data.page = 0;
        },

        salvarGestor: function(ev) {
            ev.preventDefault();
            var self = this;

            /*Verifica agora para evitar error ao capturar o dados a seguir*/
            if(self.gestor.iniciativa.length == 0) {
                self.alerta(true,{msg:['Escolha a iniciativa!']});
                return false;
            }

            var dados = {
                idUsuario: self.gestor.idUsuario,
                nome: self.gestor.nome,
                sobrenome: self.gestor.sobrenome,
                email: self.gestor.email,
                iniciativa_id: self.gestor.iniciativa[0].idIniciativa
            }

            if(self.gestor.idUsuario === null) {
                self.$http.post('/iniciativa/gestor/store', dados, function (response){
                    self.alerta(false, {msg:['Salvo com sucesso!']})
                    self.$set('gestor', response);
                    window.location.pathname = '/iniciativa/gestor/'+response.idUsuario+'/edit';

                }).error(function (response){
                    self.alerta(true, response);
                });
            }
            else {
                self.$http.post('/iniciativa/gestor/update', dados, function (response){
                    self.alerta(false, {msg:['Atualizado com sucesso!']})
                    self.$set('gestor', response);

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

        var param = window.location.pathname.split( '/' )[3];

        if(param != 'create') {
            url = '/iniciativa/gestor/'+param+'/show/';

            self.$http.get(url, function(response) {
                /* Adicionando os dados retornados */
                self.$set('gestor', response);

            });
        }
    }
});