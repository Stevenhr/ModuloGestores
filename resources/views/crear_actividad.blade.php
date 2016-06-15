@extends('master')                              


@section('script')
	@parent

    <script src="{{ asset('public/Js/Actividad/actividad.js') }}"></script>	
@stop

@section('content') 
        
              
<div class="content" id="main_actividad" class="row" data-url="{{ url(config('usuarios.prefijo_ruta_modulo')) }}">
            <br>
              <h3 id="navbar">PROGRAMACIÓN DE ACTIVIDADES</h3>
            <br><br>
           

			<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">PASO 1: Datos basicos de la actividad</h3>
			  </div>
			  <div class="panel-body">
			    				<form action="" id="form_actividad">
							      		<fieldset>
							        		<div class="col-xs-12 col-md-12">
							        			<div class="form-group">
							        				<label class="control-label" for="Id_Eje">* Eje</label>
							        				<select name="Id_Eje" id="" class="form-control">
							        					<option value="">Seleccionar</option>
							        					@foreach($eje as $eje)
							        						<option value="{{ $eje['Id_Eje'] }}">{{ $eje['Nombre_Eje'] }}</option>
							        					@endforeach
							        				</select>
							        			</div>
							        		</div>
							        		<div class="col-xs-12 col-md-12">
							        			<div class="form-group">
							        				<label class="control-label" for="Id_Tematica">* Tematica </label>
							        				<select name="Id_Tematica" id="" class="form-control">
							        					<option value="">Seleccionar</option>¿
							        				</select>
							        			</div>
							        		</div>
							        		<div class="col-xs-12 col-md-12">
							        			<div class="form-group">
							        				<label class="control-label" for="Id_Actividad">* Actividad </label>
							        				<select name="Id_Actividad" id="" class="form-control">
							        					<option value="">Seleccionar</option>
							        				</select>
							        			</div>
							        		</div>
							        		<div class="col-xs-12 col-md-12">
							        			<div class="form-group">
							        				<a href="#" id="agregar_actividad" class="btn btn-info btn-sm">Agregar</a>
							        				<a href="#" id="ver_datos_actividad"class="btn btn-default btn-sm">Ver registros</a>
							        			</div>
							        		</div>

							        		 <div class="col-xs-12 col-md-12"  >
							        			<div class="form-group"  id="mensaje_actividad" style="display: none;">
							        			<div id="alert_actividad"></div>
							        			</div>
							        			
							        			<div class="modal fade bs-example-modal-lg" id="ver_registros" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
												  <div class="modal-dialog modal-lg">
												    <div class="modal-content">
												        <div class="modal-header">
													        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													        <h4 class="modal-title" id="myModalLabel">Datos de la actividad</h4>
													     </div>
													     <div class="modal-body">
												      			<table class="table table-bordered"> 
																<thead>
																<tr>
																<th>#</th>
																<th>Eje</th>
																<th>Tematica</th>
																<th>Actividad</th>
																<th>Eliminar</th>
																</tr>
																</thead>
																<tbody id="registros"> 
																</tbody> 
																</table>
														  </div>
													      <div class="modal-footer">
													        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													      </div>
												    </div>
												  </div>
												</div>
							        		
														
							        		
							        		</div>
							       		</fieldset>
							    </form>
			  </div>
			</div>

			<br>

			<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">PASO 2: Datos de asignación y configuración horaria</h3>
			  </div>
			  <div class="panel-body">
			    				<form action="" id="form_actividad">
							      		<fieldset>
							        		<div class="col-xs-12 col-md-6">
							        			<div class="form-group">
							        				<label class="control-label" for="Id_TipoDocumento">* Fecha ejecución</label>
							        				<input type="text" data-role="datepicker" name="Fecha_Ejecución" class="form-control">
							        			</div>
							        		</div>

							        		<div class="col-xs-12 col-md-6">
							        			<div class="form-group">
							        				<label class="control-label" for="Id_TipoDocumento">* Responsable </label>
							        				<select name="Id_TipoDocumento" id="" class="form-control">
							        					<option value="">Seleccionar</option>
							        					
							        				</select>
							        			</div>
							        		</div>
							        		<div class="col-xs-12 col-md-6">
							        			<div class="form-group">
							        				<label class="control-label" for="Cedula">* Hora Inicio </label>
							        				<div class='input-group date' id='datetimepicker1'>
														<input type='text' name="Hora_Inicio" class="form-control" value=""  />
														<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
														</span>
													</div>
							        			</div>
							        		</div>
							        		<div class="col-xs-12 col-md-6">
							        			<div class="form-group">
							        				<label class="control-label" for="Cedula">* Hora Final </label>
							        				<div class='input-group date' id='datetimepicker2'>
														<input type='text' name="Hora_Inicio" class="form-control" value=""  />
														<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
														</span>
													</div>
							        			</div>
							        		</div>
							        		<div class="col-xs-12 col-md-12">
							        		    <div class="form-group">
							        		    	<p class="text-muted">Selecione los acompañantes ha esta actividad:</p>
							        				<a href="#" id="asignar_acompañante" class="btn btn-info btn-sm">Acompañantes</a>
							        			</div>
							        			<div class="modal fade bs-example-modal-lg" id="ver_acompañante" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
												  <div class="modal-dialog modal-lg">
												    <div class="modal-content">
												        <div class="modal-header">
													        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													        <h4 class="modal-title" id="myModalLabel">Acompañantes de la actividad</h4>
													     </div>
													     <div class="modal-body">
												      			<table class="table table-bordered"> 
																<thead>
																<tr>
																<th>Usuario</th>
																<th>Selecionar</th>
																<th>Disponibilidad</th>
																</tr>
																</thead>
																<tbody id="div_acompañante"> 
																</tbody> 
																</table>
														  </div>
													      <div class="modal-footer">
													        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													      </div>
												    </div>
												  </div>
												</div>
							        		</div>
							       		</fieldset>
							    </form>
			  </div>
			</div>

			<br>

			<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">PASO 3: Datos del escenario y la comunidad</h3>
			  </div>
			  <div class="panel-body">
			    				<form action="" id="form_actividad">
							      		<fieldset>
							        		<div class="col-xs-12 col-md-6">
							        			<div class="form-group">
							        				<label class="control-label" for="Id_TipoDocumento">* Localidad</label>
							        				<select name="Id_Localidad" id="" class="form-control">
							        					<option value="">Seleccionar</option>
							        					@foreach($localidad as $localidad)
							        						<option value="{{ $localidad['Id_Localidad'] }}">{{ $localidad['Nombre_Localidad'] }}</option>
							        					@endforeach
							        				</select>
							        			</div>
							        		</div>
							        		<div class="col-xs-12 col-md-6">
							        			<div class="form-group">
							        				<label class="control-label" for="Cedula">* Parque </label>
							        				<select name="Id_TipoDocumento" id="" class="form-control">
							        					<option value="">Seleccionar</option>
							        					
							        				</select>
							        			</div>
							        		</div>

							        		<div class="col-xs-12 col-md-6">
							        			<div class="form-group">
							        				<label class="control-label" for="Id_TipoDocumento">* Caracteristica Lugar </label>
							        				<textarea class="form-control" rows="3" id="ta_Caracteristica_Lugar"></textarea>
							        			</div>
							        		</div>
							        		<div class="col-xs-12 col-md-6">
							        			<div class="form-group">
							        			    <label class="control-label" for="Id_TipoDocumento">* Institución, grupo, comunidad</label>
							        				<input type="text" name="Segundo_Apellido" class="form-control">
							        			</div>
							        		</div>

							        		<div class="col-xs-12 col-md-6">
							        			<div class="form-group">
							        				<label class="control-label" for="Id_TipoDocumento">* Caracteristica de la población </label>
							        				<textarea class="form-control" rows="3" id="ta_Caracteristica_Lugar"></textarea>
							        			</div>
							        		</div>
							        		<div class="col-xs-12 col-md-6">
							        			<div class="form-group">
							        			    <label class="control-label" for="Id_TipoDocumento">* Numero de asistentes</label>
							        				<input type="text" name="Segundo_Apellido" class="form-control">
							        			</div>
							        		</div>
							       		</fieldset>
							    </form>
			  </div>
			</div>

			<br>

			<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">PASO 4: Datos persona contacto</h3>
			  </div>
			  <div class="panel-body">
			    				<form action="" id="form_actividad">
							      		<fieldset>
							        		<div class="col-xs-12 col-md-6">
							        			<div class="form-group">
							        				<label class="control-label" for="Id_TipoDocumento">* Hora implementación</label>
							        				<input type="text" name="Hora_Implementacion" class="form-control">
							        			</div>
							        		</div>
							        		<div class="col-xs-12 col-md-6">
							        			<div class="form-group">
							        				<label class="control-label" for="Cedula">* Nombre persona contacto </label>
							        				<input type="text" name="Segundo_Apellido" class="form-control">
							        			</div>
							        		</div>

							        		<div class="col-xs-12 col-md-6">
							        			<div class="form-group">
							        				<label class="control-label" for="Id_TipoDocumento">* Roll de la comunidad </label>
							        				<input type="text" name="Segundo_Apellido" class="form-control">
							        			</div>
							        		</div>
							        		<div class="col-xs-12 col-md-6">
							        			<div class="form-group">
							        				<label class="control-label" for="Id_TipoDocumento">* Telefono</label>
							        				<input type="text" name="Segundo_Apellido" class="form-control">
							        			</div>
							        		</div>
							       		</fieldset>
							    </form>
			  </div>
			</div>
			<br>
			<div class="form-group">
		      <div class="col-lg-12">
		        <button type="reset" class="btn btn-default">Cancel</button>
		        <button type="submit" class="btn btn-info">Crear</button>
		      </div>
		    </div>
		    <br><br> 
</div>
       
            
       
@stop