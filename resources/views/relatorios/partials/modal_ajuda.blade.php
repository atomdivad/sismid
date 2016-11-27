<!-- Modal Ajuda -->
<div class="modal fade" id="modalAjuda" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-question-circle fa-2x"></i></h4>
            </div>
            <div class="modal-body">
                {{-- Iniciativa --}}
                <div id="AjudaIniciativaTipos" v-if="chart == 'IniciativaTipos'">
                    Informa o número total de iniciativas. Classifica e quantifica as iniciativas por:<br/>
                    - Programa: Iniciativas com mais de um PID associado.<br/>
                    - Projeto: Iniciativas com apenas um PID associado.<br/>
                    - Ação: Não possui um PID associado por não ser um ponto de inclusão digital e sim um serviço
                    comunitário.
                </div>

                <div id="AjudaIniciativaLocalizacao" v-if="chart == 'IniciativaLocalizacao'">
                    Informa a quantidade e porcentagem de iniciativas em Área Urbana e Área Não Urbana.
                </div>

                <div id="AjudaIniciativaDimensao" v-if="chart == 'IniciativaDimensao'">
                    Informa a quantidade e porcentagem de iniciativas por dimensão: <br/>
                    Infraestrutura e Acesso de Comunicação,
                    Equipamentos,
                    Treinamento,
                    Capacitação Intelectual,
                    Produção de Conteúdo e
                    Produção de Ferramenta.

                </div>

                <div id="AjudaIniciativaCategorias" v-if="chart == 'IniciativaCategorias'">
                    Informa a quantidade e porcentagem de iniciativas por categoria: <br/>
                    Governo Federal, Governo Estadual, Governo Municipal e Terceiro Setor.
                </div>

                <div id="AjudaIniciativaInstituicao" v-if="chart == 'IniciativaInstituicao'">
                    Informa a quantidade de iniciativas que possuem ou não instituições mantenedoras/apoiadoras.<br/>
                    Mantenedora: principal instituição financiadora.<br/>
                    Apoiadora: instituição que contribui de forma secundária.
                </div>

                {{-- Pids --}}
                <div id="AjudaPidStatus" v-if="chart == 'PidStatus'">
                    Informa a quantidade de PIDs ativos e inativos em nossa base de dados.
                </div>

                <div id="AjudaPidTipos" v-if="chart == 'PidTipos'">
                    Informa a quantidade e porcentagem de PIDs Laboratório de Informática e Telecentro/Infocentro.
                </div>

                <div id="AjudaPidIniciativa" v-if="chart == 'PidIniciativa'">
                    Informa a quantidade e porcentagem de PIDs que possuem ou não uma iniciativa associada.
                </div>

                <div id="AjudaPidInstituicao" v-if="chart == 'PidInstituicao'">
                    Informa a quantidade de PIDs que possuem ou não instituições mantenedoras/apoiadoras.<br/>
                    Mantenedora: principal instituição financiadora.<br/>
                    Apoiadora: instituição que contribui de forma secundária.
                </div>

                <div id="AjudaPidLocalizcao" v-if="chart == 'PidLocalizcao'">
                    Informa a quantidade e porcentagem de PIDs em Área Urbana e Área Não Urbana.
                </div>

                <div id="AjudaPidLocalidade" v-if="chart == 'PidLocalidade'">
                    Informa a quantidade e porcentagem de PIDs por localidade: Áreas Especiais, Capital, Capital Federal,
                    Cidade, Distrito, Município e Vilas.
                </div>

                <div id="AjudaPidServico" v-if="chart == 'PidServico'">
                    Informa a quantidade e porcentagem de serviços oferecidos por PIDs:<br/>
                    Acesso à Internet,<br/>
                    Acesso e/ou Gravação de mídias diversas(CDs, DVDs, pendrives),<br/>
                    Transações de governo eletrônico (Detran, Tribunais etc.),<br/>
                    Transações à órgãos privados (faculdades, bancos etc.),<br/>
                    Cursos de capacitação profissional,<br/>
                    Treinamento em informática,<br/>
                    Publicação em website de conteúdos produzidos pela comunidade local,<br/>
                    Elaboração de currículos e outros textos,<br/>
                    Informações para turistas,<br/>
                    Edição de jornais locais/ comunitários,<br/>
                    Edição de folhetos e prospectos,<br/>
                    Palestras e seminários,<br/>
                    Disponibilização de programas que permitem ligações nacionais e internacionais (VOIP), Skype, ooVoo, etc,<br/>
                    Publicidade na web,<br/>
                    Curso a Distância (EAD),<br/>
                    Consultoria em informática para pequenas empresas locais,<br/>
                    Serviço de impressão (teses, monografias, fotocópia, encadernação, etc.),<br/>
                    Manutenção de computadores,<br/>
                    Fax,<br/>
                    Xerox,<br/>
                    Venda de créditos para celular,<br/>
                    Serviço de lanchonete (salgadinhos, café, refrigerantes, doces, salgados, etc.) e<br/>
                    Outros.

                </div>

                <div id="AjudaPidPivot" v-if="chart == 'PidPivot'">
                    Essa ferramenta faz o cruzamento de dados entre PIDs e Iniciativas, usando os filtros:<br/>
                    Localização, Tipo(Telecentro/Infocentro e Laboratório de Informática), Iniciativas, UF e Cidades.<br/>
                    A função básica é permitir a exploração e análise de dados, transformando um grupo em uma tabela de
                    resumo de dados, em seguida, opcionalmente adicionando uma interface arraste e solte 2d para permitir que um
                    usuário manipule esta tabela resumo, transformando-a em uma tabela dinâmica.
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fim Modal Ajuda -->