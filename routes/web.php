<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\ProyectosController;
use App\Http\Controllers\UsuariosController;


//Route::get('/', function () {return view('dashboard');});
Route::get('/',[InicioController::class, 'index'])->name('inicio');
Route::get('/proyectos',[ProyectosController::class, 'index'])->name('proyectos');
Route::get('/usuarios',[UsuariosController::class, 'index'])->name('usuarios');