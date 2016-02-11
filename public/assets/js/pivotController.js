$('#loading').modal('show');
//google.load("visualization", "1", {packages:["corechart", "charteditor"], 'language':'pt'});
$(function () {
    //var derivers = $.pivotUtilities.derivers;
    //var renderers = $.extend($.pivotUtilities.renderers,
    //    $.pivotUtilities.gchart_renderers);
    $.getJSON("/report/pivoteamento/dados", function (mps) {
        $("#output").pivotUI(mps, {
            //renderers: renderers,
            rows: ["UF", "Iniciativas"],
            cols: ["Tipo", "Localização"],
            aggregatorName: "Contagem",
            // vals: ["Tipo"],
            rendererName: "Mapa de Calor por Colunas"
        }, false, "pt");
        $('#loading').modal('hide');
    });
});
