@extends('master')                              

@section('content') 
        
              
<div class="content">
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
							        				<label class="control-label" for="Id_TipoDocumento">* Eje</label>
							        				<select name="Id_TipoDocumento" id="" class="form-control">
							        					<option value="">Seleccionar</option>
							        					@foreach($eje as $eje)
							        						<option value="{{ $eje['Id_Eje'] }}">{{ $eje['Nombre_Eje'] }}</option>
							        					@endforeach
							        				</select>
							        			</div>
							        		</div>
							        		<div class="col-xs-12 col-md-12">
							        			<div class="form-group">
							        				<label class="control-label" for="Cedula">* Tematica </label>
							        				<select name="Id_TipoDocumento" id="" class="form-control">
							        					<option value="">Seleccionar</option>
							        					@foreach($tematica as $tematica)
							        						<option value="{{ $tematica['Id_Tematica'] }}">{{ $tematica['Nombre_Tematica'] }}</option>
							        					@endforeach
							        				</select>
							        			</div>
							        		</div>
							        		<div class="col-xs-12 col-md-12">
							        			<div class="form-group">
							        				<label class="control-label" for="Id_TipoDocumento">* Actividad </label>
							        				<select name="Id_TipoDocumento" id="" class="form-control">
							        					<option value="">Seleccionar</option>
							        					@foreach($actividad as $actividad)
							        						<option value="{{ $actividad['Id_Actividad'] }}">{{ $actividad['Nombre_Actividad'] }}</option>
							        					@endforeach
							        				</select>
							        			</div>
							        		</div>
							        		<div class="col-xs-12 col-md-12">
							        			<div class="form-group">
							        				<a href="#" class="btn btn-info btn-sm">Agregar</a>
							        				<a href="#" class="btn btn-default btn-sm">Ver registros</a>
							        			</div>
							        		</div>
							       		</fieldset>
							    </form>
			  </div>
			</div>

			<br>

			<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">PASO 2: Datos de asignación y configuración horaria:</h3>
			  </div>
			  <div class="panel-body">
			    				<form action="" id="form_actividad">
							      		<fieldset>
							        		<div class="col-xs-12 col-md-6">
							        			<div class="form-group">
							        				<label class="control-label" for="Id_TipoDocumento">* Fecha ejecución</label>
							        				<input type="text" name="Fecha_Ejecución" class="form-control">
							        			</div>
							        		</div>
							        		<div class="col-xs-12 col-md-6">
							        			<div class="form-group">
							        				<label class="control-label" for="Cedula">* Hora de Actividad </label>
							        				<input type="text" name="Segundo_Apellido" class="form-control">
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
							        		<div class="col-xs-12 col-md-12">
							        			<div class="form-group">
							        			    <p class="text-muted">Selecione los acompañantes ha esta actividad:</p>
							        				<table class="table table-bordered">
													  <thead>
													    <tr>
													      <th>#</th>
													      <th>First Name</th>
													      <th>Last Name</th>
													      <th>Username</th>
													    </tr>
													  </thead>
													  <tbody>
													    <tr>
													      <th scope="row">1</th>
													      <td>Mark</td>
													      <td>Otto</td>
													      <td>@mdo</td>
													    </tr>
													    <tr>
													      <th scope="row">2</th>
													      <td>Mark</td>
													      <td>Otto</td>
													      <td>@TwBootstrap</td>
													    </tr>
													    <tr>
													      <th scope="row">3</th>
													      <td>Jacob</td>
													      <td>Thornton</td>
													      <td>@fat</td>
													    </tr>
													    <tr>
													      <th scope="row">4</th>
													      <td colspan="2">Larry the Bird</td>
													      <td>@twitter</td>
													    </tr>
													  </tbody>
													</table>
							        			</div>
							        		</div>
							       		</fieldset>
							    </form>
			  </div>
			</div>

			<br>

			<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">PASO 3: Datos del escenario y la comunidad:</h3>
			  </div>
			  <div class="panel-body">
			    				<form action="" id="form_actividad">
							      		<fieldset>
							        		<div class="col-xs-12 col-md-6">
							        			<div class="form-group">
							        				<label class="control-label" for="Id_TipoDocumento">* Localidad</label>
							        				<input type="text" name="Segundo_Apellido" class="form-control">
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
			    <h3 class="panel-title">PASO 4: Datos persona contacto:</h3>
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
