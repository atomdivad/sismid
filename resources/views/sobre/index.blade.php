@extends('app')
@section('content')
    @yield('content')
    {!! Breadcrumbs::render('sobreSismid') !!}

    <div class="col-sm-2">
        {{--#<p class="text-justify">   </p>--}}
        <a href="#SisMID">O que é o SisMID</a><br/>
        <a href="#PID">E o que é um PID</a><br/>
        <a href="#Iniciativa">O que é uma Iniciativa</a><br/>
        <a href="#ProdutosServicos">Produtos e Serviços do MID</a><br/>
        <a href="#PesquisandoPIDs">Pesquisando PIDS</a><br/>
        <ul>
            <li><a href="#">Por Estado</a><br/></li>
            <li><a href="#">Por Cidade</a><br/></li>
            <li> <a href="#">Por Agrupamento</a><br/></li>
        </ul>


        <a href="#">Consulta Avançada</a><br/>
        <a href="#">Explorando os Infográficos</a><br/>



        </div>
    <div class="col-sm-10">
            <p class="text-justify">

                Criado em 2005 com o objetivo de acompanhar o avanço das ações de inserção da população na sociedade da informação, o MID oferece o mapeamento dos Pontos de Inclusão Digital
                (PID) instalados no Brasil. O levantamento realizado abrange os programas, projetos e ações desenvolvidos pelo governo e pela sociedade civil organizada em todo o país.
                A fim de gerenciar a atualização dos PIDs e produzir relatórios e indicadores, o mapa é apoiado por um sistema de informação (SisMID), que registra, em sua base de dados, os
                pontos de inclusão instalados no Brasil, as estatísticas e a base de programas, projetos e ações de inclusão digital no país.
            <br/><br/>
               <strong id="SisMID"> O que é o SisMID?</strong><br/>
                É uma base de dados para cadastro e análise de programas, projetos e ações de inclusão digital e seus respectivos pontos existentes nos municípios brasileiros com o objetivo de
                mostrar a diversidade das iniciativas de inclusão digital.
                <br/><br/>
                <strong id="PID">E o que é um PID?</strong><br/>
                É um local dotado de computadores para acesso gratuito, conectados à Internet, que proporcionam o desenvolvimento de habilidades cognitivas por meio do acesso à informação,
                criação de conteúdos, entretenimento e comunicação com outras pessoas. Os PIDs incluem telecentros, infocentros, centros de inclusão digital, laboratórios de informática em
                escolas públicas e projetos de extensão em instituições relacionadas à inclusão digital.
                <br/><br/>
                <strong id="Iniciativa">O que é uma Iniciativa?</strong><br/>
                Para introduzir esse conceito devemos explicitar que iniciativas dividem-se em três grupos: programas, projetos e ações.
                <ul>
                <li>Programas de Implantação de Centros Públicos de Acesso à Internet - caracterizam-se pela oferta de infraestrutura de comunicação e acesso, treinamento e capacitação para instalação de pontos de inclusão digital(PID), comprometidos com o desenvolvimento social das comunidades envolvidas. Os PIDs  se constituem em rede, atuando em ambientes e lugares distintos, segundo um modelo definido pela instituição mantenedora. Ex. MC/GESAC; ATN / TIN.
                </li>
                <li>
                Projetos de Implantação de Centros Públicos de Acesso à Internet - caracterizam-se pela oferta de infraestrutura de comunicação e acesso, treinamento e capacitação para instalação de pontos de inclusão digital. Caracterizam-se pela existência de um único PİD criado pela sociedade civil ou pelo governo para atendimento a uma situação em particular, sem subordinação direta a um dado programa existente.
                </li>
                <li>
                Ações para Inclusão Social – inclui-se nesta denominação projetos e programas oriundos de políticas públicas ou de iniciativa da sociedade civil, sem a existência de PID. Ex. Programa Banda Larga; Cidades Digitais; Lugares de Saber; Ferramentas e Aplicativos de informática para produção de conteúdos digitais; programa de distribuição de computadores e ou dispositivos móveis.
                 </li></ul>
                <br/><br/>
                <strong id="ProdutosServicos">Produtos e Serviços do MID</strong><br/>
                <ul>
                <li>
                Sistema de Apoio ao MID (SisMID): possui recursos de geração de relatórios e estatísticas atualizadas de dados sobre os PIDs. Este sistema garante controle e o tratamento dos dados que serão visualizados por meio do Portal.
                </li>
                <li>
                Banco de Dados: reúne todas as informações coletadas e enviadas pelos agentes do governo e pela sociedade civil sobre PID, e também sobre programas, projetos e ações de inclusão digital.
                </li>
                <li>
                Portal de Inclusão Digital: divulga informações e conteúdos para download sobre inclusão digital, e apresenta o mapa contendo todos os possíveis PIDs localizados geograficamente <a href="http://inclusao.ibict.br">(http://inclusao.ibict.br)</a>
                </li>
                <li>
                Repositório de Inclusão Digital: reúne uma base de dados on-line, de maneira organizada, e a produção de documentos da inclusão digital no país.
                </li>
                <li>
                Projeto MID / BI - sistema analítico de inteligência competitiva para a geração de relatórios e painéis gerenciais de apoio à tomada de decisão do MID.
                </li>
                </ul>
        <strong id="PesquisandoPIDs">Pesquisando PIDs</strong><br/>
        <ul>
            <li>
                Clicando no link Mapa de Inclusão obtém-se o acesso ao mapa pronto para uma consulta geral:
            </li>
            <img src="{{ asset('assets/images/1.png') }}" alt="Mapa de Consulta" class="img-responsive">
            <li>Gerando uma consulta completa o mapa é populado com todos os dados de PIDs contidos no banco de dados e abaixo do mapa
            surge uma tabela com a lista de cada ponto de inclusão digital e um ícone para visualização dos dados, também é possível aproximar um agrupamento
                de dados clicando no círculo enumerado para aproximar a região.
            </li>
            <img src="{{ asset('assets/images/2.jpg') }}" alt="Mapa de Consulta" class="img-responsive">
        </ul>



            </p>
</div>

    @yield('script')

@endsection
