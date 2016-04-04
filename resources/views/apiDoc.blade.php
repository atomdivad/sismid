@extends('app')
@section('content')
    {!! Breadcrumbs::render('api') !!}

    <h3>PID</h3>
    <div class="panel panel-default" id="getPids">
        <div class="panel-heading">Obter lista de PIDs</div>
        <div class="panel-body">

            <p>
                Retorna uma lista com todos os PIDs ativos cadastrados. <br/>
                <strong>{{ url('/') }}/api/pid</strong>
            </p>

            <p>
                Para obter a lista de PIDs de um determinado Estado use o parametro <b>uf</b><br/>
                <strong>{{ url('/') }}/api/pid?uf=xx</strong>
                <small class="alert-warning">(xx = AC, MT, DF, SP, etc)</small>
                <br/> ou <br/>
                <strong>{{ url('/') }}/api/pid?uf=#</strong>
                <small class="alert-warning">(# obtido em <a href="#" onclick="scrollTo('#getUf');">{{ url('/') }}/api/uf</a>)</small>
            </p>

            <p>
                Para obter a lista de PIDs de um determinado Município use o parametro <b>cidade</b><br/>
                <strong>{{ url('/') }}/api/pid?cidade=#</strong>
                <small class="alert-warning">(# obtido em <a href="#" onclick="scrollTo('#getCidades');">{{ url('/') }}/api/uf/#/cidades</a>)</small>
            </p>

            <strong>As informações retornadas para cada PID da lista são: </strong>
            <ul>
                <li>idPid</li>
                <li>nome</li>
                <li>nomeCidade</li>
                <li>uf</li>
            </ul>

        </div>
    </div>

    <div class="panel panel-default" id="getPid">
        <div class="panel-heading">Obter informações de um PID</div>
        <div class="panel-body">
            <p>
                Retorna todas as informações de um PID.
            </p>
            <strong>{{ url('/') }}/api/pid/#/show</strong>
            <small class="alert-warning">
                (# obtido em <a href="#" onclick="scrollTo('#getPids')">{{ url('/') }}/api/pid</a> ou
                <a href="#" onclick="scrollTo('#getIniciativaPid')">{{ url('/') }}/api/iniciativa/#/pid</a>)
            </small>
        </div>
    </div>

    <div class="panel panel-default" id="getFoto">
        <div class="panel-heading">Obter foto de um PID</div>
        <div class="panel-body">
            <p>
                Retorna a foto (quando houver) de um PID. <br/>
                <strong>{{ url('/') }}/api/#/fotos/{nome}</strong>
                <small class="alert-warning">(# = idPid; {nome} = nome da foto obtido em <a href="#" onclick="scrollTo('#getPid')">{{ url('/') }}/api/pid/#/show</a>)</small>
            </p>
        </div>
    </div>

    <h3>Iniciativa</h3>
    <div class="panel panel-default" id="getIniciativas">
        <div class="panel-heading">Obter lista de Iniciativas</div>
        <div class="panel-body">
            <p>
                Retorna a lista de Iniciativas cadastradas. <br/>
                <strong>{{ url('/') }}/api/iniciativa</strong>
            </p>

            <p>
                Para obter a lista de Iniciativas de um determinado Estado use o parametro <b>uf</b><br/>
                <strong>{{ url('/') }}/api/iniciativa?uf=xx</strong>
                <small class="alert-warning">(xx = AC, MT, DF, SP, etc)</small>
                <br/> ou <br/>
                <strong>{{ url('/') }}/api/iniciativa?uf=#</strong>
                <small class="alert-warning">(# obtido em <a href="#" onclick="scrollTo('#getUf');">{{ url('/') }}/api/uf</a>)</small>
            </p>

            <p>
                Para obter a lista de Iniciativas de um determinado Município use o parametro <b>cidade_id</b><br/>
                <strong>{{ url('/') }}/api/iniciativa?cidade_id=#</strong>
                <small class="alert-warning">(# obtido em <a href="#" onclick="scrollTo('#getCidades');">{{ url('/') }}/api/uf/#/cidades</a>)</small>
            </p>

            <strong>As informações retornadas para cada Iniciativa da lista são:</strong>
            <ul>
                <li>idIniciativa</li>
                <li>nome</li>
                <li>nomeCidade</li>
                <li>uf</li>
            </ul>
        </div>
    </div>

    <div class="panel panel-default" id="getIniciativa">
        <div class="panel-heading">Obter informações de uma Iniciativa</div>
        <div class="panel-body">
            <p>
                Retorna todas as informações de uma Iniciativa.
            </p>
            <strong>{{ url('/') }}/api//iniciativa/#/show</strong>
            <small class="alert-warning">
                (# obtido em <a href="#" onclick="scrollTo('#getIniciativas')">{{ url('/') }}/api/iniciativa</a>)
            </small>
        </div>
    </div>

    <div class="panel panel-default" id="getIniciativaPid">
        <div class="panel-heading">Obter PIDs de uma Iniciativa</div>
        <div class="panel-body">
            <p>
                Retorna a lista de PIDs de uma Iniciativa. <br/>
                <strong>{{ url('/') }}/api/iniciativa/#/pid</strong>
                <small class="alert-warning">
                    (# obtido em <a href="#" onclick="scrollTo('#getIniciativas')">{{ url('/') }}/api/iniciativa</a>)
                </small>
            </p>

            <strong>As informações retornadas para cada PID da lista são: </strong>
            <ul>
                <li>idPid</li>
                <li>nome</li>
                <li>nomeCidade</li>
                <li>uf</li>
            </ul>
        </div>
    </div>

    <h3>Instituição</h3>
    <div class="panel panel-default" id="getInstituicoes">
        <div class="panel-heading">Obter lista de Instituições</div>
        <div class="panel-body">
            <p>
                Retorna a lista de Instituições cadastradas. <br/>
                <strong>{{ url('/') }}/api/instituicao</strong>
            </p>

            <p>
                Para obter a lista de Instituições de um determinado Estado use o parametro <b>uf</b><br/>
                <strong>{{ url('/') }}/api/instituicao?uf=xx</strong>
                <small class="alert-warning">(xx = AC, MT, DF, SP, etc)</small>
                <br/> ou <br/>
                <strong>{{ url('/') }}/api/instituicao?uf=#</strong>
                <small class="alert-warning">(# obtido em <a href="#" onclick="scrollTo('#getUf');">{{ url('/') }}/api/uf</a>)</small>
            </p>

            <p>
                Para obter a lista de Instituições de um determinado Município use o parametro <b>cidade_id</b><br/>
                <strong>{{ url('/') }}/api/instituicao?cidade_id=#</strong>
                <small class="alert-warning">(# obtido em <a href="#" onclick="scrollTo('#getCidades');">{{ url('/') }}/api/uf/#/cidades</a>)</small>
            </p>

            <strong>As informações retornadas para cada Instituição da lista são:</strong>
            <ul>
                <li>idInstituicao</li>
                <li>nome</li>
                <li>nomeCidade</li>
                <li>uf</li>
            </ul>
        </div>
    </div>

    <div class="panel panel-default" id="getInstituicao">
        <div class="panel-heading">Obter informações de uma Instituição</div>
        <div class="panel-body">
            <p>
                Retorna todas as informações de uma Instituição.
            </p>
            <strong>{{ url('/') }}/api/instituicao/#/show</strong>
            <small class="alert-warning">
                (# obtido em <a href="#" onclick="scrollTo('#getInstituicoes')">{{ url('/') }}/api/instituicao</a>)
            </small>
        </div>
    </div>

    <h3>Outras</h3>
    <div class="panel panel-default" id="getUf">
        <div class="panel-heading">Obter lista de UF</div>
        <div class="panel-body">
            <p>
                Retorna as informações para cada UF. <br/>
                <strong>{{ url('/') }}/api/uf</strong>
            </p>

            <strong>As informações retornadas para cada UF da lista são:</strong>
            <ul>
                <li>uf</li>
                <li>idUf</li>
            </ul>
        </div>
    </div>

    <div class="panel panel-default" id="getCidades">
        <div class="panel-heading">Obter lista de Municípios de uma UF</div>
        <div class="panel-body">
            <p>
                Retorna a lista de Municípios de um Estado. <br/>
                <strong> {{ url('/') }}/api/uf/#/cidades</strong>
                <small class="alert-warning">(# obtido em <a href="#" onclick="scrollTo('#getUf');">{{ url('/') }}/api/uf</a>)</small>
            </p>

            <strong>As informações retornadas para cada Município da lista são:</strong>
            <ul>
                <li>idCidade</li>
                <li>nomeCidade</li>
                <li>uf_id</li>
            </ul>
        </div>
    </div>

@endsection

@section('script')
    @parent
    <script type="text/javascript">
        function scrollTo(div) {
            $('html, body').animate({ scrollTop: $(div).offset().top }, 'slow');
            return false;
        }
    </script>
@endsection