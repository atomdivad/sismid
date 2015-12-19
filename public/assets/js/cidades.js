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

(function() {
    $("#uf").change(function() {

        var uf =  $(this)
        getCidades(uf.val(), null);

    });
}).call(this);

$(getCidades($("#uf").val()));