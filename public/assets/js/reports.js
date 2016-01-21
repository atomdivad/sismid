$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#regiao').hide();
$('#estado').hide();

var chart = '';
$(".openModal").on('click', function(){
    chart = $(this).data('chart');
});
$('#exibir').on('change',function() {
    var op = $(this).val()
    if(op == 1) {
        $('#regiao').hide();
        $('#estado').hide();
    }
    if(op == 2) {
        $('#regiao').show();
        $('#estado').hide();
    }

    if(op == 3) {
        $('#regiao').hide();
        $('#estado').show();
    }
});

$("#apply").on('click', function(){
    var op = $('#exibir').val(), dados, self = $(this);
    if(op == 1) {
        dados = {
            type: 'geral'
        }
    }
    if(op == 2) {
        dados = {
            type: 'regiao',
            regiao: $('#regioes').val()
        }
    }

    if(op == 3) {
        dados = {
            type: 'estado',
            uf: $("#uf").val(),
            cidade: $("#cidade_id").val()
        }
    }

    self.html('<span class="fa fa-refresh fa-spin"></span> Carregando...');
    self.prop( "disabled", true );
    $('#cancel').prop( "disabled", true );


    var url = '';
    switch (chart) {
        case 'PidStatus':
            url = '/report/pid/status';
            break;

        case 'PidTipos':
            url = '/report/pid/tipo';
            break;

        case 'PidIniciativa':
            url = '/report/pid/iniciativa';
            break;

        case 'PidInstituicao':
            url = '/report/pid/instituicao';
            break;

        case 'PidLocalizcao':
            url = '/report/pid/localizacao';
            break;

        case 'PidLocalidade':
            url = '/report/pid/localidade';
            break;
    }

    $.post(url, dados, function (dataTableJson) {
        lava.loadData(chart, dataTableJson, function (chart) {
            $('#modalConf').modal('hide');
            self.html('<span class="fa fa-check"></span> Aplicar');
            self.prop( "disabled", false );
            $('#cancel').prop( "disabled", false );
        });
    }).error(function(){
        self.html('<span class="fa fa-check"></span> Aplicar');
        self.prop( "disabled", false );
        $('#cancel').prop( "disabled", false );
    });
});


/*
$('a#pidStatusBtn').on('click', function(ev){
    ev.preventDefault();
    $.post('/report/pidStatus',{dados: 'dados'}, function (dataTableJson) {
        lava.loadData('PidStatus', dataTableJson, function (chart) {
            console.log(chart);
        });
    });

    $.getJSON('/report/pidLocalizacao', function (dataTableJson) {
        lava.loadData('PidLocalizcao', dataTableJson, function (chart) {
            console.log(chart);
        });
    });

    $.getJSON('/report/pidTipo', function (dataTableJson) {
        lava.loadData('PidTipos', dataTableJson, function (chart) {
            console.log(chart);
        });
    });

    $.getJSON('/report/iniciativaTipo', function (dataTableJson) {
        lava.loadData('InicativaTipos', dataTableJson, function (chart) {
            console.log(chart);
        });
    });

    $.getJSON('/report/iniciativaCategoria', function (dataTableJson) {
        lava.loadData('InicativaCategorias', dataTableJson, function (chart) {
            console.log(chart);
        });
    });

    $.getJSON('/report/iniciativaNatureza', function (dataTableJson) {
        lava.loadData('InicativaNaturezas', dataTableJson, function (chart) {
            console.log(chart);
        });
    });

    $.getJSON('/report/iniciativaLocalizacao', function (dataTableJson) {
        lava.loadData('iniciativaLocalizcao', dataTableJson, function (chart) {
            console.log(chart);
        });
    });

});*/
