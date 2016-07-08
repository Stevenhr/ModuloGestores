<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use App\Persona;
use App\ActividadGestor;

class mis_actividades_promotores extends Controller
{
    //
    public function Mis_Actividad(){
    	$PersonaActividad = new Persona;
    	$datos = [
	        'PersonaActividad' => $PersonaActividad,
		];
    	//print_r($datos);
	    return view('mis_actividades_promotor', $datos);
    }


     public function procesarValidacionGestor(Request $request)
	{
		$validator = Validator::make($request->all(),
		    [
				'Fecha_Inicio' => 'required',
				'Fecha_Fin' => 'required'
        	]
        );

        if ($validator->fails()){
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
        }else{
        	$inf_model= $this->buscar($request->all());
        }
        return response()->json($inf_model);
	}

	public function buscar($input)
	{
		$id=$input['id_persona'];
		$id_act=$input['Id_Actividad_Promo'];
		$Fecha_Inicio=$input['Fecha_Inicio'];
		$Fecha_Fin=$input['Fecha_Fin'];
    	
    	if(empty($id_act)){
    		$consulta=ActividadGestor::with('localidad','persona','parque')->where('Id_Responsable',$id)->whereBetween('Fecha_Ejecucion',array($Fecha_Inicio, $Fecha_Fin))->get();
    	}else{
    		$consulta=ActividadGestor::with('localidad','persona','parque')->where('Id_Actividad_Gestor',$id_act)->whereBetween('Fecha_Ejecucion',array($Fecha_Inicio, $Fecha_Fin))->get();
    	}
    	return $consulta;
	}

	public function obtenerActividad(Request $request, $id_actividad){

		$datosActividad = ActividadGestor::with('localidad','persona','parque')->find($id_actividad);
		$datos = ['datosActividad' => $datosActividad];
    	return  $datos;
    }
}
