<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\ProyectosController;
use App\Http\Controllers\PartidasController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ContratistasController;
use App\Http\Controllers\OrdenDeCompraController;
use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\ExcelImportControllerExtra;
use App\Http\Controllers\ContratistaArchivoController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\AnticipoController;
use App\Http\Controllers\SublistadoContratistaController;

Route::get('/proyectos',[ProyectosController::class, 'mostrarProyectos'])->name('proyectos')->middleware('auth');
Route::get('/nuevo-proyecto',[ProyectosController::class, 'nuevoProyecto'])->name('nuevo.proyecto')->middleware('auth');
Route::post('/guardar-nuevo-proyecto', [ProyectosController::class, 'guardarNuevoProyecto'])->name('guardar.nuevoproyecto')->middleware('auth');
Route::patch('/proyectos/{proyecto}/finalizar', [ProyectosController::class, 'finalizarProyecto'])->name('proyectos.finalizar');
Route::patch('/proyectos/{proyecto}/actualizar-usuarios', [ProyectosController::class, 'actualizarUsuarios'])->name('proyectos.actualizarUsuarios');
Route::get('/proyectos/{proyecto}/usuarios-asignados', [ProyectosController::class, 'getUsuariosAsignados']);

Route::get('/contratistas',[ContratistasController::class, 'mostrarContratistas'])->name('contratistas')->middleware('auth');
Route::get('/info-contratista/{id_contratista}',[ContratistasController::class, 'infoContratista'])->name('info.contratista')->middleware('auth');
Route::get('/nuevo-contratista',[ContratistasController::class, 'nuevoContratista'])->name('nuevo.contratista')->middleware('auth');
Route::post('/guardar-nuevo-contratista', [ContratistasController::class, 'guardarNuevoContratista'])->name('guardar.nuevocontratista')->middleware('auth');

Route::post('/contratistas/{contratista}/archivos', [ContratistaArchivoController::class, 'store'])->name('contratistas.archivos.store');
Route::get('/contratistas/{contratista}/archivos', [ContratistaArchivoController::class, 'index'])->name('contratistas.archivos.index'); 
Route::delete('/archivos/{contratistaArchivo}', [ContratistaArchivoController::class, 'destroy'])->name('contratistas.archivos.destroy');

Route::get('/contratistas/{id_proyecto}/sublistado', [SublistadoContratistaController::class, 'show'])->name('sublistado.show');
Route::post('/contratistas/sublistado', [SublistadoContratistaController::class, 'store'])->name('sublistado.store');
//Route::post('/contratistas/{id_contratista}/proyecto/{id_proyecto}/sublistado', [SublistadoContratistaController::class, 'mostrarSublistado'])->name('sublistado.mostrarsublistado');

Route::get('/partidas/{id_proyecto}',[PartidasController::class, 'mostrarPartidasPorProyecto'])->name('proyecto.partidas')->middleware('auth');
Route::get('/partidas/nueva-oc/{id_proyecto}',[OrdenDeCompraController::class, 'nuevaOC'])->name('nueva.oc')->middleware('auth');
//Route::post('/partidas/listado-nueva-oc/',[OrdenDeCompraController::class, 'listadoNuevaOC'])->name('listado.nuevaoc')->middleware('auth');
Route::get('/partidas/listado-nueva-oc/{id_proyecto}',[OrdenDeCompraController::class, 'listadoNuevaOC'])->name('listado.nuevaoc')->middleware('auth');
Route::post('/partidas/previsualizar-orden/',[OrdenDeCompraController::class, 'revisionNuevaOC'])->name('revision.nuevaoc')->middleware('auth');
Route::post('/partidas/agregar-nueva-oc/',[OrdenDeCompraController::class, 'agregarNuevaOC'])->name('agregar.nuevaoc')->middleware('auth');
Route::get('/partidas/nuevo-partida/{id_proyecto}',[PartidasController::class, 'nuevoPartida'])->name('nuevo.partida')->middleware('auth');
Route::post('/guardar-nuevo-partida', [PartidasController::class, 'guardarNuevoPartida'])->name('guardar.nuevopartida')->middleware('auth');
Route::get('/editar-partida/{id_partida}',[PartidasController::class, 'editarPartida'])->name('editar.partida')->middleware('auth');
Route::post('/guardar-editar-partida', [PartidasController::class, 'guardarEditarPartida'])->name('guardar.editarpartida')->middleware('auth');
Route::delete('/partidas/eliminar-partida/{partida}', [PartidasController::class, 'eliminarPartida'])->name('partidas.destroy')->middleware('auth');

Route::get('/partidas/nuevo-extra/{id_proyecto}',[PartidasController::class, 'nuevoExtra'])->name('nuevo.extra')->middleware('auth');
Route::post('/guardar-nuevo-extra', [PartidasController::class, 'guardarNuevoExtra'])->name('guardar.nuevoextra')->middleware('auth');
Route::get('/editar-extra/{id_extra}', [PartidasController::class, 'editarExtra'])->name('editar.extra')->middleware('auth');
Route::post('/guardar-editar-extra', [PartidasController::class, 'guardarEditarExtra'])->name('guardar.editarextra')->middleware('auth');
Route::delete('/partidas/eliminar-extra/{extra}', [PartidasController::class, 'eliminarExtra'])->name('extra.destroy')->middleware('auth');

Route::get('/ordenes/{orden}/pdf', [PdfController::class, 'exportarPDF'])->name('ordenes.pdf');

Route::post('/anticipos', [AnticipoController::class, 'store'])->name('anticipos.store');

Route::get('/usuarios',[UsuariosController::class, 'index'])->name('usuarios');
Route::get('/users/create', [UsuariosController::class, 'create'])->name('users.create')->middleware('auth');
Route::post('/users', [UsuariosController::class, 'store'])->name('users.store')->middleware('auth');

// Ruta para mostrar el formulario de login
Route::get('/login', [InicioController::class, 'showLoginForm'])->name('login');

// Ruta para procesar el envío del formulario de login
Route::post('/login', [InicioController::class, 'login'])->name('login.submit');

// Ruta para la página de inicio protegida (solo para usuarios autenticados)
Route::get('/', [InicioController::class, 'index'])->name('inicio')->middleware('auth');

// Ruta para cerrar sesión
Route::get('/logout', [InicioController::class, 'logout'])->name('logout');
//Route::get('/',[InicioController::class, 'login'])->name('login');

// Ruta para mostrar el formulario de subida del archivo Excel
Route::get('/importar-excel/{id_proyecto}', [ExcelImportController::class, 'showImportForm'])->name('import.form')->middleware('auth');

// Ruta para procesar la subida y la importación del archivo Excel
Route::post('/importar-excel/{id_proyecto}', [ExcelImportController::class, 'importExcel'])->name('import.process')->middleware('auth');

// Ruta para mostrar el formulario de subida del archivo Excel
Route::get('/importar-extra/{id_proyecto}', [ExcelImportControllerExtra::class, 'showImportFormExtra'])->name('import.form.extra')->middleware('auth');

// Ruta para procesar la subida y la importación del archivo Excel
Route::post('/importar-extra/{id_proyecto}', [ExcelImportControllerExtra::class, 'importExcelExtra'])->name('import.process.extra')->middleware('auth');

Route::middleware('auth')->group(function () {

    Route::get('/usuarios',[UsuariosController::class, 'mostrarUsuarios'])->name('usuarios');

    // Ruta para mostrar el formulario de cambio de contraseña
    Route::get('/usuarios/password', [PerfilController::class, 'editPassword'])->name('usuarios.editar.password');

    // Ruta para procesar el cambio de contraseña
    Route::put('/usuarios/password', [PerfilController::class, 'updatePassword'])->name('usuarios.actualizar.password');
});

Route::get('/ordenes/{ordenDeCompra}/detalles-modal', [OrdenDeCompraController::class, 'showDetailsForModal'])->name('ordenes.detalles.modal');
