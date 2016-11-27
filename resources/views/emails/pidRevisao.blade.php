Olá!<br/>

<p>
    Segue o link para que possa revisar os dados do PID: <a href="{{ route('pid.ver', $idPid) }}"><strong>{{ $nome }}</strong></a> <br/>
    Para que possa submeter alterações será solicitada uma senha. <br/>
    Está senha será válida por <strong>30 dias</strong>, após esse prazo ela expirará. <br/>
    Também será solicitado o e-mail. Somente o e-mail para o qual a senha foi enviada é válido. <br/>
</p>

<p>
    Sua senha é: <strong>{{ $pass }}</strong> <br/><br/>

    E-mail cadastrado: <strong>{{ $email }}</strong> <br/><br/>

    Link para acessar: <a href="{{ route('review.pid.edit', $idPid)}}">{{ route('review.pid.edit', $idPid) }}</a> <br/>
</p>


Obrigado! <br/>
<a href="{{ url('/') }}">SISMID</a>