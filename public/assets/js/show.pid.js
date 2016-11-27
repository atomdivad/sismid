$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

Vue.http.headers.common['X-CSRF-TOKEN'] = jQuery('meta[name=csrf-token]').attr('content');

$("#iniciativa").select2();

$('.show-modal').on('click', function(){
    info.$data.id = $(this).data('id');
    info.$data.sendEmail.email = info.$data.info.email;
    info.$data.sendEmail.error = false;
    info.$data.sendEmail.error_two = false;
    info.$data.sendEmail.success = false;
    jQuery('#btnSendLink').html('<span class="glyphicon glyphicon-send"></span> Enviar');
    jQuery('#btnSendLink').prop( "disabled", false);
    jQuery('#btnClose').prop( "disabled", false);
});

var info = new Vue({
    el: '#modalInfo',

    data:{
        id: null,
        info: '',

        sendEmail: {
            email : '',
            error: false,
            error_two: false,
            success: false
        }
    },

    methods: {
        enviarLink: function(ev) {
            ev.preventDefault();
            jQuery('#btnSendLink').prop( "disabled", true);
            jQuery('#btnClose').prop( "disabled", true);
            jQuery('#btnSendLink').html('<i class="fa fa-refresh fa-spin"></i> Enviando');
            var self = this;
            self.sendEmail.error = false;
            self.sendEmail.success = false;
            self.$http.post('/pid/sendlink', {idPid: self.id, email: self.sendEmail.email}, function(response){
                if(response == 10) {
                    self.sendEmail.error_two = true;
                    jQuery('#btnSendLink').html('<i class="fa fa-refresh fa-send"></i> Enviar');
                    jQuery('#btnClose').prop( "disabled", false);
                }
                else {
                    self.sendEmail.success = true;
                    jQuery('#btnSendLink').html('<i class="fa fa-refresh fa-send"></i> Enviar');
                    jQuery('#btnSendLink').prop( "disabled", false);
                    jQuery('#btnClose').prop( "disabled", false);
                }
            }).error(function(response) {
                self.sendEmail.error = true;
                jQuery('#btnSendLink').html('<span class="glyphicon glyphicon-send"></span> Enviar');
                jQuery('#btnSendLink').prop( "disabled", false);
                jQuery('#btnClose').prop( "disabled", false);
            });
        }
    },

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