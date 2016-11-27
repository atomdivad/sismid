@extends('app')
@section('content')
    @yield('content')
    {!! Breadcrumbs::render('sobreSismid') !!}
    <div class="content-container" id="topo"></div>
    <div class="col-sm-2">
        {{--#<p class="text-justify">   </p>--}}
        <a href="#SisMID">O que é o SisMID</a><br/>
        <a href="#PID">E o que é um PID</a><br/>
        <a href="#Iniciativa">O que é uma Iniciativa</a><br/>
        <a href="#ProdutosServicos">Produtos e Serviços do MID</a><br/>
        <a href="#PesquisandoPIDs">Pesquisando PIDS</a><br/>
        <ul>
            <li><a href="#PesquisandoPIDsestado">Por Estado</a><br/></li>
            <li><a href="#PesquisandoPIDcidade">Por Cidade</a><br/></li>
            <li> <a href="#PesquisandoPIDagrupamento">Por Agrupamento</a><br/></li>
        </ul>
        <a href="#VisualizarInfoPid">Visualizando Informações do PID</a><br/>


        <a href="#ConsultaAvançada">Consulta Avançada</a><br/>
        <a href="#ExplorandoInfográficos">Explorando os Infográficos</a><br/>


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
            </li><br/>
            <img src="{{ asset('assets/images/1.png') }}" alt="Mapa de Consulta" class="img-responsive"><br/>
            <li>Gerando uma consulta completa o mapa é populado com todos os dados de PIDs contidos no banco de dados e abaixo do mapa
            surge uma tabela com a lista de cada ponto de inclusão digital e um ícone para visualização dos dados, também é possível aproximar um agrupamento
                de dados clicando no círculo enumerado para aproximar a região.
            </li><br/>

            <img src="{{ asset('assets/images/2.jpg') }}" alt="Mapa de Consulta Populado" class="img-responsive"><br/>
            <li>Mapa após aproximação do grupo de PIDs: </li><br/>
            <img src="{{ asset('assets/images/3.jpg') }}" alt="Mapa de Consulta Aproximado" class="img-responsive"><br/>

            <li><strong id="PesquisandoPIDsestado">Pesquisando PIDs por estado</strong><br/></li>
            <li>Clique na opção UF, selecione um item da lista e faça a consulta.</li>
            <img src="{{ asset('assets/images/4.png') }}" alt="Seleção de UF" class="img-responsive"><br/>
            <img src="{{ asset('assets/images/5.png') }}" alt="UF Selecionado" class="img-responsive"><br/>
            <li>Resultado da consulta por estado:</li><br/>
            <img src="{{ asset('assets/images/6.png') }}" alt="Resultado da consulta" class="img-responsive"><br/><br/>

            <li><strong id="PesquisandoPIDcidade">Pesquisando PIDs por Cidade</strong><br/></li>
            <li>Opção para seleção de cidade:</li><br/>
            <img src="{{ asset('assets/images/7.png') }}" alt="Opção para seleção da cidade" class="img-responsive"><br/>
            <li>Após selecionar a cidade a consulta pode ser realizada</li><br/>
            <img src="{{ asset('assets/images/8.png') }}" alt="Seleção da cidade" class="img-responsive"><br/>
            <li>Resultado da consulta por cidade:</li><br/>
            <img src="{{ asset('assets/images/9.png') }}" alt="Resultado da consulta por cidade" class="img-responsive"><br/>


            <li><strong id="PesquisandoPIDagrupamento">Pesquisando PIDs por Agrupamento</strong><br/></li>
            <li>A pesquisa por agrupamento, preenche com cores os estados e as regiões do Brasil. Informa o número de pids
            por região e estados, porém nessa modalidade não é possível buscar PIDs pelo mapa.</li><br/>
            <img src="{{ asset('assets/images/10.png') }}" alt="Pesquisando PIDs por Agrupamento" class="img-responsive"><br/>
            <li>Agrupamento por estados:</li><br/>
            <img src="{{ asset('assets/images/11.png') }}" alt="Agrupamento por estados" class="img-responsive"><br/>
            <li>Agrupamento por regiões:</li><br/>
            <img src="{{ asset('assets/images/12.png') }}" alt="Agrupamento por regiões" class="img-responsive"><br/>
        </ul>

        <strong id="VisualizarInfoPid">Visualizando Informações do PID</strong><br/>
        Após a consulta e navegação, encontra-se balões vermelhos que simboliza um PID, clicando nesse PID
        a tabela resulta em dados parciais: tipo, nome, endereço, município, uf e o botão para visualização completa.<br/><br/>

        <ul>
            <img src="{{ asset('assets/images/13.jpg') }}" alt="Tabela com informações do PID" class="img-responsive"><br/>



            <li>O ícone de visualização disponibiliza uma janela com abas contendo todas os dados do PID que está
                sendo consultado.<br/><br/>
            </li>
            <img src="{{ asset('assets/images/14.png') }}" alt="Visualização das informações do PID" class="img-responsive"><br/>
            </ul>

        <strong id="ConsultaAvançada">Consulta Avançada</strong><br/>
        A consulta avançada possui filtros adicionais: PIDs ativos e inativos, programa, projeto, ação, busca por região, área urbana e área não urbana. <br/><br/>
        <ul>
            <img src="{{ asset('assets/images/15.png') }}" alt="Consulta Avançada" class="img-responsive"><br/>



            <li>Opção para seleção de UF:<br/><br/>
            </li>
            <img src="{{ asset('assets/images/16.png') }}" alt="Seleção de UF" class="img-responsive"><br/>

            <li>Opção para seleção de cidade:<br/><br/>
            </li>
            <img src="{{ asset('assets/images/17.png') }}" alt="Opção para seleção de cidade" class="img-responsive"><br/>

            <li>Seleção dos itens para a consulta: Pid, programa, projeto e ação.<br/><br/>
            </li>
            <img src="{{ asset('assets/images/18.png') }}" alt="Campo para seleção dos itens para a consulta: Pid, programa, projeto e ação" class="img-responsive"><br/>

            <li>Opção para seleção da região:<br/><br/>
            </li>
            <img src="{{ asset('assets/images/19.png') }}" alt="Opção para seleção da região" class="img-responsive"><br/>

            <li>Opção para seleção de área urbana e área não urbana:<br/><br/>
            </li>
            <img src="{{ asset('assets/images/20.png') }}" alt="Opção para seleção de área urbana e área não urbana" class="img-responsive"><br/>

            <li>Exemplo de filtros prontos para a consulta:<br/><br/>
            </li>
            <img src="{{ asset('assets/images/21.png') }}" alt="Exemplo de filtros prontos para a consulta" class="img-responsive"><br/>

            <li>Consulta de PIDs utilizando os filtros DF, Brasília, região centro oeste e área urbana.<br/><br/>
            </li>
            <img src="{{ asset('assets/images/22.png') }}" alt="Consulta de PIDs utilizando os filtros DF, Brasília, região centro oeste e área urbana" class="img-responsive"><br/>


            <strong id="ExplorandoInfográficos">Explorando os Infográficos</strong><br/>
            Na sessão de infográficos foram incluidos botões de ajuda e configuração para melhorar a compreensão e o dinamismo,
            utlizando "?" para informações e uma engrenagem para modificar os dados da amostra.
            <br/><br/>
            <img src="{{ asset('assets/images/23.png') }}" alt="Modificador do Infográfico" class="img-responsive"><br/>
            <img src="{{ asset('assets/images/24.png') }}" alt="Modificador do Infográfico" class="img-responsive"><br/>
            <li>Configuração do Infográfico para exibir todos os dados:</li><br/>
            <img src="{{ asset('assets/images/25.png') }}" alt="Modificador do Infográfico" class="img-responsive"><br/>
            <li>Configuração do Infográfico para exibir os dados por região:</li><br/>
            <img src="{{ asset('assets/images/26.png') }}" alt="Modificador do Infográfico" class="img-responsive"><br/>
            <li>Configuração do Infográfico para exibir os dados UF e cidade:</li><br/>
            <img src="{{ asset('assets/images/27.png') }}" alt="Modificador do Infográfico" class="img-responsive"><br/>
            <li>Botão "?" para informar o objetivo do infográfico.</li><br/>
            <img src="{{ asset('assets/images/28.png') }}" alt="Ajuda do Infográfico" class="img-responsive"><br/>

        </ul>

    </div>

            </p>

    <span id="top-link-block" class="hidden">
    <a href="#topo" class="well well-sm"  onclick="$('html,body').animate({scrollTop:0},'slow');return false;">
        <i class="glyphicon glyphicon-chevron-up"></i>
    </a>
</span>
    @yield('script')

@endsection
@section('script')
    @parent
    <script src="{{ asset('/assets/js/guia.js') }}"></script>
@endsection
@section('css')
    <link href="{{ asset('/assets/css/custom.css') }}" rel="stylesheet">
@stop