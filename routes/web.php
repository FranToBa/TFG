<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/noticias', 'NoticiasController@index')->name('noticias');
Route::get('/noticia/foto/{filename}', 'NoticiasController@getImage')->name('noticia.foto');
Route::get('/noticia/{id}', 'NoticiasController@verNoticia')->name('noticia.ver');
Route::get('/eventos', 'EventosController@index')->name('eventos');
Route::get('/evento/foto/{filename}', 'EventosController@getImage')->name('evento.foto');
Route::get('/evento/{id}', 'EventosController@verEvento')->name('evento.ver');
Route::post('/comentario/guardar', 'ComentariosController@guardarComentario')->name('comentario.guardar');
Route::get('/comentario/borrar/{id}', 'ComentariosController@borrarComentario')->name('comentario.borrar');
Route::post('ckeditor/image_upload', 'CKEditorController@upload')->name('upload');
Route::post('/queja/guardar', 'QuejasController@guardarQueja')->name('queja.guardar');
Route::view('/turismo', 'turismo')->name('turismo');

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth'], function () {
  Route::get('/configuracion', 'UserController@config')->name('config');
  Route::post('/user/update', 'UserController@update')->name('user.update');
  Route::post('/user/updatePassword', 'UserController@updatePassword')->name('user.updatePassword');
  Route::get('/user/foto/{filename}', 'UserController@getImage')->name('user.foto');
  Route::post('/asistencia/anadir', 'AsistenciaController@anadirAsistencia')->name('asistencia.anadir');
  Route::get('/asistencia/eliminar/{evento_id}/{id_usuario}', 'AsistenciaController@borrarAsistencia')->name('asistencia.eliminar');
  Route::get('/tramites/tramite/{filename}', 'UserController@getTramite')->name('tramite.pdf');
  Route::get('/tramites', 'TramitesController@elegirForm')->name('tramites');
  Route::post('/tramite/formulario', 'TramitesController@presentarForm')->name('tramite');
  Route::post('/tramite/formulario/enviado', 'TramitesController@guardarTramite')->name('tramite.enviar');
  Route::get('/mistramites', 'UserController@misTramites')->name('mistramites');
  Route::get('/misnotificaciones', 'UserController@misNotificaciones')->name('misnotificaciones');
});

/*
|--------------------------------------------------------------------------
| Administrador Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth_admin'], function () {
  Route::get('/admin/usuarios', 'AdminController@gestionUsuarios')->name('admin.usuarios');
  Route::get('/admin/usuarios/filtro', 'AdminController@filtroUsuarios')->name('admin.usuarios.filtro');
  Route::get('/admin/usuarios/borrar/{id}', 'AdminController@borrarUsuario')->name('admin.borrarUsuario');
  Route::get('/admin/usuarios/cambiarTipo/{id}/{tipo}', 'AdminController@convertirUsuario')->name('admin.convertirUsuario');
  Route::get('/admin/quejas', 'AdminController@gestionQuejas')->name('admin.quejas');
  Route::get('/admin/quejas/borrar/{id}', 'AdminController@borrarQueja')->name('admin.borrarQueja');
  Route::get('/admin/tramites', 'AdminController@gestionTramites')->name('admin.tramites');
  Route::get('/admin/tramites/filtro', 'AdminController@filtroTramites')->name('admin.tramites.filtro');
  Route::post('/admin/tramites/respuesta', 'AdminController@contestarTramites')->name('admin.contestarTramite');
  Route::get('/admin/nuevo_tramite', 'AdminController@nuevoTramite')->name('admin.nuevoTramite');
  Route::post('/admin/insertar_tramite', 'AdminController@insertarTramite')->name('admin.insertarTramite');
  Route::get('/admin/configuracion_tramites', 'AdminController@configuracionTramites')->name('admin.configTramites');
  Route::get('/admin/borrarTramite/{tipo}', 'AdminController@borrarTramite')->name('admin.borrarTramite');
  Route::get('/admin/borrarCampo/{id}', 'AdminController@borrarCampo')->name('admin.borrarCampo');
  Route::post('/admin/actualizarTramite', 'AdminController@actualizarTramite')->name('admin.actualizarTramite');
  Route::post('/admin/quejas/respuesta', 'AdminController@contestarQuejas')->name('admin.contestarQueja');
  Route::get('/admin/quejas/filtro', 'AdminController@filtroQuejas')->name('admin.quejas.filtro');
});

/*
|--------------------------------------------------------------------------
| Colaborador Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth_colab'], function () {
  Route::get('/colaborador/editarNoticia/{id}', 'ColaboradorController@editarNoticia')->name('colab.editarNoticia');
  Route::get('/colaborador/borrarNoticia/{id}', 'ColaboradorController@borrarNoticia')->name('colab.borrarNoticia');
  Route::get('/colaborador/nuevaNoticia', 'ColaboradorController@nuevaNoticia')->name('colab.nuevaNoticia');
  Route::post('/colaborador/insertarNoticia', 'ColaboradorController@insertarNoticia')->name('colab.insertarNoticia');
  Route::post('/colaborador/updateNoticia', 'ColaboradorController@updateNoticia')->name('colab.updateNoticia');
  Route::get('/colaborador/editarEvento/{id}', 'ColaboradorController@editarEvento')->name('colab.editarEvento');
  Route::get('/colaborador/borrarEvento/{id}', 'ColaboradorController@borrarEvento')->name('colab.borrarEvento');
  Route::get('/colaborador/nuevoEvento', 'ColaboradorController@nuevoEvento')->name('colab.nuevoEvento');
  Route::post('/colaborador/insertarEvento', 'ColaboradorController@insertarEvento')->name('colab.insertarEvento');
  Route::post('/colaborador/updateEvento', 'ColaboradorController@updateEvento')->name('colab.updateEvento');
});
