$(function()
{
	var URL = $('#mis_actividad_aprobar').data('url');
	vector_datos_ejecucion = new Array();
    vector_novedades = new Array();
    var estado_programacion="";
    var estado_ejecucion="";
    var dehabilitar="";
	$('#form_actividad_aprobar').on('submit', function(e){
				$("#espera1").html("<img src='public/Img/loading.gif'/>");
				$.post(
					URL+'/service/misActividadesGestor',
					$(this).serialize(),
					function(data){
							if(data.status == 'error')
							{
								validador_errores_form(data.errors);
							} else {
								var counter = 1;
									
								if(data.length > 0)
								{
									
									var num=1;
									var html="";
									t.clear().draw();
									$.each(data, function(i, e){
										if(e['Estado']==2){
											estado_programacion="<center><span class='glyphicon glyphicon-ok' aria-hidden='true'></span><center>";
											dehabilitar="";
										}
										if(e['Estado']==1){
											estado_programacion="<center><span class='glyphicon glyphicon-remove aria-hidden='true'></span><center>";
											dehabilitar="disabled";
										}


										if(e['Estado_Ejecucion']==4){ //Cancelado
											estado_ejecucion="<center><span class='glyphicon glyphicon-remove aria-hidden='true'></span><center>";
											
										}
										if(e['Estado_Ejecucion']==3){ //Aprobado
											estado_ejecucion="<center><span class='glyphicon glyphicon-ok aria-hidden='true'></span><center>";
											
										}
										if(e['Estado_Ejecucion']==2){  //Hay informacion
											estado_ejecucion="<center><span class='glyphicon glyphicon-star' aria-hidden='true'></span><center>";
											
										}
										if(e['Estado_Ejecucion']==1){  //No hay informacion
											estado_ejecucion="<center><span class='glyphicon glyphicon-star-empty aria-hidden='true'></span><center>";
											
										}


										t.row.add( [
								            '<th scope="row" class="text-center">'+num+'</th>',
								            '<td class="text-center"><h4>'+e['Id_Actividad_Gestor']+'<h4></td>',
								            '<td>'+e.persona_programador['Primer_Apellido']+' '+e.persona_programador['Segundo_Apellido']+' '+e.persona_programador['Primer_Nombre']+' '+e.persona_programador['Segundo_Nombre']+'</td>',
								            '<td>'+e.persona['Primer_Apellido']+' '+e.persona['Segundo_Apellido']+' '+e.persona['Primer_Nombre']+' '+e.persona['Segundo_Nombre']+'</td>',
								            '<td>'+e['Fecha_Ejecucion']+'</td>',
								            '<td>'+e.localidad['Nombre_Localidad']+'</td>',
								            '<td>'+e['Hora_Incial']+'</td>',
								            '<td>'+e.parque['Nombre']+'</td>',
								            '<td style="text-align:center "><center><button type="button" data-rel="'+e['Id_Actividad_Gestor']+'" data-funcion="ver_inf" class="btn btn-primary btn-sm" ><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> ver</button><div id="espera'+e['Id_Actividad_Gestor']+'"></div></td>',
								            '<td>'+estado_programacion+'</td>',
								            '<td style="text-align:center"><center><button type="button" data-rel="'+e['Id_Actividad_Gestor']+'" data-funcion="ejec_ver" class="btn btn-primary btn-sm" '+dehabilitar+'><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> ver</button><div id="espera_eje'+e['Id_Actividad_Gestor']+'"></div></td>',
								            '<td>'+estado_ejecucion+'</td>'
								        ] ).draw( false );

										num++;
									});
								}
							}
							$("#espera1").html("");
					},
					'json'
				);
		e.preventDefault();
	});

	var validador_errores_form = function(data)
	{
		$('#form_actividad_aprobar .form-group').removeClass('has-error');
		var selector = '';
		for (var error in data){
		    if (typeof data[error] !== 'function') {
		        switch(error)
		        {
		        	case 'Fecha_Inicio':
		        	case 'Fecha_Fin':
		        		selector = 'input';
		        	break;
		        }
		        $('#form_actividad_aprobar '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
		    }
		}
	}


     var t = $('#Tabla3').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    });

	$('#Tabla3').delegate('button[data-funcion="ver_inf"]','click',function (e) {  

        var id = $(this).data('rel'); 
        $("#espera"+id).html("<img src='public/Img/loading.gif'/>");
        $.get(
            URL+'/service/obtener/'+id,
            {},
            function(data)
            {   
                if(data)
                {
                	$("#espera"+id).html("");
                    actividad_datos_eje(data);
                }
            },
            'json'
        );

    }); 

    var actividad_datos_eje = function(datos)
    {
 
        //console.log(datos);
        $("#titulo_id").text(datos.datosActividad['Id_Actividad_Gestor']);
        $('input[name="Id_Actividad"]').val(datos.datosActividad['Id_Actividad_Gestor']);
        $('select[name="Id_Localidad"]').val(datos.datosActividad['Localidad']);
        $('select[name="Id_Responsable"]').val(datos.datosActividad['Id_Responsable']);
        $('input[name="Hora_Inicio"]').val(datos.datosActividad['Hora_Incial']);
        $('input[name="Hora_Fin"]').val(datos.datosActividad['Hora_Final']);
        $('input[name="Fecha_Ejecucion"]').val(datos.datosActividad['Fecha_Ejecucion']);
        $('select[name="Parque"]').selectpicker('val',datos.datosActividad['Parque']);
        $('input[name="Caracteristica_Lugar"]').val(datos.datosActividad['Caracteristica_Lugar']);
        $('textarea[name="Caracteristica_poblacion"]').val(datos.datosActividad['Caracteristica_Poblacion']);
        $('textarea[name="Caracteristica_Lugar"]').val(datos.datosActividad['Caracteristica_Lugar']);
        $('input[name="Institucion_Grupo"]').val(datos.datosActividad['Instit_Grupo_Comun']);
        $('input[name="Numero_Asistentes"]').val(datos.datosActividad['Numero_Asistente']);
        $('input[name="Hora_Implementacion"]').val(datos.datosActividad['Hora_Implementacion']);
        $('input[name="Persona_Contacto"]').val(datos.datosActividad['Nombre_Contacto']);
        $('input[name="Roll_Comunidad"]').val(datos.datosActividad['Rool_Comunidad']);
        $('input[name="Telefono"]').val(datos.datosActividad['Telefono']);

        $('#modal_form_act_eje').modal('show');
    };


    $('#Tabla3').delegate('button[data-funcion="ejec_ver"]','click',function (e) {  
        var id = $(this).data('rel'); 
        $("#espera_eje"+id).html("<img src='public/Img/loading.gif'/>");
        vector_datos_ejecucion.length=0;
        vector_novedades.length=0;
        $('input[name="Id_Actividad_E"]').val(id);

		$('#table_ejecucion_agregada').hide();
        $.get(
            URL+'/service/obtener/'+id,
            {},
            function(data)
            {   
                if(data)
                {
                	$("#espera_eje"+id).html("");
                    actividad_ejecucion(data);
                }
            },
            'json'
        );
    }); 

    var actividad_ejecucion = function(datos)
    {
    	$('input[name="Id_Actividad_ejecucion"]').val(datos.datosActividad['Id_Actividad_Gestor']);
  		$('#titulo').text(datos.datosActividad['Id_Actividad_Gestor']);
        $('#modal_ejecucion').modal('show');
    };

    $('#Modificar_').on('click', function(e){
                $.post(
                    URL+'/service/ModificarActividad',
                    $("#form_actividad_mm").serialize(),
                    function(data){
                            if(data.status == 'error')
                            {
                                validador_errores(data.errors);
                            } else {

                            	$('#form_actividad_mm .form-group').removeClass('has-error');
								$('#mensajeModifica').html('<div class="alert alert-dismissible alert-success" ><strong>Exito!</strong> Dato modificado de la actividad con exito. </div>');
								$('#modalMensaj').modal('show');
								setTimeout(function(){
									$('#modal_form_act_eje').modal('hide');
									$('#modalMensaj').modal('hide');
								}, 3000)      

								actulaizarTabla();                     	
                            }
                    },
                    'json'
                );

        e.preventDefault();
        return false;
    });


    function actulaizarTabla(){
    	$("#espera1").html("<img src='public/Img/loading.gif'/>");
								$.post(
									URL+'/service/misActividadesGestor',
									$("#form_actividad_aprobar").serialize(),
									function(data){
											if(data.status == 'error')
											{
												validador_errores_form(data.errors);
											} else {
												var counter = 1;
													
												if(data.length > 0)
												{
													
													var num=1;
													var html="";
													t.clear().draw();
													$.each(data, function(i, e){
														if(e['Estado']==2){
															estado_programacion="<center><span class='glyphicon glyphicon-ok' aria-hidden='true'></span><center>";
															dehabilitar="";
														}
														if(e['Estado']==1){
															estado_programacion="<center><span class='glyphicon glyphicon-remove aria-hidden='true'></span><center>";
															dehabilitar="disabled";
														}


														if(e['Estado_Ejecucion']==4){ //Cancelado
															estado_ejecucion="<center><span class='glyphicon glyphicon-remove aria-hidden='true'></span><center>";
															
														}
														if(e['Estado_Ejecucion']==3){ //Aprobado
															estado_ejecucion="<center><span class='glyphicon glyphicon-ok aria-hidden='true'></span><center>";
															
														}
														if(e['Estado_Ejecucion']==2){  //Hay informacion
															estado_ejecucion="<center><span class='glyphicon glyphicon-star' aria-hidden='true'></span><center>";
															
														}
														if(e['Estado_Ejecucion']==1){  //No hay informacion
															estado_ejecucion="<center><span class='glyphicon glyphicon-star-empty aria-hidden='true'></span><center>";
														
														}

														t.row.add( [
												            '<th scope="row" class="text-center">'+num+'</th>',
												            '<td class="text-center"><h4>'+e['Id_Actividad_Gestor']+'<h4></td>',
												            '<td>'+e.persona_programador['Primer_Apellido']+' '+e.persona_programador['Segundo_Apellido']+' '+e.persona_programador['Primer_Nombre']+' '+e.persona_programador['Segundo_Nombre']+'</td>',
												            '<td>'+e.persona['Primer_Apellido']+' '+e.persona['Segundo_Apellido']+' '+e.persona['Primer_Nombre']+' '+e.persona['Segundo_Nombre']+'</td>',
												            '<td>'+e['Fecha_Ejecucion']+'</td>',
												            '<td>'+e.localidad['Nombre_Localidad']+'</td>',
												            '<td>'+e['Hora_Incial']+'</td>',
												            '<td>'+e.parque['Nombre']+'</td>',
												            '<td style="text-align:center "><center><button type="button" data-rel="'+e['Id_Actividad_Gestor']+'" data-funcion="ver_inf" class="btn btn-primary btn-sm" ><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> ver</button><div id="espera'+e['Id_Actividad_Gestor']+'"></div></td>',
												            '<td>'+estado_programacion+'</td>',
												            '<td style="text-align:center"><center><button type="button" data-rel="'+e['Id_Actividad_Gestor']+'" data-funcion="ejec_ver" class="btn btn-primary btn-sm" '+dehabilitar+'><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> ver</button><div id="espera_eje'+e['Id_Actividad_Gestor']+'"></div></td>',
												            '<td>Espera</td>'
												        ] ).draw( false );

														num++;
													});
												}
											}
											$("#espera1").html("");
									},
									'json'
								);
    }

    var validador_errores = function(data)
	{
		$('#form_actividad_mm .form-group').removeClass('has-error');
		var selector = '';
		for (var error in data){
		    if (typeof data[error] !== 'function') {
		        switch(error)
		        {
		        	
		        	case 'Id_Responsable':
		        	case 'Id_Localidad':
		        	case 'Parque':
		        		selector = 'select';
		        	break;

		        	case 'Fecha_Ejecución':
		        	case 'Hora_Inicio':
		        	case 'Hora_Fin':
		        	case 'Institucion_Grupo':
		        	case 'Numero_Asistentes':
		        	case 'Hora_Implementacion':
		        	case 'Persona_Contacto':
		        	case 'Roll_Comunidad':
		        	case 'Telefono':
		        		selector = 'input';
		        	break;

		        	case 'Caracteristica_Lugar':
		        	case 'Caracteristica_poblacion':
		        		selector = 'textarea';
		        	break;
		        }
		        $('#form_actividad_mm '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
		    }
		}
	}

    $('#Cerrar_c').on('click', function(e){
                $('#modal_form_act_eje').modal('hide');
        		e.preventDefault();
    });

    $('#Aprobar_').on('click', function(e){
    			var id= $('input[name="Id_Actividad"]').val();
    			$.get(
		            URL+'/service/activar/'+id,
		            {},
		            function(data)
		            {   	
		               			$('#mensajeModifica').html("<div class='alert alert-success' role='alert'> <strong>Bien!</strong> La actividad ha sido aprobada.. </div>");
								$('#modalMensaj').modal('show');
								setTimeout(function(){
									$('#modal_form_act_eje').modal('hide');
									$('#modalMensaj').modal('hide');
								}, 3000)
								actulaizarTabla();
		            }
		        );

		        e.preventDefault();
    });



    $('#Cancelar_').on('click', function(e){
                var id= $('input[name="Id_Actividad"]').val();
    			$.get(
		            URL+'/service/cancelar/'+id,
		            {},
		            function(data)
		            {   
		               			$('#mensajeModifica').html("<div class='alert alert-success' role='alert'> <strong>Bien!</strong> La actividad ha sido cancelada.. </div>");
								$('#modalMensaj').modal('show');
								setTimeout(function(){
									$('#modal_form_act_eje').modal('hide');
									$('#modalMensaj').modal('hide');
								}, 3000)
								actulaizarTabla();
		            }
		        );

		        e.preventDefault();
    });




    $('#Cerrar_e').on('click', function(e){
                $('#modal_ejecucion').modal('hide');
        		e.preventDefault();
    });

    $('#Aprobar_e').on('click', function(e){
    			var id= $('input[name="Id_Actividad"]').val();
    			alert(id);

    			/*$.get(
		            URL+'/service/activar/'+id,
		            {},
		            function(data)
		            {   	
		               			$('#mensajeModifica').html("<div class='alert alert-success' role='alert'> <strong>Bien!</strong> La actividad ha sido aprobada.. </div>");
								$('#modalMensaj').modal('show');
								setTimeout(function(){
									$('#modal_form_act_eje').modal('hide');
									$('#modalMensaj').modal('hide');
								}, 3000)
								actulaizarTabla();
		            }
		        );*/

		        e.preventDefault();
    });











    //FORMULARIO DE EJECUCION: DATOS COMUNIDAD
    


	$('#agregar_datos_ejecucion').on('click', function(e)
	{
			$('#table_ejecucion_agregada').hide();
			$.post(
					URL+'/service/datos_actividades',
					$("#form_ejecucion_datos_actividad").serialize(),
					function(data){
						
							if(data.status == 'error')
							{
								validador_errores_datos_eje(data.errors);
							} else {

								var Id_Actividad_ejecucion=$('input[name="Id_Actividad_ejecucion"]').val();
								var Inst_grupo_comu=$('input[name="Inst_grupo_comu"]').val();
								
								var Localidad_eje=$('select[name="Localidad_eje"]').val();
								var Tipo_entidad=$('select[name="Tipo_entidad"]').val();
								var Tipo_eje=$('select[name="Tipo_eje"]').val();
								var Condicion=$('select[name="Condicion"]').val();
								var Situacion=$('select[name="Situacion"]').val();

								var M_0_5=$('input[name="M_0_5"]').val();
								var F_0_5=$('input[name="F_0_5"]').val();
								var M_6_12=$('input[name="M_6_12"]').val();
								var F_6_12=$('input[name="F_6_12"]').val();
								var M_13_17=$('input[name="M_13_17"]').val();
								var F_13_17=$('input[name="F_13_17"]').val();
								var M_18_26=$('input[name="M_18_26"]').val();
								var F_18_26=$('input[name="F_18_26"]').val();
								var M_27_59=$('input[name="M_27_59"]').val();
								var F_27_59=$('input[name="F_27_59"]').val();
								var M_60=$('input[name="M_60"]').val();
								var F_60=$('input[name="F_60"]').val();

								vector_datos_ejecucion.push({
									"Id_Actividad_ejecucion": Id_Actividad_ejecucion,
									"Inst_grupo_comu": Inst_grupo_comu,
									"Localidad_eje": Localidad_eje,
									"Tipo_entidad": Tipo_entidad,
									"Tipo_eje": Tipo_eje,
									"Condicion": Condicion,
									"Situacion": Situacion,
									"M_0_5": M_0_5,
									"F_0_5": F_0_5,
									"M_6_12": M_6_12,
									"F_6_12": F_6_12,
									"M_13_17": M_13_17,
									"F_13_17": F_13_17,
									"M_18_26": M_18_26,
									"F_18_26": F_18_26,
									"M_27_59": M_27_59,
									"F_27_59": F_27_59,
									"M_60": M_60,
									"F_60": F_60
								});

								//console.log(vector_datos_ejecucion);

								$('#ejecucion_agregada').show();
								$('#ejecucion_agregada').html('Se registro los datos de la ejecución.');
								setTimeout(function(){
									$('#ejecucion_agregada').hide();
								}, 2000)

							}
					},
					'json'
				);

            
			return false;
		
	});


	var validador_errores_datos_eje = function(data)
	{
		$('#form_ejecucion_datos_actividad .form-group').removeClass('has-error');
		var selector = '';
		for (var error in data){
		    if (typeof data[error] !== 'function') {
		        switch(error)
		        {
		        	case 'Inst_grupo_comu':
		        	case 'M_0_5':
		        	case 'F_0_5':
		        	case 'M_6_12':
		        	case 'F_6_12':
		        	case 'M_13_17':
		        	case 'F_13_17':
		        	case 'M_18_26':
		        	case 'F_18_26':
		        	case 'M_27_59':
		        	case 'F_27_59':
		        	case 'M_60':
		        	case 'F_60':
		        		selector = 'input';
		        	break;

		        	case 'Localidad_eje':
		        	case 'Tipo_entidad':
		        	case 'Tipo_eje':
		        	case 'Condicion':
		        	case 'Situacion':
		        		selector = 'select';
		        	break;

		        }
		        $('#form_ejecucion_datos_actividad '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
		    }
		}
	}


	$('#ver_datos_tabla_ejecucion').on('click', function(e)
	{
			$('#ejecucion_agregada').hide();
			var html = '';
					if(vector_datos_ejecucion.length > 0)
					{
						var num=1;
						$.each(vector_datos_ejecucion, function(i, e){
							html += '<tr><th scope="row" class="text-center">'+num+'</th><td>'+e['Inst_grupo_comu']+'</td><td>'+e['M_0_5']+'</td><td>'+e['F_0_5']+'</td><td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="crear" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
							num++;
						});
					}
					$('#registros_ejecucion').html(html);

			$('#table_ejecucion_agregada').show();
			return false;	
	});

	$('#datos_ejecucion_tabla').delegate('button[data-funcion="crear"]','click',function (e) {   
		var id = $(this).data('rel'); 
	    vector_datos_ejecucion.splice(id, 1);
	        
	        var html = '';
					if(vector_datos_ejecucion.length > 0)
					{
						var num=1;
						$.each(vector_datos_ejecucion, function(i, e){
							html += '<tr><th scope="row" class="text-center">'+num+'</th><td>'+e['Inst_grupo_comu']+'</td><td>'+e['M_0_5']+'</td><td>'+e['F_0_5']+'</td><td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="crear" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
							num++;
						});
					}
					$('#registros_ejecucion').html(html);

     }); 

	$('#cerrar_tabla_ejecu').on('click', function(e)
	{
			$('#table_ejecucion_agregada').hide();
			return false;	
	});






	  //FORMULARIO DE EJECUCION : DATOS NOVEDADES
    
	$('#agregar_datos_novedades').on('click', function(e)
	{
			$('#table_novedad_agregada').hide();
			$.post(
					URL+'/service/datos_novedades',
					$("#form_ejecucion_novedades").serialize(),
					function(data){
							if(data.status == 'error')
							{
								validador_errores_novedades(data.errors);
							} 
							else
							{
								var Id_Actividad_ejecucion=$('input[name="Id_Actividad_ejecucion"]').val();
								var Id_Requisito=$('select[name="Id_Requisito"]').val();
								var causa=$('input[name="causa"]').val();
								var accion=$('input[name="accion"]').val();

								vector_novedades.push({
									"Id_Actividad_ejecucion": Id_Actividad_ejecucion,
									"Id_Requisito": Id_Requisito,
									"causa": causa,
									"accion": accion,
								});
								$('#novedad_agregada').show();
								$('#novedad_agregada').html('Se registro los datos de la novedad.');
								setTimeout(function(){
									$('#novedad_agregada').hide();
								}, 2000)
							}
					},
					'json'
				);            
			return false;
	});



	var validador_errores_novedades = function(data)
	{
		$('#form_ejecucion_novedades .form-group').removeClass('has-error');
		var selector = '';
		for (var error in data){
		    if (typeof data[error] !== 'function') {
		        switch(error)
		        {
		        	case 'accion':
		        	case 'causa':
		        		selector = 'input';
		        	break;

		        	case 'Id_Requisito':
		        		selector = 'select';
		        	break;

		        }
		        $('#form_ejecucion_novedades '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
		    }
		}
	}

	$('#ver_datos_tabla_novedades').on('click', function(e)
	{
			$('#novedad_agregada').hide();
			var html = '';
					if(vector_novedades.length > 0)
					{
						var num=1;
						$.each(vector_novedades, function(i, e){
							html += '<tr><th scope="row" class="text-center">'+num+'</th><td>'+e['Id_Requisito']+'</td><td>'+e['accion']+'</td><td>'+e['causa']+'</td><td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="eliminar_novedad" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
							num++;
						});
					}
					$('#registros_novedad').html(html);

			$('#table_novedad_agregada').show();
			return false;	
	});

	$('#datos_novedad_tabla').delegate('button[data-funcion="eliminar_novedad"]','click',function (e) {   
		var id = $(this).data('rel'); 
	    vector_novedades.splice(id, 1);
	        
	        var html = '';
					if(vector_novedades.length > 0)
					{
						var num=1;
						$.each(vector_novedades, function(i, e){
							html += '<tr><th scope="row" class="text-center">'+num+'</th><td>'+e['Id_Requisito']+'</td><td>'+e['accion']+'</td><td>'+e['causa']+'</td><td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="eliminar_novedad" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
							num++;
						});
					}
					$('#registros_novedad').html(html);

     }); 

	$('#cerrar_tabla_novedad').on('click', function(e)
	{
			$('#table_novedad_agregada').hide();
			return false;	
	});



	  //FORMULARIO DE EJECUCION : REGISTRO DE LA EJECUCION
    
	$('#registro_agregada').on('click', function(e)
	{
			if(vector_novedades.length > 0 && vector_datos_ejecucion.length > 0 )
			{
				var formData = new FormData($("#form_ejecucion_servicio")[0]);
				formData.append("vector_novedades",vector_novedades);
				formData.append("vector_datos_ejecucion",vector_datos_ejecucion);
		        $.ajax({
		            url: URL+'/service/registro_ejecucion',  
		            type: 'POST',
		            data: formData,
		            contentType: false,
		            processData: false,
		            success: function(data){
						    if(data.status == 'error')
							{
								validador_errores_registroEjecucion(data.errors);
							}
							else 
							{
								$('#registro_agregadaFin').show();
								$('#registro_agregadaFin').html('Se registro las ejecución con exito!.');
								setTimeout(function(){
									$('#registro_agregadaFin').hide();
								}, 2000)
							}
		            }
		        });
			}
			else
			{
				$('#registro_agregada').show();
				$('#registro_agregada').html('Los pasos 1 y 2 son obligatorios, por favor ingresar los datos.');
					setTimeout(function(){
							$('#registro_agregada').hide();
					}, 2000)

			}           
			return false;
	});





	var validador_errores_registroEjecucion = function(data)
	{
		$('#form_ejecucion_servicio .form-group').removeClass('has-error');
		var selector = '';
		for (var error in data){
		    if (typeof data[error] !== 'function') {
		        switch(error)
		        {
		        	case 'puntualidad':
		        	case 'divulgacion':
		        	case 'escenarioMontaje':
		        	case 'cumplimiento':
		        	case 'variedadCreatividad':
		        	case 'seguridad':
		        		selector = 'select';
		        	break;

		        	case 'nombreRepresentante':
		        	case 'telefonoRepresentante':
		        		selector = 'input';
		        	break;


		        	case 'imagen1':
		        	case 'imagen2':
		        	case 'imagen3':
		        	case 'imagen4':
		        	case 'listaAsistencia':
		        	case 'acta':
		        		selector = 'input';
		        	break;
		        }
		        $('#form_ejecucion_servicio '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
		    }
		}
	}





});