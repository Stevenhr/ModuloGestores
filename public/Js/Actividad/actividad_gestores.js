$(function()
{
	var URL = $('#mis_actividad_gestores').data('url');

	$('#form_actividad_gestor').on('submit', function(e){
				$("#espera").html("<img src='public/Img/loading.gif'/>");
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

										t.row.add( [
								            '<th scope="row" class="text-center">'+num+'</th>',
								            '<td class="text-center"><h4>'+e['Id_Actividad_Gestor']+'<h4></td>',
								            '<td>'+e.persona['Primer_Apellido']+' '+e.persona['Segundo_Apellido']+' '+e.persona['Primer_Nombre']+' '+e.persona['Segundo_Nombre']+'</td>',
								            '<td>'+e['Fecha_Ejecucion']+'</td>',
								            '<td>'+e.localidad['Nombre_Localidad']+'</td>',
								            '<td>'+e['Hora_Incial']+'</td>',
								            '<td>'+e.parque['Nombre']+'</td>',
								            '<td style="text-align:center "><center><button type="button" data-rel="'+e['Id_Actividad_Gestor']+'" data-funcion="ver_inf" class="btn btn-primary btn-sm" ><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> ver</button><div id="espera'+e['Id_Actividad_Gestor']+'"></div></td>',
								            '<td style="text-align:center"><center><button type="button" data-rel="'+e['Id_Actividad_Gestor']+'" data-funcion="ejec_ver" class="btn btn-primary btn-sm" ><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> ver</button><div id="espera_eje'+e['Id_Actividad_Gestor']+'"></div></td>'
								        ] ).draw( false );

										num++;
									});
								}
							}
							$("#espera").html("");
					},
					'json'
				);
        
		e.preventDefault();
	});

	var validador_errores_form = function(data)
	{
		$('#form_actividad_gestor .form-group').removeClass('has-error');
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
		        $('#form_actividad_gestor '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
		    }
		}
	}


     var t = $('#Tabla2').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    });

	$('#Tabla2').delegate('button[data-funcion="ver_inf"]','click',function (e) {  
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
        $('input[name="Id_Actividad"]').val(datos.datosActividad['Id_Actividad_Gestor']);
        $('input[name="Id_Localidad"]').val(datos.datosActividad.localidad['Nombre_Localidad']);
        $('input[name="Id_Responsable"]').val(datos.datosActividad.persona['Primer_Apellido']+" "+datos.datosActividad.persona['Segundo_Apellido']+" "+datos.datosActividad.persona['Primer_Nombre']+" "+datos.datosActividad.persona['Segundo_Nombre']);
        $('input[name="Hora_Inicio"]').val(datos.datosActividad['Hora_Incial']);
        $('input[name="Hora_Fin"]').val(datos.datosActividad['Hora_Final']);
        $('input[name="Fecha_Ejecucion"]').val(datos.datosActividad['Fecha_Ejecucion']);
        $('input[name="Parque"]').val(datos.datosActividad.parque['Nombre']);
        $('input[name="Caracteristica_Lugar"]').val(datos.datosActividad['Caracteristica_Lugar']);
        document.form_actividad_m.Caracteristica_poblacion.value = datos.datosActividad['Caracteristica_Poblacion'];
        document.form_actividad_m.Caracteristica_Lugar.value = datos.datosActividad['Caracteristica_Lugar'];
        $('input[name="Institucion_Grupo"]').val(datos.datosActividad['Instit_Grupo_Comun']);
        $('input[name="Numero_Asistentes"]').val(datos.datosActividad['Numero_Asistente']);
        $('input[name="Hora_Implementacion"]').val(datos.datosActividad['Hora_Implementacion']);
        $('input[name="Persona_Contacto"]').val(datos.datosActividad['Nombre_Contacto']);
        $('input[name="Roll_Comunidad"]').val(datos.datosActividad['Rool_Comunidad']);
        $('input[name="Telefono"]').val(datos.datosActividad['Telefono']);
        $('#modal_form_act_eje').modal('show');
    };


    $('#Tabla2').delegate('button[data-funcion="ejec_ver"]','click',function (e) {  
        var id = $(this).data('rel'); 
        $("#espera_eje"+id).html("<img src='public/Img/loading.gif'/>");
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


/*	
	$('#agregar_actividad').on('click', function(e)
	{		
			var id_eje=$('select[name="Id_Eje"]').val();
			var id_tematica=$('select[name="Id_Tematica"]').val();
			var id_act = $('select[name="Id_Actividad"]').val();
			//alert(id_eje);
			if(id_eje===''){
				$('#alert_actividad').html('<div class="alert alert-dismissible alert-danger" ><strong>Error!</strong> Debe seleccionar un eje para poder realizar el registro.</div>');
				$('#mensaje_actividad').show(60);
				$('#mensaje_actividad').delay(2500).hide(600);

			}else{
				$('#alert_actividad').html('<div class="alert alert-dismissible alert-success" ><strong>Exito!</strong> Dato de la actividad registrado con exito. </div>');
				$('#mensaje_actividad').show(60);
				$('#mensaje_actividad').delay(1500).hide(600);
				vector_datos_actividades.push({"id_eje": id_eje, "id_tematica": id_tematica, "id_act": id_act});
			}
			return false;
	});



	$('#ver_datos_actividad').on('click', function(e)
	{
			
			var html = '';
			//console.log(vector_datos_actividades);
					if(vector_datos_actividades.length > 0)
					{
						var num=1;
						$.each(vector_datos_actividades, function(i, e){
							html += '<tr><th scope="row" class="text-center">'+num+'</th><td>'+Buscar_Eje(e['id_eje'])+'</td><td>'+Buscar_Tematica(e['id_tematica'])+'</td><td>'+Buscar_Actividad(e['id_act'])+'</td><td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="crear" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
							num++;
						});
					}
					$('#registros').html(html);

			$('#ver_registros').modal('show');
			return false;
		
	});

	$('#datos_actividad').delegate('button[data-funcion="crear"]','click',function (e) {   
		var id = $(this).data('rel'); 
	    vector_datos_actividades.splice(id, 1);
	        
	        $('#mensaje_eliminar').html('<div class="alert alert-dismissible alert-success" ><strong>Exito!</strong> Dato eliminado de la actividad con exito. </div>');
	        $('#mensaje_eliminar').show(60);
			$('#mensaje_eliminar').delay(1500).hide(600);
	        var html = '';
					if(vector_datos_actividades.length > 0)
					{
						var num=1;
						$.each(vector_datos_actividades, function(i, e){
							html += '<tr><th scope="row" class="text-center">'+num+'</th><td>'+Buscar_Eje(e['id_eje'])+'</td><td>'+Buscar_Tematica(e['id_tematica'])+'</td><td>'+Buscar_Actividad(e['id_act'])+'</td><td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="crear" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
							num++;
						});
					}
					$('#registros').html(html);

     }); 


	$('#asignar_acompañante').on('click', function(e)
	{
			var html = '';
			var id=46;
			var check="";

			$.get(
				URL+'/service/persona_tipo/'+id,
				{},
				function(data)
				{

						if(data.length > 0)
						{
							var html = '';
							$.each(data, function(i, e){
								var paso=0;
								if(vector_acompañantes.length>0){
										$.each(vector_acompañantes, function(i, a){
											if(a['acompa']==e['Id_Persona']){
												paso=1;
											}
										});
								}
								if(paso==1){check="checked";}else{check="";}
								html += '<tr><th scope="row">'+e['Primer_Apellido']+' '+e['Segundo_Apellido']+' '+e['Primer_Nombre']+' '+e['Segundo_Nombre']+'</th><td> <div class="checkbox text-center"><label ><input data-rel="'+e['Id_Persona']+'" data-funcion="agregar" type="checkbox" '+check+'></label></div></td><td class="text-center"><span class="glyphicon glyphicon-calendar " aria-hidden="true"></span></td></tr>';
							});
							$('#div_acompañante').html(html);
						}
						$('#ver_acompañante').modal('show');
					
				},
				'json'
			);
			return false;		
	});



	$('#datos_acopañante').delegate('input[data-funcion="agregar"]','click',function (e) {   
		
		var id = $(this).data('rel'); 
		if($(this).is(':checked')) {  
			vector_acompañantes.push({"acompa": id});
		}else {  
			
			arr = jQuery.grep(vector_acompañantes, function( a,i ) {
			   return a.acompa==id;
			},true);
			vector_acompañantes=arr;
        } 

     }); 



	$('select[name="Id_Eje"]').on('change', function(e){
		select_tematicas($(this).val());
	});
	$('select[name="Id_Tematica"]').on('change', function(e){
		select_actividades($(this).val());
	});

	var select_tematicas = function(id)
	{ 

		if(id!=''){
			$.ajax({
				url: URL+'/service/tematica/'+id,
				data: {},
				dataType: 'json',
				success: function(data)
				{

					var html = '<option value="">Seleccionar</option>';
					if(data.length > 0)
					{
						$.each(data, function(i, e){
							html += '<option value="'+e['Id_Tematica']+'">'+e['Nombre_Tematica']+'</option>';
						});
					}
					$('select[name="Id_Tematica"]').html(html).val($('select[name="Id_Tematica"]').data('value'));
				}
			});
		}else{
					var html = '<option value="">Seleccionar</option>';
					$('select[name="Id_Tematica"]').html(html).val($('select[name="Id_Tematica"]').data('value'));
		}

	};

	var select_actividades = function(id)
	{

		if(id!=''){
			$.ajax({
				url: URL+'/service/actividad/'+id,
				data: {},
				dataType: 'json',
				success: function(data)
				{

					var html = '<option value="">Seleccionar</option>';
					if(data.length > 0)
					{
						$.each(data, function(i, e){
							html += '<option value="'+e['Id_Actividad']+'">'+e['Nombre_Actividad']+'</option>';
						});
					}
					$('select[name="Id_Actividad"]').html(html).val($('select[name="Id_Actividad"]').data('value'));
				}
			});
		}else{
					var html = '<option value="">Seleccionar</option>';
					$('select[name="Id_Actividad"]').html(html).val($('select[name="Id_Actividad"]').data('value'));
		}
	};



	function Buscar_Eje(id)
	{ 
		var nombre_eje="";
			
			$.ajax({
				url: URL+'/service/Eje/'+id,
				data: {},
				dataType: 'json',
				async: false,
				success: function(data)
				{
					
					nombre_eje = String(data['Nombre_Eje']);
					
				}
			});

			return nombre_eje;
	};


	function Buscar_Tematica(id)
	{ 
		var Nombre_Temat="";
			
			$.ajax({
				url: URL+'/service/Tematica/'+id,
				data: {},
				dataType: 'json',
				async: false,
				success: function(data)
				{
					
					Nombre_Temat = String(data['Nombre_Tematica']);
					
				}
			});

			return Nombre_Temat;
	};



	function Buscar_Actividad(id)
	{ 
		var Nombre_Temat="";
			
			$.ajax({
				url: URL+'/service/Actividad/'+id,
				data: {},
				dataType: 'json',
				async: false,
				success: function(data)
				{
					
					Nombre_Temat = String(data['Nombre_Actividad']);
					
				}
			});

			return Nombre_Temat;
	};




		$('#datetimepicker1').datetimepicker({
                      format: 'HH:mm'
                });
		$('#datetimepicker2').datetimepicker({
                      format: 'HH:mm'
                });
		$('#datetimepicker3').datetimepicker({
                      format: 'HH:mm'
                });



	

	



	$('#cerrar_actividad').delegate('button[data-funcion="cerrar"]','click',function (e) {   
        $(".form-control").val('');
        vector_datos_actividades.length=0;
		vector_acompañantes.length=0;
     }); 


	
*/


});