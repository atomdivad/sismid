$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$("#iniciativa").select2();

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
            self.$http.get('/api/pid/'+val+'/show', function(response){
                self.$set('info', response);
            });
        }
    }
});

$('.pidAtivo').on('click', function(e) {
    e.preventDefault();
    var self = this;
    $(self).html('<i class="fa fa-refresh fa-spin"></i> Carregando');
    var id = $(self).data('id');
    $.post('/pid/active', {id: id}, function(response) {
        if(response == 1) {
            $(self).removeClass('btn-info');
            $(self).addClass('btn-danger');
            $(self).html('<i class="fa fa-close"></i> Desativar');
        }
        else if(response == 0) {
            $(self).removeClass('btn-danger');
            $(self).addClass('btn-info');
            $(self).html('<i class="fa fa-check"></i> Ativar');
        }
    });
});