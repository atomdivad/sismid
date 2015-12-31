
//$.get( "/api/mapa", function( data ) {
//    console.log(JSON.stringify(data));
//});
//
//function initMap() {
//    var map = new google.maps.Map(document.getElementById('mapa'), {
//        zoom: 4,
//        center: {lat: -15.780, lng: -47.929},
//        mapTypeId: google.maps.MapTypeId.ROADMAP
//    });
//    //var mcOptions = {gridSize: 50, maxZoom: 15};
//    //var mc = new MarkerClusterer(map, [], mcOptions);
//    //var geocoder = new google.maps.Geocoder();
//
//    var markers = [];
//    for (var i = 0; i < 100; i++) {
//        var dataPhoto = dados.photos[i];
//        var latLng = new google.maps.LatLng(dataPhoto.latitude,
//            dataPhoto.longitude);
//        var marker = new google.maps.Marker({
//            position: latLng
//        });
//        markers.push(marker);
//    }
//    var markerCluster = new MarkerClusterer(mapa, markers);
//
////google.maps.event.addDomListener(window, 'load', initMap);
//    //HTML5 geolocation.
//    //if (navigator.geolocation) {
//    //    navigator.geolocation.getCurrentPosition(function(position) {
//    //        var pos = {
//    //            lat: position.coords.latitude,
//    //            lng: position.coords.longitude
//    //        };
//    //        map.setCenter(pos);
//    //    });
//    //}
//}

var dados = [];

function initialize() {
    var center = new google.maps.LatLng(37.4419, -122.1419);

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
        center: {lat: -15.780, lng: -47.929},
        //mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var markers = [];

    $.get("/api/mapa", function (data) {
           dados.push(data);
           $.each(data, function(i, item) {
               console.log(item.latitude, item.longitude);

               var latLng = new google.maps.LatLng(item.latitude, item.longitude);
               var marker = new google.maps.Marker({
                   position: latLng
               });
               markers.push(marker);

           });
        var markerCluster = new MarkerClusterer(map, markers);
    });

}

google.maps.event.addDomListener(window, 'load', initialize);