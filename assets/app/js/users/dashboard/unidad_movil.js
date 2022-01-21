var AppEditUndMov = function () {	
	var m_adj_unidad;
	
	var initVars = function () {
		m_adj_unidad  = $('#m_adj_unidad');
	}
		
	var init = function () {
		initVars();
		jQueryEvts();
	}
	
	var jQueryEvts = function () {
		$('[role="form"]').validator().on('submit', function (e) {
			if (!e.isDefaultPrevented()) {				
				fu_und_movil();				
			}			
			return false;
		});
	}
	
	var fu_und_movil = function () {
		var data 	= App.arrayToForm($("#frmEditarUM").serializeArray());
		data.class  = 'UndApoyoController';
		data.method = 'createOrUpdate';
		
		$.ajax({
			url:  path_ws,
			type: 'post',
			dataType : 'json',
			data: data,
			success: function (response) {
				console.log(response);
				$.post("incidentes.php", { txtNroCaso: data.txtIncidenteId }, function(html) {					
					$('#tblIncidencias tr[data-id="' + data.txtIncidenteId + '"]').replaceWith(html);
				}).done(function() {
					App.toaster('Notificación de actualización', 'Unidad de apoyo actualizada', 'success');
					m_adj_unidad.modal('hide');
				});
			}
		});
	}
	
	return {				
		init: function () {
			return init();
		}
	}	
} ();