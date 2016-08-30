<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\ActividadGestor;
use App\DatosActividad;
use App\Persona;
use Validator;




class ConfiguracionActividadController extends Controller
{
    //

    public function __construct(){
       if (isset($_SESSION['Usuario']))
           $this->Usuario = $_SESSION['Usuario'];
   }

	public function buscarTematicas(Request $request, $id_eje)
	{
		$eje_model = app()->make('App\Eje');
		$eje = $eje_model->find($id_eje);

		return response()->json($eje->tematica);
	}

	//
	public function buscarActividades(Request $request, $id_tematica)
	{
		$tematica_model_ = app()->make('App\Tematica');
		$actividad = $tematica_model_->find($id_tematica);

		return response()->json($actividad->actividad);
	}

	public function buscarEje(Request $request, $id_eje)
	{
		$eje_model = app()->make('App\Eje');
		$eje = $eje_model->find($id_eje);

		return response()->json($eje);
	}

	public function buscarTematica(Request $request, $id_tematica)
	{
		$eje_model = app()->make('App\Tematica');
		$eje = $eje_model->find($id_tematica);

		return response()->json($eje);
	}

	public function buscarActividad(Request $request, $id_actividad)
	{
		$eje_model = app()->make('App\Actividad');
		$eje = $eje_model->find($id_actividad);

		return response()->json($eje);
	}

	 public function procesarValidacion(Request $request)
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

        	if($request->input('Id_Actividad') == '0')
        	$this->guardar($request->all());
        	else
        	$this->modificar($request->all());

        return response()->json(array('status' => 'ok'));
	}

	public function guardar($input)
	{
		$model_A = new ActividadGestor;
		return $this->crear_actividad($model_A, $input);
	}

	public function modificar($input)
	{
		
		$modelo=ActividadGestor::find($input["Id_Actividad"]);
		//var_dump($modelo);
		return $this->modificar_actividad($modelo, $input);
	}

	public function crear_actividad($model, $input)
	{
		$model['Id_Persona'] = $_SESSION['Usuario'][0];
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
		$model['Telefono'] = $input['Telefono'];
		$model['Fecha_Registro'] = date("Y-m-d G:i:s");
		$model['Estado'] = '1';
		$model['Estado_Ejecucion'] = '1';

		$model->save();
		$id_act_gest=$model->Id_Actividad_Gestor;
		$data0 = json_decode($input['Dato_Actividad']);
		//var_dump($data0);
		foreach($data0 as $obj){
			$model->actividadgestorActividadEjeTematica()->attach($id_act_gest,[
				'eje_id'=>$obj->id_eje,
				'tematica_id'=>$obj->id_tematica,
				'actividad_id'=>$obj->id_act,
				'Otro'=>$obj->otro_actividad]);
		}

		
		$data1 = json_decode($input['Personas_Acompanates']);
		//var_dump($data1);
		foreach($data1 as $obj1){
			$idPerosna=$obj1->acompa;
			$model_P = Persona::with('actividadGestor')->find($idPerosna);
			$model_P->actividadGestor()->attach($id_act_gest);
		}
		


		return $model;
	}


	public function modificar_actividad($model, $input)
	{		
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
		$model['Telefono']= $input['Telefono'];

		$model->save();
		return $model;
	}




// PERSONA LOCALIDAD

	 public function asignarLocalidad(){
        $Tipo = app()->make('App\Tipo');
        $Localidad = app()->make('App\Localidad');
        $datos = [
            'Tipo' => $Tipo->find(50),
            'localidad' => $Localidad->all()
        ];
        return view('perosona_localidad', $datos);
    }

    public function asignarTipoPersona(){
        $Tipo = app()->make('App\Tipo');
        $Localidad = app()->make('App\Localidad');
        $datos = [
            'Tipo' => $Tipo->find(50),
            'localidad' => $Localidad->all()
        ];
        return view('persona_tipoPersona', $datos);
    }


    public function procesarValidacionPersonaLocalidad(Request $request)
	{
		$validator = Validator::make($request->all(),
		    [
				'Id_Persona' => 'required',
				'Id_Localidad' => 'required'
        	]
        );

        if ($validator->fails()){
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
        }else{
        	
        	return $this->creaRelacionLocalidad($request->all());
        }

	}

	public function verPersonaLocalidad()
	{
		$personas = Persona::with('localidades')->has('localidades')->get();
		return $personas;
	}

	public function creaRelacionLocalidad($input)
	{
		$id_persona = $input['Id_Persona'];
		$id_localidad= $input['Id_Localidad'];
		$model_P = Persona::with('localidades')->find($id_persona);
		$model_P->localidades()->attach($id_localidad);
		$personas = Persona::with('localidades')->has('localidades')->get();
		return $personas;
	}

	public function eliminaPersonaLocalidad(Request $request)
	{
		$id_persona = $request->idpersona;
		$id_localidad= $request->idlocalidad;
		$model_P = Persona::with('localidades')->find($id_persona);
		$model_P->localidades()->detach($id_localidad);
		$personas = Persona::with('localidades')->has('localidades')->get();
		return $personas;
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
          $this->modificar_act($request->all());

        return response()->json(array('status' => 'ok'));
  }

  public function modificar_act($input)
  {
    $modelo=ActividadGestor::find($input["Id_Actividad"]);
    return $this->modificar_actividad_2($modelo, $input);
  }
  public function modificar_actividad_2($model, $input)
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
