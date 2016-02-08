@extends('app')
@section('content')
    {!! Breadcrumbs::render('reportIndexPidPivot') !!}
<div id="output" style="margin: 30px;"></div>

@endsection
@section('script')
    @parent

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-csv/0.71/jquery.csv-0.71.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.js"></script>

    <script src="{{ asset('/assets/js/pivot/gchart_renderers.js') }}"></script>
    <script src="{{ asset('/assets/js/pivot/d3_renderers.js') }}"></script>
    <script src="{{ asset('/assets/js/pivot/c3_renderers.js') }}"></script>
    <script src="{{ asset('/assets/js/pivot/export_renderers.js') }}"></script>
    <script src="{{ asset('/assets/js/pivot/pivot.js') }}"></script>
    <script src="{{ asset('/assets/js/pivot/pivot.pt.js') }}"></script>
    <script src="{{ asset('/assets/js/pivotController.js') }}"></script>
@endsection
@section('css')
    <link href="{{ asset('/assets/css/pivot.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.css">
@stop
