$('.show-modal').on('click', function(){
    info.$data.id = $(this).data('id');
});

var info = new Vue({
    el: '#modalInfo',

    data:{
        id: null,
        info: ''
    },

    methods: {},

    watch: {
        'id': function (val) {
            var self = this;
            self.$http.get('/api/iniciativa/'+val+'/show', function(response){
                self.$set('info', response);
            });
        }
    }
});