<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ProyectosController extends Controller
{
    public function index(): View
    {
        return view('proyectos');   //carga la vista dashboard.blade.php
    }
}