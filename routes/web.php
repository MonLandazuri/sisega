<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\ProyectosController;
use App\Http\Controllers\PartidasController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ExcelImportController; //Controlador Excel


//Route::get('/', function () {return view('dashboard');});
//Route::get('/',[InicioController::class, 'index'])->name('inicio');
Route::get('/proyectos',[ProyectosController::class, 'mostrarProyectos'])->name('proyectos')->middleware('auth');
Route::get('/nuevo-proyecto',[ProyectosController::class, 'nuevoProyecto'])->name('nuevo.proyecto')->middleware('auth');
Route::post('/guardar-nuevo-proyecto', [ProyectosController::class, 'guardarNuevoProyecto'])->name('guardar.nuevo.proyecto')->middleware('auth');

Route::get('/partidas/{id_proyecto}',[PartidasController::class, 'mostrarPartidasPorProyecto'])->name('proyecto.partidas')->middleware('auth');

Route::get('/usuarios',[UsuariosController::class, 'index'])->name('usuarios');

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