$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//$('#loading').modal('show');
google.maps.event.addDomListener(window, 'load', initialize);

var map;
var markers = [];
var markerCluster = [];
function initialize() {
    var options = {
        zoom: 4,
        center: {lat: -15.780, lng: -47.929},
        streetViewControl: false,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.SMALL
        },
        style: google.maps.ZoomControlStyle.ROADMAP
    }
    //mapTypeId: google.maps.MapTypeId.ROADMAP
    map = new google.maps.Map(document.getElementById('map'), options);
    //buscaDados();
}

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
        tipo: $("#tipoBusca").val()
    }

    $("#grid-data").bootgrid('clear');

    $.post("/api/mapa", dados ,function (data) {
        if(dados.agrupamento == 0) {
            markerDesagrupados(data.pids, 'PID');
            markerDesagrupados(data.iniciativas, 'Iniciativa');

            markerCluster = new MarkerClusterer(map, markers);
            /*Ouvir click em cluster*/
            google.maps.event.addListener(markerCluster, "click", function (c) {
                var m = c.getMarkers();
                pontos = [];
                for (var i = 0; i < m.length; i++ ){
                    pontos.push({
                        id: m[i].id ,
                        nome: m[i].nome,
                        endereco: m[i].endereco,
                        nomeCidade: m[i].nomeCidade,
                        uf: m[i].uf,
                        tipo: m[i].tipo
                    });
                }
                $("#grid-data").bootgrid('clear');
                $("#grid-data").bootgrid('append', pontos);
            });
            google.maps.event.addListener(markerCluster, 'clusteringend', function(){
                $('#loading').modal('hide');
            });
        }
        else if(dados.agrupamento == 'estado') {
            markerAgrupadosEstado(data)
        }
        else if(dados.agrupamento == 'regiao') {
            markerAgrupadosRegiao(data)
        }
    });
}

function markerDesagrupados(list, tipo) {
    var pontos = [];
    var latLng;
    var marker;
    $.each(list, function (i, item) {
        pontos.push({
            nome: item.nome,
            id: item.id.toString(),
            endereco: item.logradouro + ', ' + item.numero,
            nomeCidade: item.nomeCidade,
            uf: item.uf,
            tipo: tipo
        });
        latLng = new google.maps.LatLng(item.latitude, item.longitude);
        marker = new google.maps.Marker({
            map: map,
            position: latLng,
            title: item.nome,
            id: item.id.toString(),
            nome: item.nome,
            endereco: item.logradouro + ', ' + item.numero,
            nomeCidade: item.nomeCidade,
            uf: item.uf,
            tipo: tipo,
            visible: true
        });
        markers.push(marker);
        /*Ouvir click em marcador*/
        marker.addListener('click', function () {
            var self = this;
            var mk = {
                id: self.id,
                nome: self.nome,
                endereco: self.endereco,
                nomeCidade: self.nomeCidade,
                uf: self.uf,
                tipo: self.tipo
            };
            $("#grid-data").bootgrid('clear');
            $("#grid-data").bootgrid('append', [mk]);
        });
    });
    $("#grid-data").bootgrid('append', pontos);
    $("#grid").show();
}

function markerAgrupadosEstado(list) {
    $("#grid").hide();
    var latLng;
    var marker;
    $.each(list, function (i, item) {
        latLng = new google.maps.LatLng(item.latitude, item.longitude);
        marker = new google.maps.Marker({
            map: map,
            position: latLng,
            visible: true
        });
        markers.push(marker);
    });
    markerCluster = new MarkerClusterer(map, markers, {
        maxZoom: 9,
        gridSize: 1
    });
    estado();
    google.maps.event.addListener(markerCluster, 'clusteringend', function(){
        $('#loading').modal('hide');
    });
}

function markerAgrupadosRegiao(list) {
    $("#grid").hide();
    $("#piechart").show();
    var latLng;
    var marker;
    $.each(list, function (i, item) {
        latLng = new google.maps.LatLng(item.latitude, item.longitude);
        marker = new google.maps.Marker({
            map: map,
            position: latLng,
            visible: true
        });
        markers.push(marker);
    });
    markerCluster = new MarkerClusterer(map, markers, {
        maxZoom: 9,
        gridSize: 1
    });
    regiao();
    google.maps.event.addListener(markerCluster, 'clusteringend', function(){
        $('#loading').modal('hide');
    });
}

var polygon =  [];
function estado(){
    polygon[0] = new google.maps.Polygon({
	    paths: acCoords,
	    strokeColor: '#8122e5',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#8122e5',
	    fillOpacity: 0.5
	  });
	polygon[0].setMap(map);

	//alCoords.js
	polygon[1] = new google.maps.Polygon({
	    paths: alCoords,
	    strokeColor: '#e96189',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#e96189',
	    fillOpacity: 0.5
	  });
	polygon[1].setMap(map);
	//amCoords.js
	polygon[2] = new google.maps.Polygon({
	    paths: amCoords,
	    strokeColor: '#FF0000',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#FF0000',
	    fillOpacity: 0.5
	  });
	polygon[2].setMap(map);
	//apCoords.js
	polygon[3] = new google.maps.Polygon({
	    paths: apCoords,
	    strokeColor: '#dee4a7',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#dee4a7',
	    fillOpacity: 0.5
	  });
	polygon[3].setMap(map);
	//baCoords.js
	polygon[4] = new google.maps.Polygon({
	    paths: baCoords,
	    strokeColor: '#abaca6',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#abaca6',
	    fillOpacity: 0.5
	  });
	polygon[4].setMap(map);
	//ceCoords.js
	polygon[5] = new google.maps.Polygon({
	    paths: ceCoords,
	    strokeColor: '#418e85',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#418e85',
	    fillOpacity: 0.5
	  });
	polygon[5].setMap(map);
	//dfCoords.js
	polygon[6] = new google.maps.Polygon({
	    paths: dfCoords,
	    strokeColor: '#67f9f0',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#67f9f0',
	    fillOpacity: 0.5
	  });
	polygon[6].setMap(map);
	//esCoords.js
	polygon[7] = new google.maps.Polygon({
	    paths: esCoords,
	    strokeColor: '#40b597',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#40b597',
	    fillOpacity: 0.5
	  });
	polygon[7].setMap(map);
	//goCoords.js
	polygon[8] = new google.maps.Polygon({
	    paths: goCoords,
	    strokeColor: '#67f9f0',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#67f9f0',
	    fillOpacity: 0.5
	  });
	polygon[8].setMap(map);
	//maCoords.js
	polygon[9] = new google.maps.Polygon({
	    paths: maCoords,
	    strokeColor: '#f15f99',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#f15f99',
	    fillOpacity: 0.5
	  });
	polygon[9].setMap(map);
	//mgCoords.js
	polygon[10] = new google.maps.Polygon({
	    paths: mgCoords,
	    strokeColor: '#f23b1c',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#f23b1c',
	    fillOpacity: 0.5
	  });
	polygon[10].setMap(map);
	//msCoords.js
	polygon[11] = new google.maps.Polygon({
	    paths: msCoords,
	    strokeColor: '#ffd64d',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#ffd64d',
	    fillOpacity: 0.5
	  });
	polygon[11].setMap(map);
	//mtCoords.js
	polygon[12] = new google.maps.Polygon({
	    paths: mtCoords,
	    strokeColor: '#ab1f1c',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#ab1f1c',
	    fillOpacity: 0.5
	  });
	polygon[12].setMap(map);
	//paCoords.js
	polygon[13] = new google.maps.Polygon({
	    paths: paCoords,
	    strokeColor: '#00f7b3',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#00f7b3',
	    fillOpacity: 0.5
	  });
	polygon[13].setMap(map);
	//pbCoords.js
	polygon[14] = new google.maps.Polygon({
	    paths: pbCoords,
	    strokeColor: '#ca29a1',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#ca29a1',
	    fillOpacity: 0.5
	  });
	polygon[14].setMap(map);
	//peCoords.js
	polygon[15] = new google.maps.Polygon({
	    paths: peCoords,
	    strokeColor: '#6bd29c',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#6bd29c',
	    fillOpacity: 0.5
	  });
	polygon[15].setMap(map);
	//piCoords.js
	polygon[16] = new google.maps.Polygon({
	    paths: piCoords,
	    strokeColor: '#97d12d',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#97d12d',
	    fillOpacity: 0.5
	  });
	polygon[16].setMap(map);
	//prCoords.js
	polygon[17] = new google.maps.Polygon({
	    paths: prCoords,
	    strokeColor: '#32533a',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#32533a',
	    fillOpacity: 0.5
	  });
	polygon[17].setMap(map);
	//rjCoords.js
	polygon[18] = new google.maps.Polygon({
	    paths: rjCoords,
	    strokeColor: '#e1f00d',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#e1f00d',
	    fillOpacity: 0.5
	  });
	polygon[18].setMap(map);
	//rnCoords.js
	polygon[19] = new google.maps.Polygon({
	    paths: rnCoords,
	    strokeColor: '#7197e9',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#7197e9',
	    fillOpacity: 0.5
	  });
	polygon[19].setMap(map);
	//roCoords.js
	polygon[20] = new google.maps.Polygon({
	    paths: roCoords,
	    strokeColor: '#32e185',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#32e185',
	    fillOpacity: 0.5
	  });
	polygon[20].setMap(map);
	//rrCoords.js
	polygon[21] = new google.maps.Polygon({
	    paths: rrCoords,
	    strokeColor: '#f49a2b',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#f49a2b',
	    fillOpacity: 0.5
	  });
	polygon[21].setMap(map);
	//rsCoords.js
	polygon[22] = new google.maps.Polygon({
	    paths: rsCoords,
	    strokeColor: '#af5cd0',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#af5cd0',
	    fillOpacity: 0.5
	  });
	polygon[22].setMap(map);
	//scCoords.js
	polygon[23] = new google.maps.Polygon({
	    paths: scCoords,
	    strokeColor: '#d07613',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#d07613',
	    fillOpacity: 0.5
	  });
	polygon[23].setMap(map);
	//seCoords.js
	polygon[24] = new google.maps.Polygon({
	    paths: seCoords,
	    strokeColor: '#9dc1e0',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#9dc1e0',
	    fillOpacity: 0.5
	  });
	polygon[24].setMap(map);
	//spCoords.js
	polygon[25] = new google.maps.Polygon({
	    paths: spCoords,
	    strokeColor: '#c8a4b5',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#c8a4b5',
	    fillOpacity: 0.5
	  });
	polygon[25].setMap(map);
	//toCoords.js
	polygon[26] = new google.maps.Polygon({
	    strokeColor: '#f5802d',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#f5802d',
	    fillOpacity: 0.5
	  });
	polygon[26].setMap(map);
}

var allPolygon = []
function regiao() {
    // N
    for (var i = 0; i < nCoords.length; i++) {
        var coords = nCoords[i];
        var polygon = new google.maps.Polygon({
            paths: coords,
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 0,
            fillColor: '#FF0000',
            fillOpacity: 0.5
        });
        polygon.setMap(map);
        allPolygon.push(polygon);
    }

    //NE
    for (var i = 0; i < neCoords.length; i++) {
        var coords = neCoords[i];
        var polygon = new google.maps.Polygon({
            paths: coords,
            strokeColor: '#004b00',
            strokeOpacity: 0.8,
            strokeWeight: 0,
            fillColor: '#004b00',
            fillOpacity: 0.5
        });
        polygon.setMap(map);
        allPolygon.push(polygon);
    }

    //CO
    for (var i = 0; i < coCoords.length; i++) {
        var coords = coCoords[i];
        var polygon = new google.maps.Polygon({
            paths: coords,
            strokeColor: '#3131cd',
            strokeOpacity: 0.8,
            strokeWeight: 0,
            fillColor: '#3131cd',
            fillOpacity: 0.5
        });
        polygon.setMap(map);
        allPolygon.push(polygon);
    }

    //S
    for (var i = 0; i < sCoords.length; i++) {
        var coords = sCoords[i];
        var polygon = new google.maps.Polygon({
            paths: coords,
            strokeColor: '#7e30cd',
            strokeOpacity: 0.8,
            strokeWeight: 0,
            fillColor: '#7e30cd',
            fillOpacity: 0.5
        });
        polygon.setMap(map);
        allPolygon.push(polygon);
    }

    //SE
    for (var i = 0; i < seCoords.length; i++) {
        var coords = seCoords[i];
        var polygon = new google.maps.Polygon({
            paths: coords,
            strokeColor: '#ffd700',
            strokeOpacity: 0.8,
            strokeWeight: 0,
            fillColor: '#ffd700',
            fillOpacity: 0.5
        });
        polygon.setMap(map);
        allPolygon.push(polygon);
    }
}

function estadoRemove() {
    for(var i = 0; i < polygon.length; i++)
        polygon[i].setMap(null);
}

function regiaoRemove() {
    $.each(allPolygon, function(i, item){
       item.setMap(null);
    });
}

function resetMap() {
    var newLatLng = new google.maps.LatLng(-15.780,-47.929);
    map.setCenter(newLatLng);
    map.setZoom(4);
}

$( "#btnFiltrar" ).click(function() {
    if(polygon.length > 0) {
        estadoRemove();
    }
    if(allPolygon.length > 0) {
        regiaoRemove();
    }
    if(markerCluster.length > 0)
        markerCluster.clearMarkers();
    markers = [];
    buscaDados();
    resetMap();
});

$( "#btnClear" ).click(function() {
    var aux = $("#agrupamento").val();
    $("#agrupamento").val(0);
    $("#uf").val(0);
    $("#cidade_id").html('');
    markerCluster.clearMarkers();
    markers = [];
    buscaDados();
    if(polygon.length > 0) {
        estadoRemove();
    }
    if(allPolygon.length > 0) {
        regiaoRemove();
    }
    resetMap();
});


var pidGrid = $("#grid-data").bootgrid({
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
            return '<a href="#" class="btn btn-sm btn-primary command-edit" data-id="'+row.id+'" data-tipo="'+row.tipo+'"><span class="glyphicon glyphicon-eye-open"></span></a>';       }
    }
}).on("loaded.rs.jquery.bootgrid", function()
{
    pidGrid.find(".command-edit").on("click", function(e)
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