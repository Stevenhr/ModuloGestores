<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Http\Requests;
use Validator;
use App\ActividadGestor;
use App\Ejecucion;
use App\Novedad;

class aprobacion_actividades extends Controller
{
    //
   protected $Usuario;
   
   public function __construct(){
       if (isset($_SESSION['Usuario']))
           $Usuario = $_SESSION['Usuario'];           
   }

    public function Mis_Actividad(){
		$Tipo = app()->make('App\Tipo');
		$Localidad = app()->make('App\Localidad');
		$TipoParque = app()->make('App\TipoParque');
		$datos = [
			'Tipo' => $Tipo->find(50),
			'tipoparque' => $TipoParque->with('parques')->find(3),
			'localidad' => $Localidad->all()
		];
    	return view('aprobar_actividad', $datos);
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
		$id=$_SESSION['Usuario'][0];
		$id_act=$input['Id_Actividad_Promo'];
		$Fecha_Inicio=$input['Fecha_Inicio'];
		$Fecha_Fin=$input['Fecha_Fin'];
    	
    	if(empty($id_act)){
    		$persona=Persona::with('localidades')->find($id);
    		
    		$localidades_persona = [];
    		
    		foreach ($persona->localidades as $localidad) 
    			$localidades_persona[] = $localidad->Id_Localidad;

    		//dd($localidades_persona); exit();
    		$consulta=ActividadGestor::with('localidad','persona','parque','personaProgramador')->whereIn('Localidad',$localidades_persona)->whereBetween('Fecha_Ejecucion',array($Fecha_Inicio, $Fecha_Fin))->get();


    	}else{
    		$consulta=ActividadGestor::with('localidad','persona','parque','personaProgramador')->where('Id_Actividad_Gestor',$id_act)->whereBetween('Fecha_Ejecucion',array($Fecha_Inicio, $Fecha_Fin))->get();
    	}
    	return $consulta;
	}
	public function obtenerActividad(Request $request, $id_actividad){
		
		$datosActividad = ActividadGestor::with('localidad','persona','parque')->find($id_actividad);
		$datos = ['datosActividad' => $datosActividad];
    	return  $datos;
    }


    public function obtenerEjecucion(Request $request, $id_actividad){
		$Ejecucion = Ejecucion::where('Id_Actividad_Gestor',$id_actividad)->with('tipoEntidad','tipoPersona','condicion','situacion','localidad')->get();
    	$Novedad = Novedad::where('Id_Actividad_Gestor',$id_actividad)->get();
		$datosActividad = ActividadGestor::with('calificaciomServicio')->find($id_actividad);
		
		$datos = ['datosActividad' => $datosActividad,'Ejecucion'=>$Ejecucion,'Novedad'=>$Novedad];
    	return  response()->json($datos);
    }

    public function activarProgramacion(Request $request, $id_actividad){

		ActividadGestor::where('Id_Actividad_Gestor', $id_actividad)->update(array('Estado' => 2));
    	return  "ok";
    }

    public function aprobarEjecucion(Request $request, $id_actividad){
    	//aprobar Ejecucion y programación, desactiva la modificación de la programacion y la ejecución.
		ActividadGestor::where('Id_Actividad_Gestor', $id_actividad)->update(array('Estado_Ejecucion' => 3,'Estado' => 3)); 
    	return  "ok";
    }


    public function cancelarProgramacion(Request $request, $id_actividad){

		ActividadGestor::where('Id_Actividad_Gestor', $id_actividad)->update(array('Estado' => 1));
    	return  "ok";
    }



    public function procesarModificacionValidacion(Request $request)
	{
		$validator = Validator::make($request->all(),
		    [
	           
				'Fecha_Ejecucion' => 'required',
				'Id_Responsable' => 'required',
				'Hora_Inicio' => 'required',
				'Hora_Fin' => 'required',
				'Id_Localidad' => 'required',
				'Parque' => 'required',
				'Caracteristica_Lugar' => 'required',
				'Caracteristica_poblacion' => 'required',
				'Institucion_Grupo' => 'required',
				'Numero_Asistentes' => 'required|numeric',
				'Hora_Implementacion' => 'required',
				'Persona_Contacto' => 'required',
				'Roll_Comunidad' => 'required',
				'Telefono' => 'required',
        	]
        );

        if ($validator->fails())
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));

        	if($request->input('Id_Actividad') != '0')
        	$this->modificar($request->all());

        return response()->json(array('status' => 'ok'));
	}

	public function modificar($input)
	{
		$modelo=ActividadGestor::find($input["Id_Actividad"]);
		return $this->modificar_actividad($modelo, $input);
	}
	public function modificar_actividad($model, $input)
	{

		
		//var_dump($model);
		$model['Id_Responsable'] = $input['Id_Responsable'];
		$model['Fecha_Ejecucion'] = $input['Fecha_Ejecucion'];
		$model['Hora_Incial'] = $input['Hora_Inicio'];
		$model['Hora_Final'] = $input['Hora_Fin'];
		$model['Localidad'] = $input['Id_Localidad'];
		$model['Parque'] = $input['Parque'];
		$model['Otro'] = $input['otro_Parque'];
		$model['Caracteristica_Lugar'] = $input['Caracteristica_Lugar'];
		$model['Instit_Grupo_Comun'] = $input['Institucion_Grupo'];
		$model['Caracteristica_Poblacion'] = $input['Caracteristica_poblacion'];
		$model['Numero_Asistente'] = $input['Numero_Asistentes'];
		$model['Hora_Implementacion'] = $input['Hora_Implementacion'];
		$model['Nombre_Contacto'] = $input['Persona_Contacto'];
		$model['Rool_Comunidad'] = $input['Roll_Comunidad'];
		$model->Telefono= $input['Telefono'];

		$model->save();
		
		return $model;
	}
}
