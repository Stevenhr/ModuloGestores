@extends('master')                              


@section('script')
	@parent

    <script src="{{ asset('public/Js/Actividad/actividad_gestores.js') }}"></script>	
@stop

@section('content') 
        
              
<div class="content" id="mis_actividad_gestores" class="row" data-url="gestores">
            <br>
              <h3 id="navbar">MIS ACTIVIDADES</h3>
            <br><br>
           


		<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">BUSCADOR: buscador de actvidades por fecha o id de la actividad.</h3>
			  </div>
			  <div class="panel-body">
										<fieldset>
												<form action="" id="form_actividad_gestor">
										        		<div class="col-xs-12 col-md-4">
										        			<div class="form-group">
										        			    <label class="control-label" for="Id_TipoDocumento">Id actividad</label>
										        				<input type="text" name="Id_Actividad" class="form-control">
										        				<input type="hidden" name="id_persona" class="form-control" value="1">
										        			</div>
										        		</div>

										        		<div class="col-xs-12 col-md-4">
										        			<div class="form-group">
										        				<label class="control-label" for="Id_TipoDocumento">Fecha Inicio</label>
										        				<input type="text" data-role="datepicker" name="Fecha_Inicio" class="form-control">
										        			</div>
										        		</div>

										        		<div class="col-xs-12 col-md-4">
										        			<div class="form-group">
										        				<label class="control-label" for="Id_TipoDocumento">Fecha Fin</label>
										        				<input type="text" data-role="datepicker" name="Fecha_Fin" class="form-control">
										        			</div>
										        		</div>

										        		<div class="col-xs-12 col-md-12">
										        			<div class="form-group text-center">
										        				<button type="submit" class="btn btn-primary">Buscar</button>
										        			</div>
										        		</div>
										        		<div class="col-xs-12 col-md-12">
										        			<div class="form-group text-center">
										        				<div id="espera"></div>
										        			</div>
										        		</div>
										        </form>
										</fieldset>
							      	
			  </div>
			  
		</div>    




			<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">ACTIVIDAD: Registro del estado de las actividades.</h3>
			  </div>
			  <div class="panel-body">
			    				
							      		<table id="Tabla2" class="display" width="100%" cellspacing="0">
								        <thead>
								            <tr>
								                <th class="text-center">N°</th>
								                <th class="text-center">Id</th>
								                <th>Responsable</th>
								                <th>Fecha Ejecución</th>
								                <th>Localidad</th>
								                <th>Hora</th>
								                <th>Parque</th>
								                <th>Programación</th>
								                <th>Ejecución</th>
								            </tr>
								        </thead>
								        <tfoot>
								            <tr>
								                <th class="text-center">N°</th>
								                <th class="text-center">Id</th>
								                <th>Responsable</th>
								                <th>Fecha Ejecución</th>
								                <th>Localidad</th>
								                <th>Hora</th>
								                <th>Parque</th>
								                <th>Programación</th>
								                <th>Ejecución</th>
								            </tr>
								        </tfoot>
								        <tbody id="registros_actividades_responsable">
								            
								           
								   
								        </tbody>
								    </table>
			  </div>


@stop
