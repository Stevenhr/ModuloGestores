<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Idrd\Usuarios\Repo\PersonaInterface;

class Actividadcontroller extends Controller
{


   protected $Usuario;
   protected $repositorio_personas;
   
   public function __construct(PersonaInterface $repositorio_personas){
       if (isset($_SESSION['Usuario']))
           $this->Usuario = $_SESSION['Usuario'];
           $this->repositorio_personas = $repositorio_personas;
   }

   public function show(Request $request){
   	/*if ($request->has('vector_modulo'))
        {   
            $vector = urldecode($request->input('vector_modulo'));
            $user_array = unserialize($vector);

        
            $_SESSION['Usuario'] = $user_array;
            $persona = $this->repositorio_personas->obtener($_SESSION['Usuario'][0]);
            $_SESSION['Usuario']['Persona'] = $persona;
            $this->Usuario = $_SESSION['Usuario'];
        } else {
            if(!isset($_SESSION['Usuario']))
                $_SESSION['Usuario'] = '';
        }
        
        if ($_SESSION['Usuario'] == '')
            return redirect()->away('http://www.idrd.gov.co/SIM_Prueba/Presentacion/');


        $deportista = $_SESSION['Usuario']['Persona'];*/

        return view('welcome');

   }




   

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
	        'Tipo' => $Tipo->find(50),
	        'tipoparques' => $TipoParque->find(3),
			'status' => session('status')
		];

    	return view('crear_actividad', $datos);
    }

    public function MiActividad(){

		$PersonaActividad = app()->make('App\Persona');
		$Tipo = app()->make('App\Tipo');
		$Localidad = app()->make('App\Localidad');
		$TipoParque = app()->make('App\TipoParque');
		$datos = [
			'PersonaActividad' => $PersonaActividad->find(1046),
			'Tipo' => $Tipo->find(50),
			'tipoparque' => $TipoParque->with('parques')->find(3),
			'localidad' => $Localidad->all()
		];
		
    	return view('mi_actividad', $datos);
    }

    public function obtenerActividad(Request $request, $id_actividad){

		$datosActividad = app()->make('App\ActividadGestor');
		$datos = ['datosActividad' => $datosActividad->find($id_actividad)];
    	return  $datos;
    }

     

}

