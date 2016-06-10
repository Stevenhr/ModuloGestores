<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Actividadcontroller extends Controller
{
    public function index(){

    	$eje = app()->make(config('usuarios.modelo_eje'));
		$tematica = app()->make(config('usuarios.modelo_tematica'));
		$actividad = app()->make(config('usuarios.modelo_actividad'));

		$datos = [
	        'eje' => $eje->all(),
	        'tematica' => $tematica->all(),
	        'actividad' => $actividad->all(),
			'status' => session('status')
		];

    	return view('crear_actividad', $datos);
    }
}
