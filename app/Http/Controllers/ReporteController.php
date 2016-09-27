<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\TipoEntidad;
use App\TipoPersona;
use App\Condicion;
use App\Situacion;
use App\Localidad;
use App\Ejecucion;
use App\ActividadGestor;

class ReporteController extends Controller
{
    
    public function reporte()
    {
        $TipoEntidad = new TipoEntidad;
        $TipoPersona = new TipoPersona;
        $Condicion = new Condicion;
        $Situacion = new Situacion;
        $Localidad = new Localidad;

    	$datos = [
            'TipoEntidad' => $TipoEntidad->all(),
            'TipoPersona' => $TipoPersona->all(),
            'Condicion' => $Condicion->all(),
            'Situacion' => $Situacion->all(),
            'Localidad' => $Localidad->all()
		];
	    return view('reporte', $datos);
    }

    public function reportePoblacional(Request $request)
    {
    	$datos =$request->all();

		
		$Ejecucion = Ejecucion::with('tipoEntidad','tipoPersona','condicion','situacion','localidad');

		if($datos['Localidad']!="")
		$Ejecucion=$Ejecucion->where('Localidad',$datos['Localidad']);

		if($datos['Tipo_entidad']!="")
		$Ejecucion=$Ejecucion->where('TipoEntidad',$datos['Tipo_entidad']);

		if($datos['Tipo_eje']!="")
	    $Ejecucion=$Ejecucion->where('Tipo',$datos['Tipo_eje']);

		if($datos['Condicion']!="")
	    $Ejecucion=$Ejecucion->where('Condicion',$datos['Condicion']);
	    
	    if($datos['Situacion']!="")
	    $Ejecucion=$Ejecucion->where('Situacion',$datos['Situacion']);

	    $Ejecucion=$Ejecucion->get();



	    $tabla="<table id='Tabla_Reporte'>
			        <thead>
			            <tr>
							<th>Género / Edad</b></th>
							<th>5 a 6</th>
							<th>6 a 12</th> 
							<th>13 a 17</th>
							<th>18 a 26</th>
							<th>27 a 59</th>
							<th>60</th>
							<th>TOTAL GÉNERO</th>
						</tr>
					</thead>
						<tbody>
						<tr>";
												$F5a6 =0;
												$F6a12=0;
												$F13a17=0;
												$F18a26=0;
												$F27a59=0;
												$F60=0;
											    foreach ($Ejecucion as $item) {
												    $consulta=ActividadGestor::where('Id_Actividad_Gestor',$item['Id_Actividad_Gestor'])->where('Estado_Ejecucion',3)->where('Estado',2)->whereBetween('Fecha_Ejecucion',array($datos['Fecha_Inicio'], $datos['Fecha_Fin']))->get();
												    
												    if(count($consulta)>0){
													    $F5a6 = $F5a6 + $item['F_0a5'];
														$F6a12 = $F6a12 + $item['F_6a12'];
														$F13a17 = $F13a17 + $item['F_13a17'];
														$F18a26 = $F18a26 + $item['F_18a26'];
														$F27a59 = $F27a59 + $item['F_27a59'];
														$F60 = $F60 + $item['F_60'];
													}
												}
												$TOTALFEMENINO = $F5a6 + $F6a12 +$F13a17 +$F18a26+ $F27a59+ $F60;

												$TOTALFEMENINO = $F5a6 + $F6a12 +$F13a17 +$F18a26+ $F27a59+ $F60;
												$tabla=$tabla."<td>Femenino</td>
												<td>".$F5a6." </td>
												<td>".$F6a12." </td>
												<td>".$F13a17." </td>
												<td>".$F18a26." </td>
												<td>".$F27a59." </td>
												<td>".$F60." </td>
												<td><b>".$TOTALFEMENINO." </td>
										        </tr>";
										
										$tabla=$tabla."<tr>";
											
											
												$M5a6 =0;
												$M6a12=0;
												$M13a17=0;
												$M18a26=0;
												$M27a59=0;
												$M60=0;
											    foreach ($Ejecucion as $item) {
												    $consulta=ActividadGestor::where('Id_Actividad_Gestor',$item['Id_Actividad_Gestor'])->where('Estado_Ejecucion',3)->where('Estado',2)->whereBetween('Fecha_Ejecucion',array($datos['Fecha_Inicio'], $datos['Fecha_Fin']))->get();
												    if(count($consulta)>0){
													    $M5a6 = $M5a6 + $item['M_0a5'];
														$M6a12 = $M6a12 + $item['M_6a12'];
														$M13a17 = $M13a17 + $item['M_13a17'];
														$M18a26 = $M18a26 + $item['M_18a26'];
														$M27a59 = $M27a59 + $item['M_27a59'];
														$M60 = $M60 + $item['M_60'];
													}
												}

												$TOTALMASCULINO = $M5a6 + $M6a12 +$M13a17 +$M18a26+ $M27a59+ $M60;
												$tabla=$tabla."<td><font color='#0B0B61'>Masculino</td>
												<td>".$M5a6." </td>
												<td>".$M6a12." </td>
												<td>".$M13a17." </td>
												<td>".$M18a26." </td>
												<td>".$M27a59." </td>
												<td>".$M60." </td>
												<td><b>".$TOTALMASCULINO." </td>
										</tr>";
										
										$TOTAL1=$F5a6 +$M5a6;
										$TOTAL2=$F6a12 +$M6a12;
										$TOTAL3=$F13a17 +$M13a17;
										$TOTAL4=$F18a26 +$M18a26;
										$TOTAL5=$F27a59 +$M27a59;
										$TOTAL6=$F60 +$M60;
										$TOTAL = $TOTALMASCULINO + $TOTALFEMENINO ;
										
								$tabla=$tabla."<tr>
								<td><font color='#0B0B61'><b>TOTAL EDAD</td>
								<td><b>".$TOTAL1."</td>
								<td><b>".$TOTAL2."</td> 
								<td><b>".$TOTAL3."</td>
								<td><b>".$TOTAL4."</td>
								<td><b>".$TOTAL5."</td>
								<td><b>".$TOTAL6."</td>
								<td>  <font color='#018406'><b> TOTAL ".$TOTAL."</td>
								</tr>
								</tbody>
								</table>";

        return  $tabla;
    }
}
