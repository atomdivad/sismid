$(function () {
    $.getJSON("/report/pivoteamento/dados", function (mps) {
        $("#output").pivotUI(mps, {
            rows: ["UF", "Iniciativas"],
            cols: ["Tipo", "Localização"],
            aggregatorName: "Contagem",
            // vals: ["Tipo"],
            rendererName: "Mapa de Calor por Colunas"
        }, false, "pt");
    });
});
