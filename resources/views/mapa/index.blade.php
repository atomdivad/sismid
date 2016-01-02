@extends('app')
@section('content')

<div id="map" style="width: 100%; height: 500px;"></div>
<div id="log"></div>


@endsection
@section('script')
    @parent
    <script src="https://maps.googleapis.com/maps/api/js"></script>
<!--    <script src="http://google-maps-utility-library-v3.googlecode.com/svn/tags/markerclusterer/1.0.2/src/markerclusterer.js"></script>-->
    <script src="{{ asset('/assets/js/markerclusterer.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/acCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/alCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/amCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/apCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/baCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/ceCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/dfCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/esCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/goCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/maCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/mgCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/msCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/mtCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/paCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/pbCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/peCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/piCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/prCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/rjCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/rnCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/roCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/rrCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/rsCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/scCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/seCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/spCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/estados/toCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/regioes/coCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/regioes/nCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/regioes/neCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/regioes/sCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/regioes/seCoords.js') }}"></script>
    <script src="{{ asset('/assets/js/infobox.js') }}"></script>
    <script src="{{ asset('/assets/js/mapa.js') }}"></script>

@stop
{{--@section("css")--}}
    {{--@parent--}}
    {{--<script src="{{ asset('/assets/css/infobox.css') }}"></script>--}}
{{--@endsection--}}