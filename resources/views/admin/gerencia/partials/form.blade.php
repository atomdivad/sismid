<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('nome', 'Nome*') !!}
            {!! Form::text('nome', null, ["class" => "form-control", "autofocus"]) !!}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('sobrenome', 'Sobrenome*') !!}
            {!! Form::text('sobrenome', null, ["class" => "form-control"]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('email', 'E-mail*') !!}
            {!! Form::input('email', 'email', null, ["class" => "form-control"]) !!}

        </div>
    </div>
</div>

