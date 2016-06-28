<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class Actividadcontroller extends Controller
{
    public function index(){

    	$eje = app()->make('App\Eje');
		$tematica = app()->make('App\Tematica');
		$actividad = app()->make('App\Actividad');
		$Localidad = app()->make('App\Localidad');
		$Tipo = app()->make('App\Tipo');
		//$Parque = app()->make('App\Parque');
		$TipoParque = app()->make('App\TipoParque');

		$datos = [
	        'eje' => $eje->all(),
	        'tematica' => $tematica->all(),
	        'actividad' => $actividad->all(),
	        'localidad' => $Localidad->all(),
	        'Tipo' => $Tipo->find(46),
	        'tipoparques' => $TipoParque->find(3),
			'status' => session('status')
		];

    	return view('crear_actividad', $datos);
    }


    public function MiActividad(){

		$PersonaActividad = app()->make('App\Persona');
		$datos = ['PersonaActividad' => $PersonaActividad->find(1046)];
    	return view('mi_actividad', $datos);
    }

   

}

