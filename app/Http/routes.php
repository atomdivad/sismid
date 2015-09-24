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
    return view('app');
});

Route::group(['middleware' => ['auth', 'needsRole'], 'is' => ['admin', 'A2'], 'any' => true], function() {

    Route::get('/home', ['as' => 'home', function () {
        return view('home');
    }]);

    Route::group(['prefix' => 'pid'], function() {

        Route::get('create', ['as' => 'pid.create', 'uses' => 'PidController@create']);
        Route::post('/', ['as' => 'pid.store', 'uses' => 'PidController@store']);
    });

});

Route::group(['prefix' => 'api'], function(){

    Route::get('/uf/{id}/cidades/', ['as' => 'getCidades', 'uses' => 'ApiController@getCidades']);
});


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
    Route::get('/register', ['as' => 'auth.formRegister', 'uses' => 'Auth\AuthController@getRegister']);
    Route::post('/register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@postRegister']);
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