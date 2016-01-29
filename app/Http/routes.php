<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::pattern('id', '[0-9]+');

Route::get('/', function () {
    if(Auth::check())
        return view('home');
    return view('index');
});

Route::group(['middleware' => ['auth', 'needsRole'], 'is' => ['admin', 'gestor'], 'any' => true], function() {

    Route::get('/home', ['as' => 'home', function () {
        return view('home');
    }]);

    Route::group(['prefix' => 'pid'], function() {

        Route::get('/', ['as' => 'pid.index', 'uses' => 'PidController@index']);
        Route::get('create', ['as' => 'pid.create', 'uses' => 'PidController@create']);
        Route::post('/store', ['as' => 'pid.store', 'uses' => 'PidController@store']);
        Route::get('/{id}/show', ['as' => 'pid.show', 'uses' => 'PidController@show']);
        Route::get('/{id}/edit', ['as' => 'pid.edit', 'uses' => 'PidController@edit']);
        Route::post('/update', ['as' => 'pid.update', 'uses' => 'PidController@update']);
        Route::post('/fotos', ['as' => 'pid.fotos.upload', 'uses' => 'PidController@fotosUpload']);
        Route::post('/fotos/remover', ['as' => 'pid.fotos.remover', 'uses' => 'PidController@fotosDestroy']);
        Route::get('/{id}/fotos/{nome}', ['as' => 'pid.fotos', 'uses' => 'PidController@fotos']);
        Route::post('/active', ['as' => 'pid.active', 'uses' => 'PidController@active']);
    });

    Route::group(['prefix' => 'instituicao'], function() {

        Route::get('/', ['as' => 'instituicao.index', 'uses' => 'InstituicaoController@index']);
        Route::get('create', ['as' => 'instituicao.create', 'uses' => 'InstituicaoController@create']);
        Route::post('/store', ['as' => 'instituicao.store', 'uses' => 'InstituicaoController@store']);
        Route::get('/{id}/show/', ['as' => 'instituicao.show', 'uses' => 'InstituicaoController@show']);
        Route::get('/{id}/edit/', ['as' => 'instituicao.edit', 'uses' => 'InstituicaoController@edit']);
        Route::post('/update', ['as' => 'instituicao.update', 'uses' => 'InstituicaoController@update']);
    });

    Route::group(['prefix' => 'iniciativa'], function() {

        Route::get('/{id}/show/', ['as' => 'iniciativa.show', 'uses' => 'IniciativaController@show']);
        Route::get('/{id}/edit/', ['as' => 'iniciativa.edit', 'uses' => 'IniciativaController@edit']);
        Route::post('/update', ['as' => 'iniciativa.update', 'uses' => 'IniciativaController@update']);
    });

});

Route::group(['middleware' => ['auth', 'needsRole'], 'is' => 'admin'], function(){

    Route::group(['prefix' => 'admin'], function() {
        Route::get('/gerencia', ['as' => 'admin.gerencia.index', 'uses' => 'AdminController@indexGerenciaAdmin']);
        Route::get('/gerencia/{id}/edit', ['as' => 'admin.gerencia.edit', 'uses' => 'AdminController@editGerenciaAdmin']);
        Route::get('/gerencia/create', ['as' => 'admin.gerencia.create', 'uses' => 'AdminController@createGerenciaAdmin']);
        Route::post('/gerencia/store', ['as' => 'admin.gerencia.store', 'uses' => 'AdminController@storeGerenciaAdmin']);
        Route::post('/gerencia/{id}/update', ['as' => 'admin.gerencia.update', 'uses' => 'AdminController@updateGerenciaAdmin']);

        Route::get('/email', ['as' => 'admin.email.index', 'uses' => 'AdminController@indexEmail']);
        Route::get('/email/{id}/edit', ['as' => 'admin.email.edit', 'uses' => 'AdminController@editEmail']);
        Route::post('/email/{id}/update', ['as' => 'admin.email.update', 'uses' => 'AdminController@updateEmail']);

        Route::get('/endContato', ['as' => 'admin.endContato.index', 'uses' => 'AdminController@indexEndContato']);
        Route::get('/endContato/{id}/editTelefone', ['as' => 'admin.endContato.editTelefone', 'uses' => 'AdminController@editEndContatoTel']);
        Route::get('/endContato/{id}/editEndereco', ['as' => 'admin.endContato.editEndereco', 'uses' => 'AdminController@editEndContato']);
        Route::post('/endContato/{id}/updateEndereco', ['as' => 'admin.endContato.updateEndereco', 'uses' => 'AdminController@updateEndContato']);
        Route::post('/endContato/{id}/updateTelefone', ['as' => 'admin.endContato.updateTelefone', 'uses' => 'AdminController@updateEndContatoTel']);

        Route::get('/infoEquipe', ['as' => 'admin.infoEquipe.index', 'uses' => 'AdminController@indexInfoEquipe']);
        Route::get('/infoEquipe/{id}/editInfoEquipe', ['as' => 'admin.infoEquipe.editInfoEquipe', 'uses' => 'AdminController@editInfoEquipe']);
        Route::post('/infoEquipe/{id}/updateInfoEquipe', ['as' => 'admin.infoEquipe.updateInfoEquipe', 'uses' => 'AdminController@updateInfoEquipe']);

    });

    Route::group(['prefix' => 'iniciativa'], function() {

        Route::get('/', ['as' => 'iniciativa.index', 'uses' => 'IniciativaController@index']);
        Route::get('create', ['as' => 'iniciativa.create', 'uses' => 'IniciativaController@create']);
        Route::post('/store', ['as' => 'iniciativa.store', 'uses' => 'IniciativaController@store']);

        Route::group(['prefix' => 'gestor'], function() {

            Route::get('/',      ['as' => 'gestor.index',  'uses' => 'IniciativaGestorController@index']);
            Route::get('/create',     ['as' => 'gestor.create', 'uses' => 'IniciativaGestorController@create']);
            Route::post('/store',     ['as' => 'gestor.store',  'uses' => 'IniciativaGestorController@store']);
            Route::get('/{id}/show/', ['as' => 'gestor.show',   'uses' => 'IniciativaGestorController@show']);
            Route::get('/{id}/edit/', ['as' => 'gestor.edit',   'uses' => 'IniciativaGestorController@edit']);
            Route::post('/update',    ['as' => 'gestor.update', 'uses' => 'IniciativaGestorController@update']);
        });
    });

});

Route::group(['prefix' => 'mapa'], function() {

    Route::get('/', ['as' => 'mapa.index', 'uses' => 'MapaController@index']);
    Route::get('/{id}/show', ['as' => 'mapa.show', 'uses' => 'MapaController@show']);

});

Route::group(['prefix' => 'consulta'], function() {

    Route::get('/', ['as' => 'consulta.index', 'uses' => 'ConsultaController@index']);
    Route::post('/', ['as' => 'consulta.search', 'uses' => 'ConsultaController@search']);
});
Route::group(['prefix' => 'sobre'], function() {

    Route::get('/sismid', ['as' => 'sobre.index', 'uses' => 'SobreController@index']);

});

Route::group(['prefix' => 'report'], function(){

    Route::group(['prefix' => 'pid'], function(){
        Route::get('/',                   ['as' => 'report.indexPid',                 'uses' => 'ReportController@indexPid']);
        Route::post('/status',            ['as' => 'report.pidStatus',                'uses' => 'ReportController@reportPidStatus']);
        Route::post('/tipo',              ['as' => 'report.pidTipo',                  'uses' => 'ReportController@reportPidTipo']);
        Route::post('/iniciativa',        ['as' => 'report.pidIniciativa',            'uses' => 'ReportController@reportPidIniciativa']);
        Route::post('/instituicao',       ['as' => 'report.pidInstituicao',           'uses' => 'ReportController@reportPidInstituicao']);
        Route::post('/localizacao',       ['as' => 'report.pidLocalizacao',           'uses' => 'ReportController@reportPidLocalizacao']);
        Route::post('/localidade',        ['as' => 'report.pidLocalidade',            'uses' => 'ReportController@reportPidLocalidade']);
    });

    Route::group(['prefix' => 'iniciativa'], function(){
        Route::get('/',                      ['as' => 'report.indexIniciativa',          'uses' => 'ReportController@indexIniciativa']);
        Route::post('/tipo',                 ['as' => 'report.iniciativaTipo',           'uses' => 'ReportController@reportIniciativaTipo']);
        Route::post('/categoria',            ['as' => 'report.iniciativaCategoria',      'uses' => 'ReportController@reportInicativaCategoria']);
        Route::post('/natureza',             ['as' => 'report.iniciativaNatureza',       'uses' => 'ReportController@reportInicativaNatureza']);
        Route::post('/localizacao',          ['as' => 'report.iniciativaLocalizacao',    'uses' => 'ReportController@reportIniciativaLocalizacao']);
        Route::post('/dimensao',             ['as' => 'report.iniciativaDimensao',       'uses' => 'ReportController@reportIniciativaDimensao']);
        Route::post('/servico',              ['as' => 'report.iniciativaServico',        'uses' => 'ReportController@reportIniciativaServico']);
        Route::post('/instituicao',          ['as' => 'report.iniciativaInstituicao',    'uses' => 'ReportController@reportIniciativaInstituicao']);
    });
});

Route::group(['prefix' => 'api', 'middleware' => 'cors'], function(){

    Route::get('/uf', ['as' => 'getUf', 'uses' => 'ApiController@getUf']);
    Route::get('/uf/{id}/cidades/', ['as' => 'getCidades', 'uses' => 'ApiController@getCidades']);

    Route::post('/app/mapa', ['as' => 'appMapa', 'uses' => 'ApiController@appMapa']);


    Route::post('/mapa/', ['as' => 'getMapa', 'uses' => 'ApiController@getMapa']);
    Route::get('/{id}/fotos/{nome}', ['as' => 'geFotos', 'uses' => 'ApiController@getFotos']);

    Route::post('/pesquisar/instituicoes', ['as' => 'pesquisarInstituicoes', 'uses' => 'ApiController@getInstituicoes']);
    Route::post('/pesquisar/iniciativas', ['as' => 'pesquisarIniciativas', 'uses' => 'ApiController@getIniciativas']);

    Route::get('/iniciativa/{id}/show', ['as' => 'getIniciativa', 'uses' => 'ApiController@getIniciativa']);
    Route::get('/pid/{id}/show', ['as' => 'getPid', 'uses' => 'ApiController@getPid']);
    Route::get('/instituicao/{id}/show', ['as' => 'getInstituicao', 'uses' => 'ApiController@getInstituicao']);




});

Route::post('/feedback', ['as' => 'feedback', 'uses' => 'ApiController@feedback']);


route::group(['prefix' => 'auth'], function(){

    /*
     * Authentication routes
     */
    Route::get('/login', ['as' => 'auth.formLogin', 'uses' => 'Auth\AuthController@getLogin']);
    Route::post('/login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@postLogin']);
    Route::get('/logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout']);

    /*
     * Registration routes
     */
   /*
    Route::get('/register', ['as' => 'auth.formRegister', 'uses' => 'Auth\AuthController@getRegister']);
    Route::post('/register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@postRegister']);
   */
});


route::group(['prefix' => 'password'], function() {

  /*
  * Password reset link request routes
  */
    Route::get('/email', 'Auth\PasswordController@getEmail');
    Route::post('/email', 'Auth\PasswordController@postEmail');

    /*
     * Password reset routes
     */
    Route::get('/reset/{token}', 'Auth\PasswordController@getReset');
    Route::post('/reset', 'Auth\PasswordController@postReset');
});