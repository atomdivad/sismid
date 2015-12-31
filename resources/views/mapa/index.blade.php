@extends('app')
@section('content')

<div id="map" style="width: 100%; height: 500px;"></div>

@endsection
@section('script')
    @parent
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <script src="http://google-maps-utility-library-v3.googlecode.com/svn/tags/markerclusterer/1.0.2/src/markerclusterer.js"></script>
    <script src="{{ asset('/assets/js/mapa.js') }}"></script>


@stop