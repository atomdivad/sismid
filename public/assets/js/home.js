$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

moment.locale('pt-BR');

var grid = $("#grid-data").bootgrid({
    labels: {
        noResults: "Nenhum resultado",
        all: 'Todos',
        search: "Pesquisar",
        infos: "Exibindo {{ctx.start}} - {{ctx.end}} de {{ctx.total}} entradas"
    },

    templates: {
        search: "",
        actions: ""
    },

    caseSensitive: false,
    searchSettings: {
        delay: 100,
        characters: 3
    },
    formatters: {
        commands: function (column, row)
        {
            if(row.submetido == 1)
                return '<a href="/revisao/pid/'+row.idPid+'/confirm" class="btn btn-sm btn-primary" title="Finalizar Edição do item: '+row.nome+'" data-id="'+row.idPid+'"><span class="glyphicon glyphicon-edit"></span></a>';

            if(row.submetido == 0)
                return '<a href="#" class="btn btn-sm btn-danger command-edit" title="Cancelar revisão do item: '+row.nome+'" data-id="'+row.idRevisao+'"><span class="glyphicon glyphicon-trash"></span></a>';
        }
    },
    converters: {
        datetime: {
            from: function (value) { return moment(value); },
            to: function (value) { return moment(value).format('LLL'); }
        },

        boolean: {
            from: function (value) { return value; },
            to: function (value) { if(value == '1'){ return 'Sim' } else{ return 'Não'}; }
        }
    }
}).on("loaded.rs.jquery.bootgrid", function()
{
    grid.find(".command-edit").on("click", function(e)
    {
        removerID = $(this).data('id');
        e.preventDefault();
        $('#modalRemoveReview').modal('show');
    });
});

var dados = null;
function buscaDados() {
    $('#loading-data').show();
    $("#grid-data").bootgrid('clear');

    $.get("/home/listar", function (data) {
        dados = data;
        $("#grid-data").bootgrid('append', data);
        $('#loading-data').hide();
    }).error( function() {
        alert('Ocorreu um erro ao buscar os dados! Por favor atualize a página!');
        $('#loading-data').hide();
    });
}


var removerID = null;
var i =0;
$('#modalRemoveReview').on('show.bs.modal', function(e) {
    $("#btnConfirm").off().on('click', function(ee){
        $.get('/revisao/pid/'+removerID+'/remove')
            .done(function(data){
                $("#grid-data").bootgrid('clear');
                $(buscaDados);
                alerta(1,'Cancelado com sucesso.');
            })
            .fail(function(data){
                alerta(0,'<strong>Ops!</strong> Algo inesperado aconteceu. Atualize a página e tente novamente.');
            });

        $('#modalRemoveReview').modal('hide');
    });
});

function alerta(tipo, msg) {
    /*sucesso*/
    if(tipo == 1)
        $('#alerta').attr('class', 'alert alert-info alert-dismissable')
    /*erro*/
    if(tipo == 0)
        $('#alerta').attr('class', 'alert alert-warning alert-dismissable')
    $('.alert').show()
    $('#mensagem').html(msg);
    setTimeout(function(){ $('.alert').hide() }, 5000);
}

function filtrarTabela(filter){

    if(filter != 3) {
        var d = $.grep(dados,function(n){
            return n.submetido == filter;
        });
    }
    else {
        var d = dados;
    }

    $('#grid-data').bootgrid('clear');
    $('#grid-data').bootgrid('append', d);
};

$('#filter').on('change', function(){
    var filter = this.value;
    filtrarTabela(filter);
});

$(buscaDados)