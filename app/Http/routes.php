<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {                
    return view('welcome');
});

Route::get('uno', function () {                
    return 'welcome';
});

 
Route::get('/personas', '\Idrd\Usuarios\Controllers\PersonaController@index');
Route::get('/personas/service/obtener/{id}', '\Idrd\Usuarios\Controllers\PersonaController@obtener');
Route::get('/personas/service/buscar/{key}', '\Idrd\Usuarios\Controllers\PersonaController@buscar');
Route::get('/personas/service/ciudad/{id_pais}', '\Idrd\Usuarios\Controllers\LocalizacionController@buscarCiudades');
Route::post('/personas/service/procesar/', '\Idrd\Usuarios\Controllers\PersonaController@procesar');



Route::get('/CrearActividad', 'Actividadcontroller@index');
Route::get('/Modificar', 'Actividadcontroller@index');
Route::get('/MisProgramaciones', 'Actividadcontroller@MiActividad');
Route::get('/MisActividades', 'mis_actividades_promotores@Mis_Actividad');

Route::get('/actividad/service/obtener/{id_actividad}', 'Actividadcontroller@obtenerActividad');
Route::post('/actividad/service/crearActividad/', 'ConfiguracionActividadController@procesarValidacion');
Route::get('/actividad/service/tematica/{id_eje}', 'ConfiguracionActividadController@buscarTematicas');
Route::get('/actividad/service/actividad/{id_tematica}', 'ConfiguracionActividadController@buscarActividades');
Route::get('/actividad/service/persona_tipo/{id_tipo}', '\Idrd\Usuarios\Controllers\PersonaController@buscarPersonaTipo');
Route::get('/actividad/service/Eje/{id_eje}', 'ConfiguracionActividadController@buscarEje');
Route::get('/actividad/service/Tematica/{id_tematica}', 'ConfiguracionActividadController@buscarTematica');
Route::get('/actividad/service/Actividad/{id_actividad}', 'ConfiguracionActividadController@buscarActividad');

Route::post('/gestores/service/misActividadesGestor/', 'mis_actividades_promotores@procesarValidacionGestor');
Route::get('/gestores/service/obtener/{id_actividad}', 'mis_actividades_promotores@obtenerActividad');
Route::post('/gestores/service/datos_actividades/', 'mis_actividades_promotores@procesarValidacionDatosEjecucion');
Route::post('/gestores/service/datos_novedades/', 'mis_actividades_promotores@procesarValidacionDatosNovedades');
Route::post('/gestores/service/registro_ejecucion/', 'mis_actividades_promotores@procesarValidacionRegistroEjecucion');





/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
