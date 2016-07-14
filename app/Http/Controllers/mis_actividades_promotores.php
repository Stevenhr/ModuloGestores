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

    public function procesarValidacionDatosEjecucion(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
               /* 'Inst_grupo_comu' => 'required',
                'Localidad_eje' => 'required',
                'Tipo_entidad' => 'required',
                'Tipo_eje' => 'required',
                'Condicion' => 'required',
                'Situacion' => 'required',*/
                'M_0_5' => 'numeric',
                'F_0_5' => 'numeric',
                'M_6_12' => 'numeric',
                'F_6_12' => 'numeric',
                'M_13_17' => 'numeric',
                'F_13_17' => 'numeric',
                'M_18_26' => 'numeric',
                'F_18_26' => 'numeric',
                'M_27_59' => 'numeric',
                'F_27_59' => 'numeric',
                'M_60' => 'numeric',
                'F_60' => 'numeric'
            ]
        );

        if ($validator->fails()){
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
        }else{
            return response()->json(array('status' => 'ok'));
        }
    }

    public function procesarValidacionDatosNovedades(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                //'Id_Requisito' => 'required',
                'causa' => 'required:alpha',
                'accion' => 'required:alpha'
            ]
        );
        if ($validator->fails()){
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
        }else{
            return response()->json(array('status' => 'ok'));
        }
    }

    public function procesarValidacionRegistroEjecucion(Request $request)
    {
        //var_dump($request);


        $validator = Validator::make($request->all(),
            [
                'puntualidad' => 'required',
                'divulgacion' => 'required',
                'escenarioMontaje' => 'required',
                'cumplimiento' => 'required',
                'variedadCreatividad' => 'required',
                'seguridad' => 'required',
                'nombreRepresentante' => 'required|alpha',
                'telefonoRepresentante' => 'required|alpha',
                'imagen1' => 'required|mimes:jpeg,jpg,png,bmp',
                'imagen2' => 'required|mimes:jpeg,jpg,png,bmp',
                'imagen3' => 'mimes:jpeg,jpg,png,bmp',
                'imagen4' => 'mimes:jpeg,jpg,png,bmp',
                'listaAsistencia' => 'required|mimes:pdf',
                'acta' => 'required|mimes:pdf'

            ]
        );


        if ($validator->fails()){
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
        }else{
            $this->guardar($request->all());
        }


        return response()->json(array('status' => 'ok'));
    }


    public function guardar($input)
    {
        $model_A = new ActividadGestor;
        return $this->crear_ejecucion($model_A, $input);
    }

    public function crear_ejecucion($model, $input)
    {
        $model['Id_Persona'] = $input['Id_Responsable'];
        $model['Id_Responsable'] = $input['Id_Responsable'];
        $model['Fecha_Ejecucion'] = $input['Fecha_Ejecucion'];
        $model['Hora_Incial'] = $input['Hora_Inicio'];
        $model['Hora_Final'] = $input['Hora_Fin'];
        $model['Localidad'] = $input['Id_Localidad'];
        $model['Parque'] = $input['Parque'];
        $model['Caracteristica_Lugar'] = $input['Caracteristica_Lugar'];
        $model['Instit_Grupo_Comun'] = $input['Institucion_Grupo'];
        $model['Caracteristica_Poblacion'] = $input['Caracteristica_poblacion'];
        $model['Numero_Asistente'] = $input['Numero_Asistentes'];
        $model['Hora_Implementacion'] = $input['Hora_Implementacion'];

        $model['Nombre_Contacto'] = $input['Persona_Contacto'];
        $model['Rool_Comunidad'] = $input['Roll_Comunidad'];
        $model['Telefono'] = $input['Telefono'];
        $model['Fecha_Registro'] = date("Y-m-d G:i:s");
        $model['Estado'] = '1';
        $model['Estado_Ejecucion'] = '1';

        $model->save();
        

        $data0 = json_decode($input['Dato_Actividad']);
        foreach($data0 as $obj){
            $model->actividadgestorActividadEjeTematica()->attach($model->Id_Actividad_Gestor,['eje_id'=>$obj->id_eje,
                'tematica_id'=>$obj->id_tematica,
                'actividad_id'=>$obj->id_act]);
        }

        $model_P = new Persona;
        $data1 = json_decode($input['Personas_Acompanates']);
        foreach($data1 as $obj){
            $model_P->actividadGestor()->attach($model->Id_Actividad_Gestor,['persona_id'=>$obj->acompa]);
        }
        
        return $model;
    }


}
