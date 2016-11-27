<!-- Modal Configuracoes -->
<div class="modal fade" id="modalConf" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-cog"></i> Configurar</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="exibir">Exibir por</label>
                            <select name="exibir" id="exibir" class="form-control">
                                <option value="1">Geral</option>
                                <option value="2">Região</option>
                                <option value="3">Estado</option>
                            </select>
                        </div>

                        <div class="col-sm-9" id="regiao">
                            <label for="regioes">Regiões</label>
                            <select name="regioes" id="regioes" class="form-control">
                                <option value="1">Centro Oeste</option>
                                <option value="2">Norte</option>
                                <option value="3">Nordeste</option>
                                <option value="4">Sul</option>
                                <option value="5">Suldeste</option>
                            </select>
                        </div>

                        <div class="col-sm-9" id="estado">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="uf">UF</label>
                                    <select name="uf" id="uf" class="form-control">
                                        @foreach($uf as $index => $u)
                                            <option value="{{ $index }}">{{ $u }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-9">
                                    {!! Form::label('cidade_id', 'Cidade') !!}
                                    {!! Form::select('cidade_id', [], null, ["class" => "form-control"]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4"><button id="applyAll" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Aplicar a todos</button></div>
                    <div class="col-sm-4"><button id="apply" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Aplicar</button></div>
                    <div class="col-sm-4"><button id="cancel" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fim Modal Configuracoes -->