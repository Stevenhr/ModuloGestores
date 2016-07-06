$(function()
{
    var URL = $('#main_mis_actividad').data('url');
    $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    });

	$('#example').delegate('button[data-funcion="ver"]','click',function (e) {  
        var id = $(this).data('rel'); 
        $.get(
            URL+'/service/obtener/'+id,
            {},
            function(data)
            {   
                if(data)
                {
                    actividad_datos(data);
                }
            },
            'json'
        );

    }); 

    var actividad_datos = function(datos)
    {
        //console.log(datos);
        $('input[name="Id_Actividad"]').val(datos.datosActividad['Id_Actividad_Gestor']);
        $('select[name="Id_Localidad"]').val(datos.datosActividad['Localidad']);
        $('select[name="Id_Responsable"]').val(datos.datosActividad['Id_Responsable']);
        $('input[name="Hora_Inicio"]').val(datos.datosActividad['Hora_Incial']);
        $('input[name="Hora_Fin"]').val(datos.datosActividad['Hora_Final']);
        $('input[name="Fecha_Ejecucion"]').val(datos.datosActividad['Fecha_Ejecucion']);
        $('select[name="Parque"]').selectpicker('val',datos.datosActividad['Parque']);
        $('input[name="Caracteristica_Lugar"]').val(datos.datosActividad['Caracteristica_Lugar']);
        document.form_actividad_m.Caracteristica_poblacion.value = datos.datosActividad['Caracteristica_Poblacion'];
        document.form_actividad_m.Caracteristica_Lugar.value = datos.datosActividad['Caracteristica_Lugar'];
        $('input[name="Institucion_Grupo"]').val(datos.datosActividad['Instit_Grupo_Comun']);
        $('input[name="Numero_Asistentes"]').val(datos.datosActividad['Numero_Asistente']);
        $('input[name="Hora_Implementacion"]').val(datos.datosActividad['Hora_Implementacion']);
        $('input[name="Persona_Contacto"]').val(datos.datosActividad['Nombre_Contacto']);
        $('input[name="Roll_Comunidad"]').val(datos.datosActividad['Rool_Comunidad']);
        $('input[name="Telefono"]').val(datos.datosActividad['Telefono']);

        $('#modal_form_actividades').modal('show');
    };



    $('#form_actividad_m').on('submit', function(e){
      
                $.post(
                    URL+'/service/crearActividad',
                    $(this).serialize(),
                    function(data){
                        
                            if(data.status == 'error')
                            {
                                validador_errores(data.errors);
                            } else {
                                $('#actividad_modificada').modal('show');
                                
                            }
                    },
                    'json'
                );

        e.preventDefault();
    });



    var validador_errores = function(data)
    {
        $('#form_actividad .form-group').removeClass('has-error');
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
                $('#form_actividad_m '+selector+'[name="'+error+'"]').closest('.form-group').addClass('has-error');
            }
        }
    }




        $('#datetimepicker1_m').datetimepicker({
                      format: 'HH:mm'
                });
        $('#datetimepicker2_m').datetimepicker({
                      format: 'HH:mm'
                });
        $('#datetimepicker3_m').datetimepicker({
                      format: 'HH:mm'
                });


});





