<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ControlEquipoController extends Controller
{
    public function index(): View
    {
        return view('control_equipo.index');
    }

    public function retiro(): View
    {
        return view('control_equipo.retiro');
    }
}
