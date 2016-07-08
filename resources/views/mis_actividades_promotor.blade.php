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
										        				<input type="text" name="Id_Actividad_Promo" class="form-control">
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
			</div>



  
 <!-- Modal formulario  actividad -->
<div class="modal fade bs-example-modal-lg" id="modal_form_act_eje" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg" role="document">
	   <div class="modal-content">

			<form action="" id="form_actividad_m" name="form_actividad_m">

						<div class="panel panel-primary">
						  <div class="panel-heading">
						    <h3 class="panel-title">Datos de asignación y configuración horaria</h3>
						  </div>
						  <div class="panel-body">
										      		<fieldset>
										        		<div class="col-xs-12 col-md-6">
										        			<div class="form-group">
										        				<label class="control-label" for="Id_TipoDocumento">* Fecha ejecución</label>
										        				<input type="text" name="Fecha_Ejecucion" class="form-control" readonly="readonly">
										        			</div>
										        		</div>

										        		<div class="col-xs-12 col-md-6">
										        			<div class="form-group">
										        				<label class="control-label" for="Id_TipoDocumento">* Responsable </label>
										        				<input type="text"  name="Id_Responsable" class="form-control" readonly="readonly">
										        			</div>
										        		</div>
										        		<div class="col-xs-12 col-md-6">
										        			<div class="form-group">
										        				<label class="control-label" for="Cedula">* Hora Inicio </label>
										        				
																	<input type='text' name="Hora_Inicio" class="form-control" readonly="readonly" />
																
										        			</div>
										        		</div>
										        		<div class="col-xs-12 col-md-6">
										        			<div class="form-group">
										        				<label class="control-label" for="Cedula">* Hora Final </label>
																<input type='text' name="Hora_Fin" class="form-control" readonly="readonly" />
										        			</div>
										        		</div>
										        
										       		</fieldset>
						  </div>
						</div>

						<br>

						<div class="panel panel-primary">
						  <div class="panel-heading">
						    <h3 class="panel-title">PASO 3: Datos del escenario y la comunidad</h3>
						  </div>
						  <div class="panel-body">
										      		<fieldset>
										        		<div class="col-xs-12 col-md-6">
										        			<div class="form-group">
										        				<label class="control-label" for="Id_TipoDocumento">* Localidad</label>
										        				<input type="text" name="Id_Localidad" class="form-control" readonly="readonly">
										        			</div>
										        		</div>
										        		<div class="col-xs-12 col-md-6">
										        			<div class="form-group">
										        				<label class="control-label" for="Cedula">* Parque </label>
										        				<input type="text" name="Parque" class="form-control" readonly="readonly">
										        			</div>
										        		</div>

										        		<div class="col-xs-12 col-md-6">
										        			<div class="form-group">
										        				<label class="control-label" for="Id_TipoDocumento">* Caracteristica Lugar </label>
										        				<textarea class="form-control" rows="3" name="Caracteristica_Lugar" readonly="readonly"></textarea>
										        			</div>
										        		</div>
										        		

										        		<div class="col-xs-12 col-md-6">
										        			<div class="form-group">
										        				<label class="control-label" for="Id_TipoDocumento">* Caracteristica de la población </label>
										        				<textarea class="form-control" rows="3" name="Caracteristica_poblacion" readonly="readonly"></textarea>
										        			</div>
										        		</div>

										        		<div class="col-xs-12 col-md-6">
										        			<div class="form-group">
										        			    <label class="control-label" for="Id_TipoDocumento">* Institución, grupo, comunidad</label>
										        				<input type="text" name="Institucion_Grupo" class="form-control" readonly="readonly">
										        			</div>
										        		</div>

										        		<div class="col-xs-12 col-md-6">
										        			<div class="form-group">
										        			    <label class="control-label" for="Id_TipoDocumento">* Numero de asistentes</label>
										        				<input type="text" name="Numero_Asistentes" class="form-control" readonly="readonly">
										        			</div>
										        		</div>
										       		</fieldset>
						  </div>
						</div>

						<br>

						<div class="panel panel-primary">
						  <div class="panel-heading">
						    <h3 class="panel-title">PASO 4: Datos persona contacto</h3>
						  </div>
						  <div class="panel-body">
						    				
										      		<fieldset>
										        		<div class="col-xs-12 col-md-6">
										        			<div class="form-group">
										        				<label class="control-label" for="Id_TipoDocumento">* Hora implementación</label>
																	<input type='text' name="Hora_Implementacion" class="form-control" readonly="readonly"  />
										        			</div>
										        		</div>
										        		<div class="col-xs-12 col-md-6">
										        			<div class="form-group">
										        				<label class="control-label" for="Cedula">* Nombre persona contacto </label>
										        				<input type="text" name="Persona_Contacto" class="form-control" readonly="readonly">
										        			</div>
										        		</div>

										        		<div class="col-xs-12 col-md-6">
										        			<div class="form-group">
										        				<label class="control-label" for="Id_TipoDocumento">* Roll de la comunidad </label>
										        				<input type="text" name="Roll_Comunidad" class="form-control" readonly="readonly">
										        			</div>
										        		</div>
										        		<div class="col-xs-12 col-md-6">
										        			<div class="form-group">
										        				<label class="control-label" for="Id_TipoDocumento">* Telefono</label>
										        				<input type="text" name="Telefono" class="form-control" readonly="readonly">
										        			</div>
										        		</div>
										       		</fieldset>
										    
						  </div>
						</div>
						<br>
						
						<div class="form-group">
							<div id="alerta_actividad_error" class="col-xs-12" style="display:none;">
								<div class="alert alert-danger alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<div id="mensaje_alerta_final"></div>
								</div>
							</div>
						</div>
						<div class="form-group">
					      <div class="col-lg-12">
					      <input type="hidden" name="Id_Actividad" class="form-control">
					      	<input type="hidden" name="Dato_Actividad" class="form-control">
					      	<input type="hidden" name="Personas_Acompanates" class="form-control">
					         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					      </div>
					    </div>
					    <br><br> 
					   
			</div>
			</form> 
	  </div>
  	</div>
</div> 















<!-- Modal formulario  actividad -->
<div class="modal fade bs-example-modal-lg" id="modal_ejecucion" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg" role="document">
	   <div class="modal-content">

			<form action="" id="form_ejecucion_actividad" name="form_actividad_m">
						<input type="hidden" name="Id_Actividad_ejecucion" class="form-control">
						<div class="panel panel-primary">
						  <div class="panel-heading text-center">
						    <h3 class="panel-title">EJECUCIÓN DE ACTIVIDADES CAMPAÑA MASIVA</h3>
						  </div>
						  <div class="panel-body">
										      		<fieldset>
										      			<div class="col-xs-12 col-md-12">
										        			<div class="form-group">
										        				<h3>ACTIVIDAD N° <label class="control-label" for="Id_TipoDocumento" id="titulo"></label></h3>
										        			</div>
										        		</div>
										        		<div class="col-xs-12 col-md-6">
										        			<div class="form-group">
										        				<label class="control-label" for="Id_TipoDocumento">* Institucion, grupo, comunidad</label>
										        				<input type="text" name="Inst_grupo_comu" class="form-control">
										        			</div>
										        		</div>

										        		<div class="col-xs-12 col-md-6">
										        			<div class="form-group">
										        				<label class="control-label" for="Id_TipoDocumento">* Localidad </label>
										        				<input type="text"  name="Localidad_eje" class="form-control"/>
										        			</div>
										        		</div>
										        		<div class="col-xs-12 col-md-6">
										        			<div class="form-group">
										        				<label class="control-label" for="Cedula">* Tipo entidad </label>
																<input type='text' name="Tipo_entidad" class="form-control"/>
										        			</div>
										        		</div>
										        		<div class="col-xs-12 col-md-6">
										        			<div class="form-group">
										        				<label class="control-label" for="Cedula">* Tipo </label>
																<input type='text' name="Tipo" class="form-control"/>
										        			</div>
										        		</div>
										        		<div class="col-xs-12 col-md-6">
										        			<div class="form-group">
										        				<label class="control-label" for="Cedula">* Condición </label>
																<input type='text' name="Condicion" class="form-control"/>
										        			</div>
										        		</div>
										        		<div class="col-xs-12 col-md-6">
										        			<div class="form-group">
										        				<label class="control-label" for="Cedula">* Situación </label>
																<input type='text' name="Situacion" class="form-control"/>
										        			</div>
										        		</div>

										        		<div class="col-xs-12 col-md-2">
										        			<div class="form-group">
										        				<label class="control-label" for="Cedula">0 a 5</label>
																<input type='text' name="M_0_5" placeholder="Masculino" class="form-control"/>
																<input type='text' name="F_0_5" placeholder="Femenino"  class="form-control"/>
										        			</div>
										        		</div>
										        		<div class="col-xs-12 col-md-2">
										        			<div class="form-group">
										        				<label class="control-label" for="Cedula">6 a 12 </label>
																<input type='text' name="M_6_12" placeholder="Masculino" class="form-control"/>
																<input type='text' name="F_6_12" placeholder="Femenino"  class="form-control"/>
										        			</div>
										        		</div>
										        		<div class="col-xs-12 col-md-2">
										        			<div class="form-group">
										        				<label class="control-label" for="Cedula">13 a 17</label>
																<input type='text' name="M_13_17" placeholder="Masculino" class="form-control"/>
																<input type='text' name="F_13_17" placeholder="Femenino"  class="form-control"/>
										        			</div>
										        		</div>
										        		<div class="col-xs-12 col-md-2">
										        			<div class="form-group">
										        				<label class="control-label" for="Cedula">18 a 26 </label>
																<input type='text' name="M_18_26" placeholder="Masculino" class="form-control"/>
																<input type='text' name="F_18_26" placeholder="Femenino"  class="form-control"/>
										        			</div>
										        		</div>
										        		<div class="col-xs-12 col-md-2">
										        			<div class="form-group">
										        				<label class="control-label" for="Cedula">27 a 59</label>
																<input type='text' name="M_27_59" placeholder="Masculino" class="form-control"/>
																<input type='text' name="F_27_59" placeholder="Femenino"  class="form-control"/>
										        			</div>
										        		</div>
										        		<div class="col-xs-12 col-md-2">
										        			<div class="form-group">
										        				<label class="control-label text-center" for="Cedula">60 o mas </label>
																<input type='text' name="M_60" placeholder="Masculino" class="form-control"/>
																<input type='text' name="F_60" placeholder="Femenino"  class="form-control"/>
										        			</div>
										        		</div>
													      <div class="col-xs-12 col-md-12">
													         <button type="button" class="btn btn-default" data-dismiss="modal">Agregar</button>
													      </div>

															<div id="alerta_actividad_error" class="col-xs-12" style="display:none;">
																<div class="alert alert-danger alert-dismissible" role="alert">
																	<div id="mensaje_agregar_datos"></div>
																</div>
															</div>


										        
										       		</fieldset>
						  </div>
						</div>

					
					   
			</div>
			</form> 
	  </div>
  	</div>
</div> 





@stop
