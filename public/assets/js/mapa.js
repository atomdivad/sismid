var map;
var markers = [];
var markerCluster = [];
function initialize() {
    var options = {
        zoom: 4,
        center: {lat: -15.780, lng: -47.929},
        streetViewControl: false,

        zoomControlOptions: {

            //style: google.maps.ZoomControlStyle.SMALL
           style: google.maps.ZoomControlStyle.ROADMAP
        },
        //mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('map'), options);

    if(1){
        var url = "/api/mapa";
        //estado();
    }else{
        var url = "/api/mapa?agrupamento=regiao";
        regiao();
    }
    $.get(url, function (data) {
        $.each(data, function (i, item) {
            //console.log(item.latitude, item.longitude);

            var latLng = new google.maps.LatLng(item.latitude, item.longitude);
            var marker = new google.maps.Marker({
                map: map,
                position: latLng,
                title: item.nome,
				idpid: item.idPid.toString(),
                visible: true
            });
            markers.push(marker);

          marker.addListener('click', function(){

              //https://developers.google.com/maps/documentation/javascript/examples/event-closure
                log(latLng);
              //console.log(latLng.toString());
          });
        });
        markerCluster = new MarkerClusterer(map, markers, {averageCenter: true
                });

        google.maps.event.addListener(markerCluster, "click", function (c) {
              //log("click: ");
              //log("&mdash;Center of cluster: " + c.getCenter());
              //log("&mdash;Number of managed markers in cluster: " + c.getSize());
              var m = c.getMarkers();
              var p = [];
              for (var i = 0; i < m.length; i++ ){
                p.push(m[i].idPid + " " + m[i].title);
              }

              log("&mdash;Locations of managed markers: " + p.join(", "));

            });
    });

}
function log(h){
    document.getElementById("log").innerHTML = h + "<br />";
}

function AgrupamentoEstado(){
    var polygon = new google.maps.Polygon({
	    paths: acCoords,
	    strokeColor: '#8122e5',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#8122e5',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//alCoords.js
	var polygon = new google.maps.Polygon({
	    paths: alCoords,
	    strokeColor: '#e96189',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#e96189',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//amCoords.js
	var polygon = new google.maps.Polygon({
	    paths: amCoords,
	    strokeColor: '#FF0000',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#FF0000',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//apCoords.js
	var polygon = new google.maps.Polygon({
	    paths: apCoords,
	    strokeColor: '#dee4a7',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#dee4a7',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//baCoords.js
	var polygon = new google.maps.Polygon({
	    paths: baCoords,
	    strokeColor: '#abaca6',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#abaca6',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//ceCoords.js
	var polygon = new google.maps.Polygon({
	    paths: ceCoords,
	    strokeColor: '#418e85',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#418e85',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//dfCoords.js
	var polygon = new google.maps.Polygon({
	    paths: dfCoords,
	    strokeColor: '#67f9f0',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#67f9f0',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//esCoords.js
	var polygon = new google.maps.Polygon({
	    paths: esCoords,
	    strokeColor: '#40b597',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#40b597',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//goCoords.js
	var polygon = new google.maps.Polygon({
	    paths: goCoords,
	    strokeColor: '#67f9f0',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#67f9f0',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//maCoords.js
	var polygon = new google.maps.Polygon({
	    paths: maCoords,
	    strokeColor: '#f15f99',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#f15f99',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//mgCoords.js
	var polygon = new google.maps.Polygon({
	    paths: mgCoords,
	    strokeColor: '#f23b1c',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#f23b1c',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//msCoords.js
	var polygon = new google.maps.Polygon({
	    paths: msCoords,
	    strokeColor: '#ffd64d',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#ffd64d',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//mtCoords.js
	var polygon = new google.maps.Polygon({
	    paths: mtCoords,
	    strokeColor: '#ab1f1c',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#ab1f1c',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//paCoords.js
	var polygon = new google.maps.Polygon({
	    paths: paCoords,
	    strokeColor: '#00f7b3',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#00f7b3',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//pbCoords.js
	var polygon = new google.maps.Polygon({
	    paths: pbCoords,
	    strokeColor: '#ca29a1',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#ca29a1',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//peCoords.js
	var polygon = new google.maps.Polygon({
	    paths: peCoords,
	    strokeColor: '#6bd29c',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#6bd29c',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//piCoords.js
	var polygon = new google.maps.Polygon({
	    paths: piCoords,
	    strokeColor: '#97d12d',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#97d12d',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//prCoords.js
	var polygon = new google.maps.Polygon({
	    paths: prCoords,
	    strokeColor: '#32533a',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#32533a',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//rjCoords.js
	var polygon = new google.maps.Polygon({
	    paths: rjCoords,
	    strokeColor: '#e1f00d',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#e1f00d',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//rnCoords.js
	var polygon = new google.maps.Polygon({
	    paths: rnCoords,
	    strokeColor: '#7197e9',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#7197e9',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//roCoords.js
	var polygon = new google.maps.Polygon({
	    paths: roCoords,
	    strokeColor: '#32e185',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#32e185',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//rrCoords.js
	var polygon = new google.maps.Polygon({
	    paths: rrCoords,
	    strokeColor: '#f49a2b',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#f49a2b',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//rsCoords.js
	var polygon = new google.maps.Polygon({
	    paths: rsCoords,
	    strokeColor: '#af5cd0',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#af5cd0',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//scCoords.js
	var polygon = new google.maps.Polygon({
	    paths: scCoords,
	    strokeColor: '#d07613',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#d07613',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//seCoords.js
	var polygon = new google.maps.Polygon({
	    paths: seCoords,
	    strokeColor: '#9dc1e0',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#9dc1e0',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//spCoords.js
	var polygon = new google.maps.Polygon({
	    paths: spCoords,
	    strokeColor: '#c8a4b5',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#c8a4b5',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);
	//toCoords.js
	var polygon = new google.maps.Polygon({
	    strokeColor: '#f5802d',
	    strokeOpacity: 0.8,
	    strokeWeight: 0,
	    fillColor: '#f5802d',
	    fillOpacity: 0.5
	  });
	polygon.setMap(map);

    //$.get("/api/mapa", function (data) {
    //       dados.push(data);
    //       $.each(data, function(i, item) {
    //           //console.log(item.latitude, item.longitude);
    //
    //           var latLng = new google.maps.LatLng(item.latitude, item.longitude);
    //           var marker = new google.maps.Marker({
    //               position: latLng
    //           });
    //           markers.push(marker);
    //
    //       });
    //    var markerCluster = new MarkerClusterer(map, markers);
    //});

}

function AgrupamentoRegiao() {
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
    }

}
google.maps.event.addDomListener(window, 'load', initialize);
