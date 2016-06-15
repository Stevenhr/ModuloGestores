$(function()
{
	var URL = $('#main_actividad').data('url');
	var $personas_actuales = $('#personas').html();

	var reset = function(e)
	{
		$('input[name="buscador"]').val('');
		$('#buscar span').removeClass('glyphicon-remove').addClass('glyphicon-search');
		$('#personas').html($personas_actuales);
		$('#paginador').fadeIn();
	};

	var buscar = function(e)
	{
		var key = $('input[name="buscador"]').val();
		if (key.length > 2)
		{
			$('#buscar span').removeClass('glyphicon-search').addClass('glyphicon-remove');
			$('#buscar').data('role', 'reset');

			$.get(
				URL+'/service/buscar/'+key,
				{}, 
				function(data)
				{
					if(data.length > 0)
					{
						var html = '';
						$.each(data, function(i, e){
							html += '<li class="list-group-item">'+
						                '<h5 class="list-group-item-heading">'+
						                    ''+e['Primer_Apellido'].toUpperCase()+' '+e['Segundo_Apellido'].toUpperCase()+' '+e['Primer_Nombre'].toUpperCase()+' '+e['Segundo_Nombre'].toUpperCase()+''+
						                    '<a data-role="editar" data-rel="'+e['Id_Persona']+'" class="pull-right btn btn-primary btn-xs">'+
						                    	'<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'+
						                    '</a>'+
						                '</h5>'+
						                '<p class="list-group-item-text">'+
						                    '<div class="row">'+
						                        '<div class="col-xs-12">'+
						                            '<div class="row">'+
						                                '<div class="col-xs-12 col-sm-6 col-md-3"><small>Identificación: '+e.tipo_documento['Nombre_TipoDocumento']+' '+e['Cedula']+'</small></div>'+
						                            '</div>'+
						                        '</div>'+
						                    '</div>'+
						                '</p>'+
						            '</li>';
						});
						$('#personas').html(html);
						$('#paginador').fadeOut();
					}
				},
				'json'
			)
		} else if(key.length == 0){
			reset(e);
		}
	};

	

	var popular_modal_persona = function(persona)
	{
		$('select[name="Id_TipoDocumento"]').val(persona['Id_TipoDocumento']);
		$('input[name="Cedula"]').val($.trim(persona['Cedula']));
		$('input[name="Primer_Apellido"]').val($.trim(persona['Primer_Apellido']));
		$('input[name="Segundo_Apellido"]').val(persona['Segundo_Apellido']);
		$('input[name="Primer_Nombre"]').val($.trim(persona['Primer_Nombre']));
		$('input[name="Segundo_Nombre"]').val($.trim(persona['Segundo_Nombre']));
		$('input[name="Fecha_Nacimiento"]').val($.trim(persona['Fecha_Nacimiento']));
		$('select[name="Id_Etnia"]').val(persona['Id_Etnia']);
		$('select[name="Nombre_Ciudad"]').data('value', persona['Nombre_Ciudad']);
		$('select[name="Id_Pais"]').val(persona['Id_Pais']).trigger('change');
		$('input[name="Id_Persona"]').val(persona['Id_Persona']);

		$('input[name="Id_Genero"]').removeAttr('checked').parent('.btn').removeClass('active');
		$('input[name="Id_Genero"][value="'+persona['Id_Genero']+'"]').trigger('click');

		$('#modal_form_persona').modal('show');
	};

	var popular_errores_modal = function(data)
	{
		$('#form_persona .form-group').removeClass('has-error');
		var selector = '';
		for (var error in data){
		    if (typeof data[error] !== 'function') {
		        switch(error)
		        {
		        	case 'tipoDocumento':
		        	case 'Id_Etnia':
		        	case 'Id_Pais':
		        		selector = 'select';
		        	break;

		        	case 'Cedula':
		        	case 'Primer_Apellido':
		        	case 'Primer_Nombre':
		        	case 'Fecha_Nacimiento':
		        	case 'Id_Genero':
		        		selector = 'input';
		        	break;
		        }
		        $('#form_persona '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
		    }
		}
	}

	//Eventos
	$('input[name="buscador"]').on('keyup', function(e){
		var code = e.which; //http://stackoverflow.com/questions/3462995/jquery-keydown-keypress-keyup-enterkey-detection
    	if(code==13)
    		buscar(e);
	});

	$('#buscar').on('click', function(e)
	{
		var role = $(this).data('role');
		switch(role)
		{
			case 'buscar':
				$(this).data('role', 'reset');
				buscar(e);
			break;

			case 'reset':
				$(this).data('role', 'buscar');
				reset(e);
			break;
		}
	});

	$('#crear').on('click', function(e)
	{
		var persona = {
			Id_TipoDocumento: '',
			Cedula: '',
			Primer_Apellido: '',
			Segundo_Apellido: '',
			Primer_Nombre: '',
			Segundo_Nombre: '',
			Fecha_Nacimiento: '',
			Id_Etnia: '',
			Id_Pais: 41,
			Nombre_Ciudad: '',
			Id_Persona: 0,
			Id_Genero: 0
		}

		popular_modal_persona(persona);
	});

	$('#personas').delegate('a[data-role="editar"]', 'click', function(e){
		var id = $(this).data('rel');
		$.get(
			URL+'/service/obtener/'+id,
			{},
			function(data)
			{	
				if(data)
				{
					popular_modal_persona(data);
				}
			},
			'json'
		);
	});

	$('#personas').delegate('a[data-role="remover"]', 'click', function(e){
		var id = $(this).data('rel');
	});

	$('select[name="Id_Eje"]').on('change', function(e){
		select_tematicas($(this).val());
	});
	$('select[name="Id_Tematica"]').on('change', function(e){
		select_actividades($(this).val());
	});

	//Submit formulario único de personas
	$('#form_persona input[name="Cedula"]').on('blur', function(e){
		var key = $(this).val();
		$.get(
			URL+'/service/buscar/'+key,
			{}, 
			function(data)
			{
				if(data.length == 1)
				{
					popular_modal_persona(data[0]);
				}
			}
		);
	});

	$('#form_persona').on('submit', function(e){
		$.post(
			URL+'/service/procesar',
			$(this).serialize(),
			function(data){
				if(data.status == 'error')
				{
					popular_errores_modal(data.errors);
				} else {
					$('#alerta').show();
					$('#modal_form_persona').modal('hide');

					setTimeout(function(){
						$('#alerta').hide();
					}, 4000)
				}
			},
			'json'
		);

		e.preventDefault();
	});





	//JQUERY ACTIVIDAD

vector_datos_actividades = new Array();
	
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

            console.log(vector_datos_actividades);
			return false;
		
	});

	$('#ver_datos_actividad').on('click', function(e)
	{
			
			var html = '';
					if(vector_datos_actividades.length > 0)
					{
						var num=1;
						$.each(vector_datos_actividades, function(i, e){
							html += '<tr><th scope="row" class="text-center">'+num+'</th><td>'+Buscar_Eje(e['id_eje'])+'</td><td>'+Buscar_Tematica(e['id_tematica'])+'</td><td>'+Buscar_Actividad(e['id_act'])+'</td><td class="text-center"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td></tr>';
							num++;
						});
					}
					$('#registros').html(html);

			$('#ver_registros').modal('show');
			return false;
		
	});

	$('#asignar_acompañante').on('click', function(e)
	{
			var html = '';
			var id=46;

			$.get(
				URL+'/service/persona_tipo/'+id,
				{},
				function(data)
				{	
						
						if(data.length > 0)
						{
							var html = '';
							$.each(data, function(i, e){
								html += '<tr><th scope="row">'+e['Primer_Apellido']+' '+e['Primer_Nombre']+' '+e['Segundo_Apellido']+' '+e['Segundo_Apellido']+'</th><td> <div class="checkbox text-center"><label ><input type="checkbox"></label></div></td><td class="text-center"><span class="glyphicon glyphicon-calendar " aria-hidden="true"></span></td></tr>';
							});
							$('#div_acompañante').html(html);
						}
						$('#ver_acompañante').modal('show');
					
				},
				'json'
			);
			return false;		
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
                     format: 'LT'
                });
		$('#datetimepicker2').datetimepicker({
                     format: 'LT'
                });
		$('#datetimepicker3').datetimepicker({
                     format: 'LT'
                });


});