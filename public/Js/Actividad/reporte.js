$(function()
{
	var URL = $('#reporte').data('url');

	$('#form_reporte').on('submit', function(e){
			$("#contenido_reporte").html("<img src='public/Img/loading.gif'/>");
				
				$.post(
                    URL+'/reporteTipoPoblacional',
                    $(this).serialize(),
                    function(data){
                        $('#contenido_reporte').html(data);
                        $('#Tabla_Reporte').DataTable({
					        dom: 'Bfrtip',
					        buttons: [
					            'copyHtml5',
					            'excelHtml5',
					            'csvHtml5',
					            'pdfHtml5'
					        ]
					    });
                    }
                );

        e.preventDefault();
	});



});