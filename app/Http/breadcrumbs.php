<?php

//Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('home'));
});

/*Mapa*/

//Home > Mapa
Breadcrumbs::register('mapa', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Mapa', route('mapa.index'));
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

//Home > E-mail
Breadcrumbs::register('email', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Gerenciar e-mail', route('admin.email.index'));
});
//Home -> E-mail -> Edit
Breadcrumbs::register('emailEdit', function($breadcrumbs)
{
    $breadcrumbs->parent('email');
    $breadcrumbs->push('Editar', route('admin.email.edit'));
});