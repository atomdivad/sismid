<div class="form-group">
    {!! Form::label('nome', 'Nome') !!}
    {!! Form::text('nome', null, ["class" => "form-control", "autofocus"]) !!}
</div>

<div class="form-group">
    {!! Form::label('email', 'E-mail') !!}
    {!! Form::input('email', 'email', null, ["class" => "form-control"]) !!}
</div>

<div class="form-group">
    {!! Form::label('email', 'URL') !!}
    {!! Form::input('url', 'url', null, ["class" => "form-control"]) !!}
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-5">
            {!! Form::label('cep', 'CEP') !!}
            {!! Form::text('cep', null, ["class" => "form-control"]) !!}
        </div>
        <div class="col-sm-5">
            {!! Form::label('logradouro', 'Logradouro') !!}
            {!! Form::text('logradouro', null, ["class" => "form-control"]) !!}
        </div>
        <div class="col-sm-2">
            {!! Form::label('numero', 'Nº') !!}
            {!! Form::text('numero', null, ["class" => "form-control"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('complemento', 'Complemento') !!}
    {!! Form::text('complemento', null, ["class" => "form-control"]) !!}
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-2">
            {!! Form::label('uf', 'UF') !!}
            {!! Form::select('uf', $uf, null, ["class" => "form-control"]) !!}
        </div>
        <div class="col-sm-5">
            {!! Form::label('cidade_id', 'Cidade') !!}
            {!! Form::select('cidade_id', [], null, ["class" => "form-control"]) !!}
        </div>
        <div class="col-sm-5">
            {!! Form::label('bairro', 'Bairro') !!}
            {!! Form::text('bairro', null, ["class" => "form-control"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('latitude', 'Latitude') !!}
            {!! Form::text('latitude', null, ["class" => "form-control"]) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('longitude', 'Longitude') !!}
            {!! Form::text('longitude', null, ["class" => "form-control"]) !!}
        </div>
    </div>
</div>

@section('script')
    @parent
    <script>

        function getCidades(uf)
        {
            $.get("/api/uf/"+uf+"/cidades/",
                function (data) {
                    var cidade = $('#cidade_id');
                    cidade.empty();

                    cidade.append('<option value="" selected>Selecione a cidade</a>');
                    for ($i = 0; $i < data.length; $i++) {
                        cidade.append('<option value="' + data[$i].idCidade + '">' + data[$i].nomeCidade + '</a>');
                    }
                }
            );
        }

        (function() {
            $("#uf").change(function() {

                var uf =  $(this)
                getCidades(uf.val());

            });
        }).call(this);

        $(getCidades($("#uf").val()));

    </script>
@stop
