var AppIndexCamaras = function () {	
	var m_reg_usuario = $('#m_reg_usuario');
	
	var init = function () {		
		jQueryEvts();
	}
	
	var jQueryEvts = function () {
		$(document).on('click', '[name="btnActCamara"]', function(e){
			var r = confirm("¿Está seguro de actualizar los datos?");
			if (r == true) {
				fu_camara();
			}			
		});
		
		$(document).on('change', '[name="txtURLCamara[]"]', function(e){
			var item = $(this);
			
			item.closest('tr').attr('data-update', 'S');		
		});
	}
	var fu_camara = function (obj) {
		var arr = [];
		
		$('#tblCamaras tbody tr[data-update="S"]').each(function(index, tr) { 
			var row   = $(tr),
			camara_id = parseInt(row.attr('data-id')),
            wave_id   = row.find('input[name="txtURLCamara[]"]').val();
			
			arr.push(
				{camara_id : camara_id, wave_id : wave_id}				
			);
		});
		
		$.ajax({
			url:  path_ws,
			type: 'post',
			dataType : 'json',
			data: {
				class   : 'CamaraController',
				method  : 'update',
				camaras : arr 
			},
			success: function (response) {				
				console.log(response);
			}
		});
	}
	
	return {				
		init: function () {
			return init();
		}
	}	
} ();