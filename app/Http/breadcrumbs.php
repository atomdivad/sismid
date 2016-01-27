<?php

//Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    if(Auth::guest())
        $breadcrumbs->push('Home', url('/'));
    else
        $breadcrumbs->push('Home', route('home'));
});

/*Mapa*/

//Home > Mapa
Breadcrumbs::register('mapa', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Mapa', route('mapa.index'));
});

/*Consultas*/

//Home > Consulta
Breadcrumbs::register('consulta', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Consultas', route('consulta.index'));
});

/*Infograficos*/

//Home > Infogrico Pid
Breadcrumbs::register('reportIndexPid', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Infográficos PIDs', route('report.indexPid'));
});

//Home > Infogrico Iniciat
Breadcrumbs::register('reportIndexIniciativa', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Infográficos Iniciativas', route('report.indexIniciativa'));
});

/*PIDS*/

//Home > PID
Breadcrumbs::register('pid', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('PID', route('pid.index'));
});

//Home > PID > Create
Breadcrumbs::register('pidCreate', function($breadcrumbs)
{
    $breadcrumbs->parent('pid');
    $breadcrumbs->push('Cadastrar PID', route('pid.create'));
});

//Home > PID > Edit
Breadcrumbs::register('pidEdit', function($breadcrumbs)
{
    $breadcrumbs->parent('pid');
    $breadcrumbs->push('Editar PID', route('pid.edit'));
});



/*INICIATIVAS*/

//Home > Iniciativa
Breadcrumbs::register('iniciativa', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Iniciativa', route('iniciativa.index'));
});

//Home > Iniciativa > Create
Breadcrumbs::register('iniciativaCreate', function($breadcrumbs)
{
    $breadcrumbs->parent('iniciativa');
    $breadcrumbs->push('Cadastrar Iniciativa', route('iniciativa.create'));
});

//Home > Iniciativa > Edit
Breadcrumbs::register('iniciativaEdit', function($breadcrumbs)
{
    if(Defender::hasRole('gestor')) {
        $breadcrumbs->parent('home');
        $breadcrumbs->push('Editar Iniciativa', route('iniciativa.edit'));
    }
    else {
        $breadcrumbs->parent('iniciativa');
        $breadcrumbs->push('Editar Iniciativa', route('iniciativa.edit'));
    }
});

/*Gestores*/

//Home > Iniciativa > Gestor
Breadcrumbs::register('gestor', function($breadcrumbs)
{
    $breadcrumbs->parent('iniciativa');
    $breadcrumbs->push('Gestor', route('gestor.index'));
});

//Home > Iniciativa > Create
Breadcrumbs::register('gestorCreate', function($breadcrumbs)
{
    $breadcrumbs->parent('gestor');
    $breadcrumbs->push('Cadastrar Gestor', route('gestor.create'));
});

//Home > Iniciativa > Edit
Breadcrumbs::register('gestorEdit', function($breadcrumbs)
{
    $breadcrumbs->parent('gestor');
    $breadcrumbs->push('Editar Gestor', route('gestor.edit'));
});

/*Instituicoes*/

//Home > Instituição
Breadcrumbs::register('instituicao', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Instituições', route('instituicao.index'));
});

//Home > Instituição > Create
Breadcrumbs::register('instituicaoCreate', function($breadcrumbs)
{
    $breadcrumbs->parent('instituicao');
    $breadcrumbs->push('Cadastrar Instituição', route('instituicao.create'));
});

//Home > Instituição > Edit
Breadcrumbs::register('instituicaoEdit', function($breadcrumbs)
{
    $breadcrumbs->parent('instituicao');
    $breadcrumbs->push('Editar Instituição', route('instituicao.edit'));
});


/* Administracao*/

//Home > E-mail
Breadcrumbs::register('email', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Gerenciar E-mail', route('admin.email.index'));
});
//Home -> E-mail -> Edit
Breadcrumbs::register('emailEdit', function($breadcrumbs)
{
    $breadcrumbs->parent('email');
    $breadcrumbs->push('Editar', route('admin.email.edit'));
});
//Home > Gerenciar Endereço/Telefone
Breadcrumbs::register('endContato', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Gerenciar Endereço e Telefone', route('admin.endContato.index'));
});
//Home -> E-mail -> Edit
Breadcrumbs::register('endContatoEdit', function($breadcrumbs)
{
    $breadcrumbs->parent('endContato');
    $breadcrumbs->push('Editar Endereço', route('admin.endContato.editEndereco'));
});
//Home -> E-mail -> Edit
Breadcrumbs::register('endContatoEditTelefone', function($breadcrumbs)
{
    $breadcrumbs->parent('endContato');
    $breadcrumbs->push('Editar Telefone', route('admin.endContato.editTelefone'));
});
Breadcrumbs::register('infoEquipe', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Gerenciar Informações da Equipe', route('admin.infoEquipe.index'));
});
//Home -> E-mail -> Edit
Breadcrumbs::register('editInfoEquipe', function($breadcrumbs)
{
    $breadcrumbs->parent('infoEquipe');
    $breadcrumbs->push('Editar Informações', route('admin.infoEquipe.editInfoEquipe'));
});
Breadcrumbs::register('gerenciaAdmin', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Gerenciar Administradores do SisMID', route('admin.gerencia.index'));
});
Breadcrumbs::register('gerenciaAdminCreate', function($breadcrumbs)
{
    $breadcrumbs->parent('gerenciaAdmin');
    $breadcrumbs->push('Cadastrar', route('admin.gerencia.create'));
});
Breadcrumbs::register('gerenciaAdminEdit', function($breadcrumbs)
{
    $breadcrumbs->parent('gerenciaAdmin');
    $breadcrumbs->push('Editar', route('admin.gerencia.edit'));
});
Breadcrumbs::register('sobreSismid', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Sobre o SisMID', route('sobre.index'));
});