<!-- Modal Instituicoes -->
<div class="modal fade" id="modalIntituicoes" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="glyphicon glyphicon-list"></i> Instituições</h4>
            </div>
            <div class="modal-body">
                <div id="filtrarInstituicoes">
                    <div class="form-group">
                        <label for="buscaNome">Nome</label>
                        <input type="text" name="buscaNome" class="form-control"/>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('buscaUF', 'UF') !!}
                                <select name="buscaUF" id="buscaUF" class="form-control">
                                    <option value="0">Todos UF</option>
                                    @foreach($uf as $index => $u)
                                        <option value="{{ $index }}">{{ $u }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                {!! Form::label('buscaCidade', 'Município') !!}
                                {!! Form::select('buscaCidade', [], null, ["class" => "form-control"]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-sm btn-primary" v-on:click="pesquisarInstituicoes($event)"><i class="glyphicon glyphicon-search"></i> Pesquisar</button>
                    </div>

                </div>
                <table class="table table-responsive table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Município</th>
                            <th colspan="2">UF</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="i in instituicoes">
                        <td>@{{ i.nome }}</td>
                        <td>@{{ i.nomeCidade }}</td>
                        <td>@{{ i.uf }}</td>
                        <td><button class="btn btn-sm btn-primary" v-on:click="adicionarInstituicao($event, $index)"><i class="glyphicon glyphicon-plus-sign"></i></button></td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button class="btn btn-success" v-on:click="cadastrarInstituicoes($event)"><span class="glyphicon glyphicon-save"></span> Salvar</button>
                <button class="btn btn-danger" v-on:click="cancelarInstituicoes($event)"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fim Modal Instituicoes -->