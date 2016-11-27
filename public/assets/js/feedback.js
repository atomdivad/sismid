$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').val()
    }
});
$("#confirm").on('click', function(){
    $(this).html('<span class="fa fa-refresh fa-spin"></span> Enviando...');
    $(this).prop( "disabled", true);
    $('#cancel').prop( "disabled", true);
    var data = {
        nome: $('#nome').val(),
        email: $('#email').val(),
        msg: $('#msg').val()
    }

    $.post('/feedback', data, function(){
        clearInput();
        $('#confirm').html('<i class="fa fa-send"></i> Enviar');
        $('#confirm').prop( "disabled", false);
        $('#cancel').prop( "disabled", false);
        $('#feedBackModal').modal('hide');
        alert('Mensagem Enviada! Obrigado!');

    }).error(function() {
        alert('Erro ao enviar mensagem! Tente Novamente!');
        $('#confirm').html('<i class="fa fa-send"></i> Enviar');
        $('#confirm').prop( "disabled", false);
        $('#cancel').prop( "disabled", false);
    });
});

function clearInput() {
    $('#nome').val('');
    $('#email').val('');
    $('#msg').val('');
}