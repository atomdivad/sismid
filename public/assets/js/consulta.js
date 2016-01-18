$("#tipoBusca").select2();

var grid = $("#grid-data").bootgrid({
    labels: {
        noResults: "Nenhum resultado",
        all: 'Todos',
        search: "Pesquisar",
        infos: "Exibindo {{ctx.start}} - {{ctx.end}} de {{ctx.total}} entradas"
    },
    caseSensitive: false,
    searchSettings: {
        delay: 100,
        characters: 3
    },
    formatters: {
        commands: function (column, row)
        {
            return '<a href="#" class="btn btn-sm btn-primary command-edit" data-id="'+row.id+'" data-tipo="'+row.tipo+'"><span class="glyphicon glyphicon-eye-open"></span></a>';
        }
    }
}).on("loaded.rs.jquery.bootgrid", function()
{
    grid.find(".command-edit").on("click", function(e)
    {
        e.preventDefault();
        if($(this).data('tipo') == "PID"){
            infoPid.$data.id = $(this).data('id');
            $('#modalInfoPid').modal('toggle');
        }
        else if($(this).data('tipo') == "Iniciativa"){
            infoIniciativa.$data.id = $(this).data('id');
            $('#modalInfoIniciativa').modal('toggle');
        }
    });
});


$('#searchInput').on('keyup', function() {
    var pesq = $('#searchInput').val();
    $("#grid-data").bootgrid("search", pesq);
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

buscaDados();

function buscaDados() {
    $("#msg").hide();
    if($("#tipoBusca").val() == null) {
        $("#msg").show();
        return false;
    }
    $('#loading').modal('show');
    var dados = {
        agrupamento: $("#agrupamento").val(),
        uf: $("#uf").val(),
        cidade: $("#cidade_id").val(),
        tipo: $("#tipoBusca").val(),
        ativo: $("#ativo").val(),
        localizacao: $("#localizacao").val()
    }

    $("#grid-data").bootgrid('clear');

    $.post("/consulta", dados ,function (data) {
        markerDesagrupados(data.pids, 'PID');
        markerDesagrupados(data.iniciativas, 'Iniciativa');
        $('#loading').modal('hide');
    });
}

function markerDesagrupados(list, tipo) {
    var pontos = [];
    $.each(list, function (i, item) {
        pontos.push({
            nome: item.nome,
            id: item.id,
            endereco: item.logradouro + ', ' + item.numero,
            nomeCidade: item.nomeCidade,
            uf: item.uf,
            tipo: tipo
        });
    });
    $("#grid-data").bootgrid('append', pontos);
}

$( "#btnFiltrar" ).click(function() {
    buscaDados();
});

$( "#btnClear" ).click(function() {
    $("#grid-data").bootgrid("destroy").bootgrid("search",  $('#searchInput').val());
    $('#searchInput').val('');
    $("#uf").val(0);
    $("#cidade_id").html('');
    $("#agrupamento").val(0);
    $("#ativo").val(1);
    $("#localizacao").val(3);

    buscaDados();
});

var infoPid = new Vue({
    el: '#modalInfoPid',

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

var infoIniciativa = new Vue({
    el: '#modalInfoIniciativa',

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