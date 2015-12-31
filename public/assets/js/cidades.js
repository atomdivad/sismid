/* Busca as cidades do estado selecionado */
function getCidades(uf, selected)
{
    $.get("/api/uf/"+uf+"/cidades/",
        function (data) {
            var cidade = $('#cidade_id');
            cidade.empty();

            cidade.append('<option value="">Selecione a cidade</a>');
            for ($i = 0; $i < data.length; $i++) {
                if(selected == data[$i].idCidade)
                    cidade.append('<option selected value="' + data[$i].idCidade + '">' + data[$i].nomeCidade + '</a>');
                else
                    cidade.append('<option value="' + data[$i].idCidade + '">' + data[$i].nomeCidade + '</a>');
            }
        }
    );
}

function getCidadesInstituicoes(uf)
{
    $.get("/api/uf/"+uf+"/cidades/",
        function (data) {
            var cidade = $('#buscaCidade');
            cidade.empty();

            cidade.append('<option value="0"> </a>');
            for ($i = 0; $i < data.length; $i++) {
                cidade.append('<option value="' + data[$i].idCidade + '">' + data[$i].nomeCidade + '</a>');
            }
        }
    );
}


function getCidadesIniciativas(uf)
{
    $.get("/api/uf/"+uf+"/cidades/",
        function (data) {
            var cidade = $('#iniciativaBuscaCidade');
            cidade.empty();

            cidade.append('<option value="0"> </a>');
            for ($i = 0; $i < data.length; $i++) {
                cidade.append('<option value="' + data[$i].idCidade + '">' + data[$i].nomeCidade + '</a>');
            }
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