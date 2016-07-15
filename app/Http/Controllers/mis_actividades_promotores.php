<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use App\Persona;
use App\ActividadGestor;
use App\Calificacion_servicio;

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
     //   var_dump($request->all());


        $validator = Validator::make($request->all(),
            [
                'puntualidad' => 'required',
                'divulgacion' => 'required',
                'escenarioMontaje' => 'required',
                'cumplimiento' => 'required',
                'variedadCreatividad' => 'required',
                'seguridad' => 'required',
                'nombreRepresentante' => 'required',
                'telefonoRepresentante' => 'required',
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
            
            $id_act = $request->input('Id_Actividad_E');
            
            $file1=$request->file('imagen1');
            $Nom_imagen1 = date('Y-m-d-H:i:s')."-imagen1-".$id_act;
            $file1->move(public_path().'/Img/EvidenciaFotografica/', $Nom_imagen1);

            $file2=$request->file('imagen2');
            $Nom_imagen2 = date('Y-m-d-H:i:s')."-imagen2-".$id_act;
            $file2->move(public_path().'/Img/EvidenciaFotografica/', $Nom_imagen2);

            if ($request->hasFile('imagen3')) {
                $file3=$request->file('imagen3');
                $Nom_imagen3 = date('Y-m-d-H:i:s')."-imagen3-".$id_act;
                $file3->move(public_path().'/Img/EvidenciaFotografica/', $Nom_imagen3);
            }else{
                $Nom_imagen3="";
            }

            if ($request->hasFile('imagen4')) {
                $file4=$request->file('imagen4');
                $Nom_imagen4 = date('Y-m-d-H:i:s')."-imagen4-".$id_act;
                $file4->move(public_path().'/Img/EvidenciaFotografica/', $Nom_imagen4);
            }else{
                $Nom_imagen4="";
            }
            $file_listaAsistencia=$request->file('listaAsistencia');
            $Nom_listaAsistencia = date('Y-m-d-H:i:s')."-listaAsistencia-".$id_act;
            $file_listaAsistencia->move(public_path().'/Img/EvidenciaArchivo/', $Nom_listaAsistencia);

            $file_acta=$request->file('acta');
            $Nom_Acta = date('Y-m-d-H:i:s')."-"."-acta-".$id_act;
            $file_acta->move(public_path().'/Img/EvidenciaArchivo/', $Nom_Acta);


            $nomarchivos= array(
                'imagen1'=> $Nom_imagen1,
                'imagen2'=> $Nom_imagen2,
                'imagen3'=> $Nom_imagen3,
                'imagen4'=> $Nom_imagen4,
                'listaAsistencia'=> $Nom_listaAsistencia ,
                'acta'=> $Nom_Acta);



            $this->guardar($request->all(),$nomarchivos);
        }


        return response()->json(array('status' => 'ok'));
    }


    public function guardar($input,$Nom_imagen1)
    {
        $model_A = new Calificacion_servicio;
        return $this->crear_ejecucion($model_A, $input,$Nom_imagen1);
    }

    public function crear_ejecucion($model, $input,$Nom_imagen1)
    {
        $model['Id_Actividad_Gestor'] = $input['Id_Actividad_E'];
        /*$model['Comunidad'] = $input['Id_Responsable'];
        $model['Localidad'] = $input['Fecha_Ejecucion'];
        $model['TipoEntidad'] = $input['Hora_Inicio'];
        $model['Tipo'] = $input['Hora_Fin'];
        $model['Condicion'] = $input['Id_Localidad'];
        $model['Situacion'] = $input['Parque'];
        $model['F_0a5'] = $input['Caracteristica_Lugar'];
        $model['M_0a5'] = $input['Institucion_Grupo'];
        $model['F_6a12'] = $input['Caracteristica_poblacion'];
        $model['M_6a12'] = $input['Numero_Asistentes'];
        $model['F_13a17'] = $input['Hora_Implementacion'];
        $model['M_13a17'] = $input['Persona_Contacto'];
        $model['F_18a26'] = $input['Roll_Comunidad'];
        $model['M_18a26'] = $input['Telefono'];
        $model['F_27a59'] = date("Y-m-d G:i:s");
        $model['M_27a59'] = '1';
        $model['F_60'] = '1';
        $model['M_60'] = '1';*/

       //obtenemos el campo file definido en el formulario
      

        
       

        $model['Id_Puntualidad'] = $input['puntualidad'];
        $model['Id_Divulgacion'] = $input['divulgacion'];
        $model['Id_Montaje'] = $input['escenarioMontaje'];
        $model['Id_Cumplimiento'] = $input['cumplimiento'];
        $model['Id_Variedad'] = $input['variedadCreatividad'];
        $model['Id_Seguridad'] = $input['seguridad'];
        $model['Nombre_Representante'] = $input['nombreRepresentante'];
        $model['Telefono'] = $input['telefonoRepresentante'];
        $model['Url_Imagen1'] = $Nom_imagen1['imagen1'];
        $model['Url_Imagen2'] = $Nom_imagen1['imagen2'];
        $model['Url_Imagen3'] = $Nom_imagen1['imagen3'];
        $model['Url_Imagen4'] = $Nom_imagen1['imagen4'];
        $model['Url_Asistencia'] = $Nom_imagen1['listaAsistencia'];
        $model['Url_Acta'] = $Nom_imagen1['acta'];
        $model->save();
        

        /*$data0 = json_decode($input['Dato_Actividad']);
        foreach($data0 as $obj){
            $model->actividadgestorActividadEjeTematica()->attach($model->Id_Actividad_Gestor,['eje_id'=>$obj->id_eje,
                'tematica_id'=>$obj->id_tematica,
                'actividad_id'=>$obj->id_act]);
        }

        $model_P = new Persona;
        $data1 = json_decode($input['Personas_Acompanates']);
        foreach($data1 as $obj){
            $model_P->actividadGestor()->attach($model->Id_Actividad_Gestor,['persona_id'=>$obj->acompa]);
        }*/


        return $model;
    }


}
