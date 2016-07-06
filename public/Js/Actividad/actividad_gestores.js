$(function()
{
	var URL = $('#mis_actividad_gestores').data('url');

	$('#form_actividad_gestor').on('submit', function(e){

				$.post(
					URL+'/service/misActividadesGestor',
					$(this).serialize(),
					function(data){
							if(data.status == 'error')
							{
								validador_errores_form(data.errors);
							} else {
								if(data.length > 0)
								{
									
									var num=1;
									var html="";
									$.each(data, function(i, e){
										console.log(e['Id_Responsable']);
										html += '<tr><th scope="row" class="text-center">'+num+'</th><td>'+e['Id_Actividad_Gestor']+'</td><td>'+e['Id_Responsable']+'</td><td>'+e['Fecha_Ejecucion']+'</td><td>'+e->localidad['Nombre_Localidad']+'</td><td>'+e['Hora_Incial']+'</td><td>'+e['Parque']+'</td><td class="text-center"><button type="button" data-rel="'+i+'" data-funcion="crear" class="eliminar_dato_actividad"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
										num++;
									});
								}
								$('#registros_actividades_responsable').html(html);
							}
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


	function ajaxRenderSection(url) {
		alert(url);
        $.ajax({
            type: 'POST',
            url: url,
            success: function (data) {

                $('#cont_act').empty().append($(data)); 
            },
            error: function (data) {
                var errors = data.responseJSON;
                if (errors) {
                    $.each(errors, function (i) {
                        console.log(errors[i]);
                    });
                }
            }
        });
    }


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