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

		$datos = [
	        'eje' => $eje->all(),
	        'tematica' => $tematica->all(),
	        'actividad' => $actividad->all(),
	        'localidad' => $Localidad->all(),
			'status' => session('status')
		];

    	return view('crear_actividad', $datos);
    }
}
