@extends('master')                              


@section('script')
	@parent

    <script src="{{ asset('public/Js/Actividad/mi_actividad.js') }}"></script>	
@stop

@section('content') 
        
              
<div class="content" id="main_actividad" class="row" data-url="actividad">
            <br>
              <h3 id="navbar">MI ACTIVIDAD</h3>
            <br><br>
           
<form action="" id="form_actividad">

			<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">ACTIVIDAD: Registro del estado de las actividades.</h3>
			  </div>
			  <div class="panel-body">
			    				
							      		<table id="example" class="display" width="100%" cellspacing="0">
								        <thead>
								            <tr>
								                <th>N°</th>
								                <th>Id</th>
								                <th>Responsable</th>
								                <th>Fecha Ejecución</th>
								                <th>Localidad</th>
								                <th>Hora</th>
								                <th>Parque</th>
								                <th>Ver</th>
								            </tr>
								        </thead>
								        <tfoot>
								            <tr>
								                <th>N°</th>
								                <th>Id</th>
								                <th>Responsable</th>
								                <th>Fecha Ejecución</th>
								                <th>Localidad</th>
								                <th>Hora</th>
								                <th>Parque</th>
								                <th>Ver</th>
								            </tr>
								        </tfoot>
								        <tbody>
								            
								           @foreach($PersonaActividad->actividadGestor as $tipoparques)
								               <tr>
								        		    <td></td>
								        		    <td class="text-center"><h4>{{ $tipoparques['Id_Actividad_Gestor'] }}</h4></td>
								        		    <td>{{ $tipoparques->persona['Primer_Apellido'].' '.$tipoparques->persona['Segundo_Apellido'].' '.$tipoparques->persona['Primer_Nombre'].' '.$tipoparques->persona['Segundo_Nombre'] }}</td>
									                <td>{{ $tipoparques['Fecha_Ejecución'] }}</td>
									                <td>{{ $tipoparques->localidad['Nombre_Localidad'] }}</td>
									                <td>{{ $tipoparques['Hora_Incial'].' - '.$tipoparques['Hora_Final'] }}</td>
									                <td>{{ $tipoparques->parque['Nombre'] }}</td>
									                <td class="text-center"><a href="{{ $tipoparques['Id_Actividad_Gestor'] }}" class="btn btn-primary btn-xs">Ver</a></td>
								                </tr>
							        		@endforeach
								   
								        </tbody>
								    </table>
			  </div>

</form>       
 		   
</div>           
       
@stop
