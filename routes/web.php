<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|


Route::get('/', function () {
    return view('welcome');
});*/




Route::get('/acceso',                         ['uses' => 'IndexController@getLogin',                 'as' => 'sistema.acceso']);
Route::post('/validar',                       ['uses' => 'IndexController@postLogin',                'as' => 'sistema.validar']);

Route::group(['middleware' => 'auth'], function () {

    Route::get('/getMcpiosPquias',            ['uses' => 'UtilidadesController@getMcpiosPquias',     'as' => 'sistema.getMcpiosPquias']);
    Route::get('/getEmpresa',                 ['uses' => 'UtilidadesController@getEmpresa',          'as' =>   'sistema.getEmpresa']);
    Route::get('/getEmpresaCoord',            ['uses' => 'UtilidadesController@getEmpresaCoord',     'as' => 'sistema.getEmpresaCoord']);
    Route::get('/getComercioCoord',           ['uses' => 'UtilidadesController@getComercioCoord',    'as' => 'sistema.getComercioCoord']);
    Route::get('/query',                      ['uses' => 'UtilidadesController@generarQueryProduccionAsignacion', 'as' => 'sistema.query']);
    Route::get('/getAmbito',                  ['uses' => 'UtilidadesController@getAmbito',           'as' =>   'sistema.getAmbito']);

    Route::get('/',                           ['uses' => 'IndexController@getIndex',                 'as' => 'sistema.index']);
    Route::post('/salir',                     ['uses' => 'IndexController@getLogout',                'as' => 'sistema.salir']);
    Route::post('/cambioClave',               ['uses' => 'IndexController@cambiarClave',             'as' => 'sistema.cambioClave']);


    Route::get('/mapas',                      ['uses' => 'MapasController@getIndex',                 'as' => 'sistema.mapas']);
    Route::get('/getCoordMap',                ['uses' => 'MapasController@getCoordMap',              'as' => 'sistema.getCoordMap']);

    Route::get('/mapasPanelIndustria',        ['uses' => 'MapasController@getPanel',                 'as' => 'sistema.panelIndustria']);
    Route::get('/mapasIndustria',             ['uses' => 'MapasController@getMapaIndustria',         'as' => 'sistema.mapasIndustria']);
    Route::get('/mapasKmlIndustria.kml',      ['uses' => 'MapasController@getKmlIndustria',          'as' => 'sistema.mapasKmlIndustria']);
    Route::get('/mapasKmzIndustria.kmz',      ['uses' => 'MapasController@getKmzIndustria',          'as' => 'sistema.mapasKmzIndustria']);

    Route::get('/mapasComercio',              ['uses' => 'MapasController@getMapaComercio',          'as' => 'sistema.mapasComercio']);
    Route::get('/mapasPanelComercio',         ['uses' => 'MapasController@getPanelComercio',         'as' => 'sistema.panelComercio']);
    Route::get('/mapasKmlComercio.kml',       ['uses' => 'MapasController@getKmlComercio',           'as' => 'sistema.mapasKmlComercio']);
    Route::get('/mapasKmzComercio.kmz',       ['uses' => 'MapasController@getKmzComercio',           'as' => 'sistema.mapasKmzComercio']);


    Route::get('/mapasPanelAmbitos',          ['uses' => 'MapasController@getPanelAmbitos',          'as' => 'sistema.panelAmbitos']);
    Route::get('/mapasAmbitos',               ['uses' => 'MapasController@getMapaAmbitos',           'as' => 'sistema.mapasAmbitos']);
    Route::get('/mapasKmzAmbitos.kmz',        ['uses' => 'MapasController@getKmzAmbitos',            'as' => 'sistema.mapasKmzAmbitos']);




    Route::get('/mapasPanelPlantas',          ['uses' => 'MapasController@getPanelPlantas',          'as' => 'sistema.panelPlantas']);
    Route::get('/mapasPlantas',               ['uses' => 'MapasController@getMapaPlantas',           'as' => 'sistema.mapasPlantas']);
    Route::get('/mapasKmzPlantas.kmz',        ['uses' => 'MapasController@getKmzPlantas',            'as' => 'sistema.getKmzPlantas']);




    Route::get('/dataProduccion',             ['uses' => 'GraficosController@getDataProduccion',     'as' => 'sistema.dataProduccion']);
    Route::get('/dataAsignacion',             ['uses' => 'GraficosController@getDataAsignacion',     'as' => 'sistema.dataAsignacion']);
    Route::get('/dataProdAsigAnual',          ['uses' => 'GraficosController@getDataProduccionAsignacionAnual', 'as' => 'sistema.dataProdAsigAnual']);


    Route::get('/empresas',                   ['uses' => 'EmpresasController@getIndex',              'as' => 'sistema.empresas']);
    Route::get('/empresas/data',              ['uses' => 'EmpresasController@getData',               'as' => 'sistema.empresas.data']);
    Route::post('/empresas/view',             ['uses' => 'EmpresasController@verEmpresa',            'as' => 'sistema.empresas.view']);

    Route::post('/empresas/detalleSubastas',  ['uses' => 'EmpresasController@getDetalleDicomSubastas', 'as' => 'sistema.empresas.detalleDicomSubastas']);

    Route::post('/empresas/add',              ['uses' => 'EmpresasController@agregarEmpresa',        'as' => 'sistema.empresas.add']);
    Route::post('/empresas/find',             ['uses' => 'EmpresasController@buscarEmpresa',         'as' => 'sistema.empresas.find']);
    Route::post('/empresas/upd',              ['uses' => 'EmpresasController@actualizarEmpresa',     'as' => 'sistema.empresas.upd']);
    Route::post('/empresas/del',              ['uses' => 'EmpresasController@eliminarEmpresa',       'as' => 'sistema.empresas.del']);
    Route::get('/empresas/sectorSubsector',   ['uses' => 'UtilidadesController@getSectorSubsector',  'as' => 'sistema.empresas.sectorSubsector']);


    Route::get('/plantas',                    ['uses' => 'PlantasController@getIndex',               'as' => 'sistema.plantas']);
    Route::get('/plantas/data',               ['uses' => 'PlantasController@getData',                'as' => 'sistema.plantas.data']);
    Route::post('/plantas/add',               ['uses' => 'PlantasController@agregarPlanta',          'as' => 'sistema.plantas.add']);
    Route::post('/plantas/find',              ['uses' => 'PlantasController@buscarPlanta',           'as' => 'sistema.plantas.find']);
    Route::post('/plantas/upd',               ['uses' => 'PlantasController@actualizarPlanta',       'as' => 'sistema.plantas.upd']);
    Route::post('/plantas/del',               ['uses' => 'PlantasController@eliminarPlanta',         'as' => 'sistema.plantas.del']);
    Route::post('/plantas/view',              ['uses' => 'PlantasController@verEmpresa',             'as' => 'sistema.plantas.view']);

    Route::post('/plantas/add/info',          ['uses' => 'PlantasController@agregarInfoComplementaria','as' => 'sistema.plantas.info.add']);
    Route::post('/plantas/info/add',          ['uses' => 'PlantasController@agregarInfoComplementaria','as' => 'sistema.plantas.info.add']);
    Route::post('/plantas/info/data',         ['uses' => 'PlantasController@getDataInfoComplementaria','as' => 'sistema.plantas.info.data']);
    Route::post('/plantas/info/del',          ['uses' => 'PlantasController@eliminarInfoComplementaria','as' => 'sistema.plantas.info.del']);
    Route::post('/plantas/info/uplFoto',      ['uses' => 'PlantasController@subirFoto',              'as' => 'sistema.plantas.info.uplFoto']);
    Route::post('/plantas/info/delFoto',      ['uses' => 'PlantasController@eliminarFoto',           'as' => 'sistema.plantas.info.delFoto']);
    Route::post('/plantas/info/src',          ['uses' => 'PlantasController@buscarInfoComplementaria','as' => 'sistema.plantas.info.src']);
    Route::post('/plantas/info/upd',          ['uses' => 'PlantasController@actualizarInfoComplementaria','as' => 'sistema.plantas.info.upd']);

    Route::get('/preportes',                  ['uses' => 'PlantasController@getIndexReportes',       'as' => 'sistema.preportes']);
    Route::get('/preportes/getPlantasAct',    ['uses' => 'PlantasController@getPlantasActualizadas', 'as' => 'sistema.preportes.getPlantasAct']);
    Route::get('/preportes/getPocentajeProd', ['uses' => 'PlantasController@getPocentajeProd',       'as' => 'sistema.preportes.getPocentajeProd']);
    Route::get('/preportes/getPocentajeProdEdo', ['uses' => 'PlantasController@getPocentajeProdEdo',       'as' => 'sistema.preportes.getPocentajeProdEdo']);




    Route::get('/usuarios',                   ['uses' => 'UserController@getIndex',                  'as' => 'sistema.usuarios']);
    Route::get('/usuarios/data',              ['uses' => 'UserController@getData',                   'as' => 'sistema.usuarios.data']);
    Route::post('/usuarios/agregar',          ['uses' => 'UserController@agregarUsuario',            'as' => 'sistema.usuarios.add']);
    Route::post('/usuarios/buscar',           ['uses' => 'UserController@buscarUsuario',             'as' => 'sistema.usuarios.find']);
    Route::post('/usuarios/actualizar',       ['uses' => 'UserController@actualizarUsuario',         'as' => 'sistema.usuarios.upd']);
    Route::post('/usuarios/eliminar',         ['uses' => 'UserController@eliminarUsuario',           'as' => 'sistema.usuarios.del']);
    Route::post('/usuarios/reset',            ['uses' => 'UserController@resetClaveUsuario',         'as' => 'sistema.usuarios.res']);
    Route::post('/usuarios/actdes',           ['uses' => 'UserController@activarDesactivarUsuario',  'as' => 'sistema.usuarios.ades']);
    Route::get('/usuarios/checkUser',         ['uses' => 'UserController@comprobarUsuario',          'as' => 'sistema.usuarios.checkUser']);

    Route::get('/logs',                       ['uses' => 'LogController@getIndex',                   'as' => 'sistema.logs']);
    Route::any('/logs/data',                  ['uses' => 'LogController@getData',                    'as' => 'sistema.logs.data']);
    Route::any('/logs/reporteIndustria',      ['uses' => 'LogController@getReporteIndustria',        'as' => 'sistema.logs.reporteIndustria']);
    Route::any('/logs/reporteComercio',       ['uses' => 'LogController@getReporteComercio',         'as' => 'sistema.logs.reporteComercio']);

    Route::get('/ambitos',                    ['uses' => 'AmbitosController@getIndex',               'as' => 'sistema.ambitos']);
    Route::get('/ambitos/data',               ['uses' => 'AmbitosController@getData',                'as' => 'sistema.ambitos.data']);
    Route::post('/ambitos/add',               ['uses' => 'AmbitosController@agregarAmbito',          'as' => 'sistema.ambitos.add']);
    Route::post('/ambitos/find',              ['uses' => 'AmbitosController@buscarAmbito',           'as' => 'sistema.ambitos.find']);
    Route::post('/ambitos/upd',               ['uses' => 'AmbitosController@actualizarAmbito',       'as' => 'sistema.ambitos.upd']);
    Route::post('/ambitos/del',               ['uses' => 'AmbitosController@eliminarAmbito',         'as' => 'sistema.ambitos.del']);
    Route::post('/ambitos/view',              ['uses' => 'AmbitosController@verAmbito',              'as' => 'sistema.ambitos.view']);
    Route::post('/ambitos/uplPol',            ['uses' => 'AmbitosController@cargarPoligono',         'as' => 'sistema.ambitos.uplPol']);

    Route::post('/ambitos/uplFoto',           ['uses' => 'AmbitosController@subirFoto',              'as' => 'sistema.ambitos.uplFoto']);
    Route::post('/ambitos/delFoto',           ['uses' => 'AmbitosController@eliminarFoto',           'as' => 'sistema.ambitos.delFoto']);

    Route::get('/comercios',                  ['uses' => 'ComerciosController@getIndex',             'as' => 'sistema.comercios']);
    Route::get('/comercios/data',             ['uses' => 'ComerciosController@getData',              'as' => 'sistema.comercios.data']);
    Route::post('/comercios/add',             ['uses' => 'ComerciosController@agregarComercio',      'as' => 'sistema.comercios.add']);
    Route::post('/comercios/find',            ['uses' => 'ComerciosController@buscarComercio',       'as' => 'sistema.comercios.find']);
    Route::post('/comercios/upd',             ['uses' => 'ComerciosController@actualizarComercio',   'as' => 'sistema.comercios.upd']);
    Route::post('/comercios/del',             ['uses' => 'ComerciosController@eliminarComercio',     'as' => 'sistema.comercios.del']);
    Route::post('/comercios/view',            ['uses' => 'ComerciosController@verComercio',          'as' => 'sistema.comercios.view']);

});

Route::post('/uplProduccion',                 ['uses' => 'EmpresasController@uploadProduccion',      'as' => 'sistema.empresas.uplProduccion']);
Route::post('/uplDicom',                      ['uses' => 'EmpresasController@uploadDicom',           'as' => 'sistema.empresas.uplDicom']);
Route::any('/searchDicom',                    ['uses' => 'EmpresasController@searchDicom',           'as' => 'sistema.empresas.searchDicom']);
Route::any('/searchSaiise',                   ['uses' => 'EmpresasController@getDataSAIISE',         'as' => 'sistema.empresas.searchSaiise']);
Route::get('/qryProduccion',                  ['uses' => 'UtilidadesController@generarQueryAsignacionHistorico', 'as' => 'sistema.qryProduccion']);

Route::get('/empresas/visita',                  ['uses' => 'EmpresasController@generarFicha', 'as' => 'sistema.empresas.visitas']);


Route::get('/prueba', function () {
    $roles = "30";
    dd(\App\Http\Controllers\UtilidadesController::verificarRol($roles, 10));
});






