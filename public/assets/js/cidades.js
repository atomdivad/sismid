/* Busca as cidades do estado selecionado */
function getCidades(uf, selected)
{
    var cidade = $('#cidade_id');
    cidade.hide();
    $('#cidadeLoading').show();

    if(typeof cidade.data('selected') != "undefined") {
        selected = cidade.data('selected');
    }

    $.get("/api/uf/"+uf+"/cidades/", function (data) {
            cidade.empty();
            cidade.append('<option value="">Selecione a cidade</a>');
            for ($i = 0; $i < data.length; $i++) {
                if(selected == data[$i].idCidade)
                    cidade.append('<option selected value="' + data[$i].idCidade + '">' + data[$i].nomeCidade + '</a>');
                else
                    cidade.append('<option value="' + data[$i].idCidade + '">' + data[$i].nomeCidade + '</a>');
            }
            cidade.show();
            $('#cidadeLoading').hide();
        }
    );
}

function getCidadesInstituicoes(uf)
{
    var cidade = $('#buscaCidade');
    cidade.hide();
    $('#buscaCidadeLoading').show();

    $.get("/api/uf/"+uf+"/cidades/", function (data) {
            cidade.empty();

            cidade.append('<option value="0"> </a>');
            for ($i = 0; $i < data.length; $i++) {
                cidade.append('<option value="' + data[$i].idCidade + '">' + data[$i].nomeCidade + '</a>');
            }
            cidade.show();
            $('#buscaCidadeLoading').hide();
        }
    );
}


function getCidadesIniciativas(uf)
{
    var cidade = $('#iniciativaBuscaCidade');
    cidade.hide();
    $('#iniciativaBuscaCidadeLoading').show();

    $.get("/api/uf/"+uf+"/cidades/", function (data) {
            var cidade = $('#iniciativaBuscaCidade');
            cidade.empty();

            cidade.append('<option value="0"> </a>');
            for ($i = 0; $i < data.length; $i++) {
                cidade.append('<option value="' + data[$i].idCidade + '">' + data[$i].nomeCidade + '</a>');
            }
            cidade.show();
            $('#iniciativaBuscaCidadeLoading').hide();
        }
    );
}


(function() {
    $("#uf").change(function() {

        var uf =  $(this)
        getCidades(uf.val(), null);

    });

    $("#buscaUF").change(function() {

        var uf =  $(this)
        getCidadesInstituicoes(uf.val());

    });

    $("#iniciativaBuscaUF").change(function() {

        var uf =  $(this)
        getCidadesIniciativas(uf.val());

    });
}).call(this);

$(getCidades($("#uf").val()));