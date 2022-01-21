var AppReportesIncidente = function () {
	
	var init = function () {
		fs_grafico({grafico: 'incidente_x_tipo'});
		fs_grafico({grafico: 'incidente_x_dia'});
		fs_grafico({grafico: 'incidente_x_hora'});
		fs_grafico({grafico: 'incidente_x_sector'});
	}
	
	var fs_grafico = function (obj) {
		var data = {
			class   : 'GraficoController',
			method  : 'findById',
			grafico : obj.grafico
		};
		
		$.getJSON(path_ws, data, function(response) {
			var response = JSON.parse(response);
			
			if($('#' + obj.grafico).length > 0){
				response.plotOptions = {
					series: {
						cursor: 'pointer',
						events: {
							click: function (event) {
								alert(
									this.name + ' clicked\n' +
									'Alt: ' + event.altKey + '\n' +
									'Control: ' + event.ctrlKey + '\n' +
									'Meta: ' + event.metaKey + '\n' +
									'Shift: ' + event.shiftKey
								);
							}
						}
					}
				};
				
				Highcharts.chart(obj.grafico, response);
			}
		});
	}
	
	return {
		init: function () {
			return init();
		}
	}	
} ();