var AppAgruparIncidente = function () {	
	var m_agr_incidencia;
	var btnAgrInc;
	
	var initVars = function () {		
		m_agr_incidencia  = $('#m_agr_incidencia');
		btnAgrInc = $('[name="btnAgrInc"]');
	}
	
	var init = function () {
		initVars();
		jQueryEvts();
	}
	
	var jQueryEvts = function () {
		btnAgrInc.click(function() {
			fu_agrupar();
		});
	}
	
	var fu_agrupar = function (data) {		
		$.ajax({
			url:  path_ws,
			type: 'post',
			dataType : 'json',
			data: {
				'class'  : 'IncidenteController',
				'method' : 'agrupar'
			},
			success: function (response) {			
				var str  = [];
				var data = Object.values(response);
				
				for(key in data) {
					if(data.hasOwnProperty(key)) {
						var value = data[key];
						str.push(
							'tr[data-id="' + value + '"]'
						);
					}
				}
			
				$('[name="chkSel[]"]').prop('checked', false);
				$('[name="btnAgrupar"] span').text(0);
				
				$(str.join(',')).remove();
				
				App.toaster('Notificación de actualización', 'Incidentes agrupados', 'success');
				
				m_agr_incidencia.modal('hide');		
			}
		});
	}
	
	return {				
		init: function () {
			return init();
		}
	}	
} ();