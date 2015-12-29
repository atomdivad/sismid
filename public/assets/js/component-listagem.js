Vue.component('listagem', {
    template: '#template',
    props: {
        lista: '',
        container: ''
    },

    data: function() {
        return {page: 0}
    },

    methods: {

        adicionarItem: function(ev, index) {
            ev.preventDefault();
            var self = this;
            self.lista[this.page][index].tipoVinculo = 0;
            self.container.push(jQuery.extend({}, self.lista[this.page][index]))
            jQuery('#modalIniciativas').modal('hide');
        },

        doNext: function() {
            if(this.page < this.lista.length-1)
                this.page += 1;
        },

        doPrevious: function() {
            if(this.page == 0)
                return
            this.page -= 1;
        }
    }
});