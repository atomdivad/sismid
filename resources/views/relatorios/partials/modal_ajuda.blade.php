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
                    Texto iniciativa tipos
                </div>

                <div id="AjudaIniciativaLocalizacao" v-if="chart == 'IniciativaLocalizacao'">
                    Texto iniciativa localizacao
                </div>

                <div id="AjudaIniciativaDimensao" v-if="chart == 'IniciativaDimensao'">
                    Texto iniciativa dimensao
                </div>

                <div id="AjudaIniciativaCategorias" v-if="chart == 'IniciativaCategorias'">
                    Texto iniciativa categoria
                </div>

                <div id="AjudaIniciativaInstituicao" v-if="chart == 'IniciativaInstituicao'">
                    Texto iniciativa instituicao
                </div>

                {{-- Pids --}}
                <div id="AjudaPidStatus" v-if="chart == 'PidStatus'">
                    Texto pid status
                </div>

                <div id="AjudaPidTipos" v-if="chart == 'PidTipos'">
                    Texto pid tipo
                </div>

                <div id="AjudaPidIniciativa" v-if="chart == 'PidIniciativa'">
                    Texto pid iniciativa
                </div>

                <div id="AjudaPidInstituicao" v-if="chart == 'PidInstituicao'">
                    Texto pid instituicao
                </div>

                <div id="AjudaPidLocalizcao" v-if="chart == 'PidLocalizcao'">
                    Texto pid localizacao
                </div>

                <div id="AjudaPidLocalidade" v-if="chart == 'PidLocalidade'">
                    Texto pid localidade
                </div>

                <div id="AjudaPidServico" v-if="chart == 'PidServico'">
                    Texto pid servico
                </div>

                <div id="AjudaPidPivot" v-if="chart == 'PidPivot'">
                    Texto pid pivot
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fim Modal Ajuda -->