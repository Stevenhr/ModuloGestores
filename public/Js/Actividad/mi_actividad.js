$(function()
{
    var URL = $('#main_mis_actividad').data('url');
   var t =  $('#example').DataTable({
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
        $("#espera_3_"+id).html("<img src='public/Img/loading.gif'/>");
        $.get(
            URL+'/service/obtener/'+id,
            {},
            function(data)
            {   
                if(data)
                {
                    actividad_datos(data);
                    $("#espera_3_"+id).html("");
                }
            },
            'json'
        );

    }); 

    $('select[name="Parque"]').on('change', function(e){
        var act=$('select[name="Parque"]').val();
        if(act=='Otro'){
            $('.div_otro_parque').show(100);
        }
        else{
            $('.div_otro_parque').hide(100);
            $('input[name="otro_Parque"]').val("");
        }
    
    });

    var actividad_datos = function(datos)
    {
        //console.log(datos);
        $("#titulo_id").text(datos.datosActividad['Id_Actividad_Gestor']);
        $('input[name="Id_Actividad"]').val(datos.datosActividad['Id_Actividad_Gestor']);
        $('select[name="Id_Localidad"]').val(datos.datosActividad['Localidad']);
        $('select[name="Id_Responsable"]').val(datos.datosActividad['Id_Responsable']);
        $('input[name="Hora_Inicio"]').val(datos.datosActividad['Hora_Incial']);
        $('input[name="Hora_Fin"]').val(datos.datosActividad['Hora_Final']);
        $('input[name="Fecha_Ejecucion"]').val(datos.datosActividad['Fecha_Ejecucion']);
        if(datos.datosActividad['Parque']==0){$parque="Otro"}else{$parque=datos.datosActividad['Parque'];}
        $('select[name="Parque"]').selectpicker('val',$parque);
        $('input[name="otro_Parque"]').val(datos.datosActividad['Otro']);
        $('input[name="Caracteristica_Lugar"]').val(datos.datosActividad['Caracteristica_Lugar']);
        $('textarea[name="Caracteristica_poblacion"]').val(datos.datosActividad['Caracteristica_Poblacion']);
        $('textarea[name="Caracteristica_Lugar"]').val(datos.datosActividad['Caracteristica_Lugar']);
        $('input[name="Institucion_Grupo"]').val(datos.datosActividad['Instit_Grupo_Comun']);
        $('input[name="Numero_Asistentes"]').val(datos.datosActividad['Numero_Asistente']);
        $('input[name="Hora_Implementacion"]').val(datos.datosActividad['Hora_Implementacion']);
        $('input[name="Persona_Contacto"]').val(datos.datosActividad['Nombre_Contacto']);
        $('input[name="Roll_Comunidad"]').val(datos.datosActividad['Rool_Comunidad']);
        $('input[name="Telefono"]').val(datos.datosActividad['Telefono']);

        var f = new Date();
        var fechaActual = new Date(f.getFullYear()+ "," + (f.getMonth() +1) + "," + f.getDate());
        var tmp = datos.datosActividad['Fecha_Ejecucion'].split('-');
        var F_ejecucion = new Date(tmp[0]+ "," + tmp[1]+ "," + tmp[2]);


        if(datos.datosActividad['Estado']==2 || F_ejecucion<fechaActual){
            $("#Modificar_Act").hide();
            //$( "#Cerrar_Act" ).removeClass( "btn btn-default" ).addClass( "btn btn-success" );
        }else{
            $("#Modificar_Act").show();
            //$( "#Cerrar_Act" ).removeClass( "btn btn-success" ).addClass( "btn btn-default" );
        }

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

    $('#Cerrar_modal').on('click', function(e){
      
               $('#modal_form_actividades').modal('hide');

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


        
        $('#Modificar_Act').on('click', function(e){
            var num=1;
                $.post(
                    URL+'/service/ModificarActividad',
                    $("#form_actividad_m").serialize(),
                    function(data){
                            if(data.status == 'error')
                            {
                                validador_errores(data.errors);
                            } else {
                                $("#espera_3").html("<img src='public/Img/loading.gif'/>");
                                $('#form_actividad_mm .form-group').removeClass('has-error');
                                $('#mensajeModifica').html('<div class="alert alert-dismissible alert-success" ><strong>Exito!</strong> Dato modificado de la actividad con exito. </div>');
                                $('#modalMensaj').modal('show');
                                setTimeout(function(){
                                    $('#modal_form_actividades').modal('hide');
                                    $('#modalMensaj').modal('hide');
                                }, 3000)      

                                        $.get(
                                            URL+'/MisProgramaciones',
                                            {},
                                            function(data)
                                            {   
                                                var Nomparque="";
                                                var clase="";
                                                t.clear().draw();
                                                $.each(data,  function(i, e){
                                                        //console.log(e);
                                                        if(e.parque==null){  //No hay informacion
                                                            Nomparque="Otro: "+e['Otro'];
                                                        }else{
                                                            Nomparque=e.parque['Nombre'];
                                                        }
                                                            var f = new Date();
                                                            var fechaActual = new Date(f.getFullYear()+ "," + (f.getMonth() +1) + "," + f.getDate());
                                                            var tmp = e['Fecha_Ejecucion'].split('-');
                                                            var F_ejecucion = new Date(tmp[0]+ "," + tmp[1]+ "," + tmp[2]);


                                                        if(e['Estado']==2 || F_ejecucion<fechaActual){  //No hay informacion
                                                            clase="btn btn-default";
                                                        }else{
                                                            clase="btn btn-success";
                                                        }

                                                        t.row.add( [
                                                            '<th scope="row" class="text-center">'+num+'</th>',
                                                            '<td class="text-center"><h4>'+e['Id_Actividad_Gestor']+'<h4></td>',
                                                            '<td>'+e.persona['Primer_Apellido']+' '+e.persona['Segundo_Apellido']+' '+e.persona['Primer_Nombre']+' '+e.persona['Segundo_Nombre']+'</td>',
                                                            '<td>'+e['Fecha_Ejecucion']+'</td>',
                                                            '<td>'+e.localidad['Nombre_Localidad']+'</td>',
                                                            '<td>'+e['Hora_Incial']+'</td>',
                                                            '<td>'+Nomparque+'</td>',
                                                            '<td style="text-align:center"><center><button type="button" data-rel="'+e['Id_Actividad_Gestor']+'" data-funcion="ver" class="'+clase+' eliminar_dato_actividad">Ver</button><div id="espera_3_'+e['Id_Actividad_Gestor']+'"></div></td>',
                                                        ] ).draw( false );
                                                        num++;
                                                    });
                                            },
                                            'json'
                                        );   
                                        $("#espera_3").html("");     
                            }
                    },
                    'json'
                );

        e.preventDefault();
        return false;
        });

        $('#Cerrar_Act').on('click', function(e){
                $('#modal_form_actividades').modal('hide');
                e.preventDefault();
        });


         


});





