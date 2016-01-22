$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#regiao').hide();
$('#estado').hide();


$('#exibir').on('change',function() {
    var op = $(this).val()
    if(op == 1) {
        $('#regiao').hide();
        $('#estado').hide();
    }
    if(op == 2) {
        $('#regiao').show();
        $('#estado').hide();
    }

    if(op == 3) {
        $('#regiao').hide();
        $('#estado').show();
    }
});

var chart = '', url = '', title = '', dados, txtTitle = '';
$(".openModal").on('click', function() {
    chart = $(this).data('chart');
});

$("#apply").on('click', function() {
    var op = $('#exibir').val(), self = $(this);
    if(op == 1) {
        dados = {
            type: 'geral'
        }
    }
    if(op == 2) {
        dados = {
            type: 'regiao',
            regiao: $('#regioes').val()
        }
    }
    if(op == 3) {
        dados = {
            type: 'estado',
            uf: $("#uf").val(),
            cidade: $("#cidade_id").val()
        }
    }

    self.html('<span class="fa fa-refresh fa-spin"></span> Carregando...');
    self.prop( "disabled", true );
    $('#applyAll').prop( "disabled", true );
    $('#cancel').prop( "disabled", true );

    setTitle(chart);

    $.post(url, dados, function (dataTableJson) {
        lava.loadData(chart, dataTableJson, function (chart) {
            $('#modalConf').modal('hide');
            self.html('<span class="fa fa-check"></span> Aplicar');
            self.prop( "disabled", false );
            $('#cancel').prop( "disabled", false );
            $('#applyAll').prop( "disabled", false );

            $('#'+title).html(txtTitle);
        });
    }).error(function(){
        self.html('<span class="fa fa-check"></span> Aplicar');
        self.prop( "disabled", false );
        $('#cancel').prop( "disabled", false );
        $('#applyAll').prop( "disabled", false );
    });
});


$('#applyAll').on('click', function() {
    var op = $('#exibir').val(), self = $(this);

    self.html('<span class="fa fa-refresh fa-spin"></span> Carregando...');
    self.prop( "disabled", true );
    $('#apply').prop( "disabled", true );
    $('#cancel').prop( "disabled", true );

    if(op == 1) {
        dados = {
            type: 'geral'
        }
    }
    if(op == 2) {
        dados = {
            type: 'regiao',
            regiao: $('#regioes').val()
        }
    }
    if(op == 3) {
        dados = {
            type: 'estado',
            uf: $("#uf").val(),
            cidade: $("#cidade_id").val()
        }
    }


    if(location.pathname.split('/')[2] == 'pid') {
        $.when(
            $.post('/report/pid/status', dados, function (dataTableJson) {
                lava.loadData('PidStatus', dataTableJson, function (chart) {
                    setTitle('PidStatus');
                    $('#'+title).html(txtTitle);
                });
            }),

            $.post('/report/pid/tipo', dados, function (dataTableJson) {
                lava.loadData('PidTipos', dataTableJson, function (chart) {
                    setTitle('PidTipos');
                    $('#'+title).html(txtTitle);
                });
            }),

            $.post('/report/pid/iniciativa', dados, function (dataTableJson) {
                lava.loadData('PidIniciativa', dataTableJson, function (chart) {
                    setTitle('PidIniciativa');
                    $('#'+title).html(txtTitle);
                });
            }),

            $.post('/report/pid/instituicao', dados, function (dataTableJson) {
                lava.loadData('PidInstituicao', dataTableJson, function (chart) {
                    setTitle('PidInstituicao');
                    $('#'+title).html(txtTitle);
                });
            }),

            $.post('/report/pid/localizacao', dados, function (dataTableJson) {
                lava.loadData('PidLocalizcao', dataTableJson, function (chart) {
                    setTitle('PidLocalizcao');
                    $('#'+title).html(txtTitle);
                });
            }),

            $.post('/report/pid/localidade', dados, function (dataTableJson) {
                lava.loadData('PidLocalidade', dataTableJson, function (chart) {
                    setTitle('PidLocalidade');
                    $('#'+title).html(txtTitle);
                });
            })

        ).done(function() {
                self.html('<span class="fa fa-check"></span> Aplicar a todos');
                self.prop( "disabled", false );
                $('#apply').prop( "disabled", false );
                $('#cancel').prop( "disabled", false );
                $('#modalConf').modal('hide');
            });
    }

    if(location.pathname.split('/')[2] == 'iniciativa') {
        $.when(
            $.post('/report/iniciativa/dimensao', dados, function (dataTableJson) {
                lava.loadData('IniciativaDimensao', dataTableJson, function (chart) {
                    setTitle('IniciativaDimensao');
                    $('#'+title).html(txtTitle);
                });
            }),

            $.post('/report/iniciativa/servico', dados, function (dataTableJson) {
                lava.loadData('IniciativaServico', dataTableJson, function (chart) {
                    setTitle('IniciativaServico');
                    $('#'+title).html(txtTitle);
                });
            }),

            $.post('/report/iniciativa/instituicao', dados, function (dataTableJson) {
                lava.loadData('IniciativaInstituicao', dataTableJson, function (chart) {
                    setTitle('IniciativaInstituicao');
                    $('#'+title).html(txtTitle);
                });
            }),

            $.post('/report/iniciativa/tipo', dados, function (dataTableJson) {
                lava.loadData('IniciativaTipos', dataTableJson, function (chart) {
                    setTitle('IniciativaTipos');
                    $('#'+title).html(txtTitle);
                });
            }),

            $.post('/report/iniciativa/categoria', dados, function (dataTableJson) {
                lava.loadData('IniciativaCategorias', dataTableJson, function (chart) {
                    setTitle('IniciativaCategorias');
                    $('#'+title).html(txtTitle);
                });
            }),

            $.post('/report/iniciativa/localizacao', dados, function (dataTableJson) {
                lava.loadData('IniciativaLocalizacao', dataTableJson, function (chart) {
                    setTitle('IniciativaLocalizacao');
                    $('#'+title).html(txtTitle);
                });
            }),

            $.post('/report/iniciativa/natureza', dados, function (dataTableJson) {
                lava.loadData('InicativaNaturezas', dataTableJson, function (chart) {
                    setTitle('InicativaNaturezas');
                    $('#'+title).html(txtTitle);
                });
            })

        ).done(function() {
                self.html('<span class="fa fa-check"></span> Aplicar a todos');
                self.prop( "disabled", false );
                $('#apply').prop( "disabled", false );
                $('#cancel').prop( "disabled", false );
                $('#modalConf').modal('hide');
            });
    }
});


function setTitle(chart)
{
    switch (chart) {
        case 'PidStatus':
            title = 'PidStatusTitle';
            url = '/report/pid/status';
            switch (dados.type) {
                case 'geral':
                    txtTitle = '<strong>Pontos de Inclusão Digital: Status</strong>';
                    break;

                case 'regiao':
                    txtTitle = '<strong>Pontos de Inclusão Digital: Status / Região: '+ $('#regioes option:selected').text() +' </strong>';
                    break;

                case 'estado':
                    if(dados.cidade == '')
                        txtTitle = '<strong>Pontos de Inclusão Digital: Status / Estado: '+ $('#uf option:selected').text() +'</strong>';
                    else
                        txtTitle = '<strong>Pontos de Inclusão Digital: Status / Estado: '+ $('#uf option:selected').text() +' / Cidade: '+ $('#cidade_id option:selected').text() +' </strong>';
                    break;
            }
            break;

        case 'PidTipos':
            title = 'PidTiposTitle';
            url = '/report/pid/tipo';
            switch (dados.type) {
                case 'geral':
                    txtTitle = '<strong>Pontos de Inclusão Digital: Tipo</strong>';
                    break;

                case 'regiao':
                    txtTitle = '<strong>Pontos de Inclusão Digital: Tipo / Região: '+ $('#regioes option:selected').text() +' </strong>';
                    break;

                case 'estado':
                    if(dados.cidade == '')
                        txtTitle = '<strong>Pontos de Inclusão Digital: Tipo / Estado: '+ $('#uf option:selected').text() +'</strong>';
                    else
                        txtTitle = '<strong>Pontos de Inclusão Digital: Tipo / Estado: '+ $('#uf option:selected').text() +' / Cidade: '+ $('#cidade_id option:selected').text() +' </strong>';
                    break;
            }
            break;

        case 'PidIniciativa':
            title = 'PidIniciativaTitle';
            url = '/report/pid/iniciativa';
            switch (dados.type) {
                case 'geral':
                    txtTitle = '<strong>Pontos de Inclusão Digital: Inicativas</strong>';
                    break;

                case 'regiao':
                    txtTitle = '<strong>Pontos de Inclusão Digital: Inicativas / Região: '+ $('#regioes option:selected').text() +' </strong>';
                    break;

                case 'estado':
                    if(dados.cidade == '')
                        txtTitle = '<strong>Pontos de Inclusão Digital: Inicativas / Estado: '+ $('#uf option:selected').text() +'</strong>';
                    else
                        txtTitle = '<strong>Pontos de Inclusão Digital: Inicativas / Estado: '+ $('#uf option:selected').text() +' / Cidade: '+ $('#cidade_id option:selected').text() +' </strong>';
                    break;
            }
            break;

        case 'PidInstituicao':
            title = 'PidInstituicaoTitle';
            url = '/report/pid/instituicao';
            switch (dados.type) {
                case 'geral':
                    txtTitle = '<strong>Pontos de Inclusão Digital: Instituições</strong>';
                    break;

                case 'regiao':
                    txtTitle = '<strong>Pontos de Inclusão Digital: Instituições / Região: '+ $('#regioes option:selected').text() +' </strong>';
                    break;

                case 'estado':
                    if(dados.cidade == '')
                        txtTitle = '<strong>Pontos de Inclusão Digital: Instituições / Estado: '+ $('#uf option:selected').text() +'</strong>';
                    else
                        txtTitle = '<strong>Pontos de Inclusão Digital: Instituições / Estado: '+ $('#uf option:selected').text() +' / Cidade: '+ $('#cidade_id option:selected').text() +' </strong>';
                    break;
            }
            break;

        case 'PidLocalizcao':
            title = 'PidLocalizcaoTitle';
            url = '/report/pid/localizacao';
            switch (dados.type) {
                case 'geral':
                    txtTitle = '<strong>Pontos de Inclusão Digital: Localização</strong>';
                    break;

                case 'regiao':
                    txtTitle = '<strong>Pontos de Inclusão Digital: Localização / Região: '+ $('#regioes option:selected').text() +' </strong>';
                    break;

                case 'estado':
                    if(dados.cidade == '')
                        txtTitle = '<strong>Pontos de Inclusão Digital: Localização / Estado: '+ $('#uf option:selected').text() +'</strong>';
                    else
                        txtTitle = '<strong>Pontos de Inclusão Digital: Localização / Estado: '+ $('#uf option:selected').text() +' / Cidade: '+ $('#cidade_id option:selected').text() +' </strong>';
                    break;
            }
            break;

        case 'PidLocalidade':
            title = 'PidLocalidadeTitle';
            url = '/report/pid/localidade';
            switch (dados.type) {
                case 'geral':
                    txtTitle = '<strong>Pontos de Inclusão Digital: Localidade</strong>';
                    break;

                case 'regiao':
                    txtTitle = '<strong>Pontos de Inclusão Digital: Localidade / Região: '+ $('#regioes option:selected').text() +' </strong>';
                    break;

                case 'estado':
                    if(dados.cidade == '')
                        txtTitle = '<strong>Pontos de Inclusão Digital: Localidade / Estado: '+ $('#uf option:selected').text() +'</strong>';
                    else
                        txtTitle = '<strong>Pontos de Inclusão Digital: Localidade / Estado: '+ $('#uf option:selected').text() +' / Cidade: '+ $('#cidade_id option:selected').text() +' </strong>';
                    break;
            }
            break;

        case 'IniciativaDimensao':
            title = 'IniciativaDimensaoTitle';
            url = '/report/iniciativa/dimensao';
            switch (dados.type) {
                case 'geral':
                    txtTitle = '<strong>Iniciativas: Dimensões</strong>';
                    break;

                case 'regiao':
                    txtTitle = '<strong>Iniciativas: Dimensões / Região: '+ $('#regioes option:selected').text() +' </strong>';
                    break;

                case 'estado':
                    if(dados.cidade == '')
                        txtTitle = '<strong>Iniciativas: Dimensões / Estado: '+ $('#uf option:selected').text() +'</strong>';
                    else
                        txtTitle = '<strong>Iniciativas: Dimensões / Estado: '+ $('#uf option:selected').text() +' / Cidade: '+ $('#cidade_id option:selected').text() +' </strong>';
                    break;
            }
            break;

        case 'IniciativaServico':
            title = 'IniciativaServicoTitle';
            url = '/report/iniciativa/servico';
            switch (dados.type) {
                case 'geral':
                    txtTitle = '<strong>Iniciativas: Serviços</strong>';
                    break;

                case 'regiao':
                    txtTitle = '<strong>Iniciativas: Serviços / Região: '+ $('#regioes option:selected').text() +' </strong>';
                    break;

                case 'estado':
                    if(dados.cidade == '')
                        txtTitle = '<strong>Iniciativas: Serviços / Estado: '+ $('#uf option:selected').text() +'</strong>';
                    else
                        txtTitle = '<strong>Iniciativas: Serviços / Estado: '+ $('#uf option:selected').text() +' / Cidade: '+ $('#cidade_id option:selected').text() +' </strong>';
                    break;
            }
            break;

        case 'IniciativaInstituicao':
            title = 'IniciativaInstituicaoTitle';
            url = '/report/iniciativa/instituicao';
            switch (dados.type) {
                case 'geral':
                    txtTitle = '<strong>Iniciativas: Instituições</strong>';
                    break;

                case 'regiao':
                    txtTitle = '<strong>Iniciativas: Instituições / Região: '+ $('#regioes option:selected').text() +' </strong>';
                    break;

                case 'estado':
                    if(dados.cidade == '')
                        txtTitle = '<strong>Iniciativas: Instituições / Estado: '+ $('#uf option:selected').text() +'</strong>';
                    else
                        txtTitle = '<strong>Iniciativas: Instituições / Estado: '+ $('#uf option:selected').text() +' / Cidade: '+ $('#cidade_id option:selected').text() +' </strong>';
                    break;
            }
            break;
        case 'IniciativaTipos':
            title = 'IniciativaTiposTitle';
            url = '/report/iniciativa/tipo';
            switch (dados.type) {
                case 'geral':
                    txtTitle = '<strong>Iniciativas: Tipos</strong>';
                    break;

                case 'regiao':
                    txtTitle = '<strong>Iniciativas: Tipos / Região: '+ $('#regioes option:selected').text() +' </strong>';
                    break;

                case 'estado':
                    if(dados.cidade == '')
                        txtTitle = '<strong>Iniciativas: Tipos / Estado: '+ $('#uf option:selected').text() +'</strong>';
                    else
                        txtTitle = '<strong>Iniciativas: Tipos / Estado: '+ $('#uf option:selected').text() +' / Cidade: '+ $('#cidade_id option:selected').text() +' </strong>';
                    break;
            }
            break;
        case 'IniciativaCategorias':
            title = 'IniciativaCategoriasTitle';
            url = '/report/iniciativa/categoria';
            switch (dados.type) {
                case 'geral':
                    txtTitle = '<strong>Iniciativas: Categorias</strong>';
                    break;

                case 'regiao':
                    txtTitle = '<strong>Iniciativas: Categorias / Região: '+ $('#regioes option:selected').text() +' </strong>';
                    break;

                case 'estado':
                    if(dados.cidade == '')
                        txtTitle = '<strong>Iniciativas: Categorias / Estado: '+ $('#uf option:selected').text() +'</strong>';
                    else
                        txtTitle = '<strong>Iniciativas: Categorias / Estado: '+ $('#uf option:selected').text() +' / Cidade: '+ $('#cidade_id option:selected').text() +' </strong>';
                    break;
            }
            break;
        case 'IniciativaLocalizacao':
            title = 'IniciativaLocalizacaoTitle';
            url = '/report/iniciativa/localizacao';
            switch (dados.type) {
                case 'geral':
                    txtTitle = '<strong>Iniciativas: Localização</strong>';
                    break;

                case 'regiao':
                    txtTitle = '<strong>Iniciativas: Localização / Região: '+ $('#regioes option:selected').text() +' </strong>';
                    break;

                case 'estado':
                    if(dados.cidade == '')
                        txtTitle = '<strong>Iniciativas: Localização / Estado: '+ $('#uf option:selected').text() +'</strong>';
                    else
                        txtTitle = '<strong>Iniciativas: Localização / Estado: '+ $('#uf option:selected').text() +' / Cidade: '+ $('#cidade_id option:selected').text() +' </strong>';
                    break;
            }
            break;
        case 'InicativaNaturezas':
            title = 'InicativaNaturezasTitle';
            url = '/report/iniciativa/natureza';
            switch (dados.type) {
                case 'geral':
                    txtTitle = '<strong>Iniciativas: Natureza Jurídica</strong>';
                    break;

                case 'regiao':
                    txtTitle = '<strong>Iniciativas: Natureza Jurídica / Região: '+ $('#regioes option:selected').text() +' </strong>';
                    break;

                case 'estado':
                    if(dados.cidade == '')
                        txtTitle = '<strong>Iniciativas: Natureza Jurídica / Estado: '+ $('#uf option:selected').text() +'</strong>';
                    else
                        txtTitle = '<strong>Iniciativas: Natureza Jurídica / Estado: '+ $('#uf option:selected').text() +' / Cidade: '+ $('#cidade_id option:selected').text() +' </strong>';
                    break;
            }
            break;
    }
}

/*
$('a#pidStatusBtn').on('click', function(ev){
    ev.preventDefault();
    $.post('/report/pidStatus',{dados: 'dados'}, function (dataTableJson) {
        lava.loadData('PidStatus', dataTableJson, function (chart) {
            console.log(chart);
        });
    });

    $.getJSON('/report/pidLocalizacao', function (dataTableJson) {
        lava.loadData('PidLocalizcao', dataTableJson, function (chart) {
            console.log(chart);
        });
    });

    $.getJSON('/report/pidTipo', function (dataTableJson) {
        lava.loadData('PidTipos', dataTableJson, function (chart) {
            console.log(chart);
        });
    });

    $.getJSON('/report/iniciativaTipo', function (dataTableJson) {
        lava.loadData('InicativaTipos', dataTableJson, function (chart) {
            console.log(chart);
        });
    });

    $.getJSON('/report/iniciativaCategoria', function (dataTableJson) {
        lava.loadData('InicativaCategorias', dataTableJson, function (chart) {
            console.log(chart);
        });
    });

    $.getJSON('/report/iniciativaNatureza', function (dataTableJson) {
        lava.loadData('InicativaNaturezas', dataTableJson, function (chart) {
            console.log(chart);
        });
    });

    $.getJSON('/report/iniciativaLocalizacao', function (dataTableJson) {
        lava.loadData('iniciativaLocalizcao', dataTableJson, function (chart) {
            console.log(chart);
        });
    });

});*/
