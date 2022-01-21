var lyrGroupIncidentes = new L.layerGroup();
var lyrGroupSectores   = new L.layerGroup();
var lyrHeatIncidentes  = new L.layerGroup();
var arrSectQuintil = {}; //new Array();
var arrIncSectores = new Array();
var rango_fecha    = $('input[name="txtFecRegistro"]');
var fecha_inicio   = moment().subtract(29, 'days');
var fecha_final    = moment();

var AppMapaAnalista = function () {
	
	var init = function () {		
		rango_fecha.daterangepicker({
			"locale": drp_es,
			startDate: fecha_inicio,
			endDate: fecha_final,
			ranges: {
				'Hoy' :  [moment(), moment()],
				'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Últimos 7 días':  [moment().subtract(6, 'days'), moment()],
				'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
				'Mes actual':      [moment().startOf('month'), moment().endOf('month')],
				'Mes anterior':    [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			}
		});
		
		var topoLayer  = new L.TopoJSON(null, { 
			style: {
				fillColor : 'transparent',
				fillOpacity: 0.5,
				color:'#000000',
				weight:2,
				opacity:.8
			},
			onEachFeature: onEachFeature
		});
		
		$.getJSON('../../assets/app/json/sectores.topojson', function(data)  {
			topoLayer.addData(data);
			topoLayer.addTo(lyrGroupSectores);
			
			lyrGroupSectores.eachLayer(function(layer) {
				layer.eachLayer(function(lyr) {
					arrSectQuintil[lyr.feature.properties.OBJECTID] = lyr;
					/*console.log(lyr.feature.properties.OBJECTID);
					console.log(lyr._leaflet_id);*/
				});
			});
		});
		
		initMap();
		initTitle();
		initLegend();
		initSideBar();
		initButtons();		
		initPanelLayers();
		initChart();		
		initCluster();
	}
	
	
	
	var initMap = function () {
		map = L.map('map',{			
			center: [-7.164883, -78.510399],
			zoom: 14,
			zoomControl: false,
			attributionControl: false,
			minZoom: 12
		});
		
		L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
			attribution: '&amp;copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(map);
		
		lyrGroupIncidentes.addTo(map);		
	}
	
	var initTitle = function () {
		var title = L.control({position: 'topcenter'});
		
		title.onAdd = function (map) {

		var div = L.DomUtil.create('div', 'info title');
			var str = 'XXX'
  
			div.innerHTML = str;
			
			return div;
		};

		title.addTo(map);
	}
	
	var initCluster = function () {
		var tmpCluster;
		
		for(var i = 1; i <= 24; i++){
			tmpCluster = new L.MarkerClusterGroup();
			
			lyrGroupIncidentes.addLayer(
				tmpCluster
			);
			
			arrIncSectores.push(
				tmpCluster
			);
		}
	}
	
	var initLogo = function () {
		L.Control.Watermark = L.Control.extend({
			onAdd: function(map) {
				var img = L.DomUtil.create('img');
				
				img.id  = 'logo';
				img.src = '../../assets/app/img/logo_mapa.png';
				img.style.width = '220px';

				return img;
			},
			onRemove: function(map) {}
		});

		L.control.watermark = function(opts) {
			return new L.Control.Watermark(opts);
		}
		
		L.control.watermark({position: 'topleft'}).addTo(map);
	}
	
	var initLegend = function () {
		var legend = L.control({position: 'bottomleft'});
		
		legend.onAdd = function (map) {

		var div = L.DomUtil.create('div', 'info legend');
			var str = '<p><b>Leyenda</b></p>';
			str+= '<table id="legend" class="table" width="100%" border="0">';
				str+= '<tr>';
					str+= '<td><img src="../../assets/app/img/accidentes.png" width="20"/></td>';
					str+= '<td>Accidentes</td>';
				str+= '</tr>';
				str+= '<tr>';
					str+= '<td><img src="../../assets/app/img/apoyo_seguridad.png" width="20"/></td>';
					str+= '<td>Apoyo de Seguridad</td>';
				str+= '</tr>';
				str+= '<tr>';
					str+= '<td><img src="../../assets/app/img/delito.png" width="20"/></td>';
					str+= '<td>Delito</td>';
				str+= '</tr>';
				str+= '<tr>';
					str+= '<td><img src="../../assets/app/img/falta.png" width="20"/></td>';
					str+= '<td>Falta</td>';
				str+= '</tr>';
				str+= '<tr>';
					str+= '<td><img src="../../assets/app/img/queja.png" width="20"/></td>';
					str+= '<td>Queja</td>';
				str+= '</tr>';
			str+= '</table>';
  
			div.innerHTML = str;
			
			return div;
		};

		legend.addTo(map);
	}
	
	var initSideBar = function () {
		sidebar = L.control.sidebar('sidebar', {
			closeButton: true,
			position: 'left',
			autoPan: false
		});
		
		map.addControl(sidebar);
		
		sidebar2 = L.control.sidebar('sidebar2', {
			closeButton: true,
			position: 'right',
			autoPan: false
		});
		
		map.addControl(sidebar2);
		
		$('a.close').appendTo("#sidebar > .panel > .panel-heading, #sidebar2 > .panel > .panel-heading");
		$('#sidebar2 .close').click(function() { sidebar2.toggle(); });
		
		$('[data-toggle="collapse"]').on('click',function(e){
			e.preventDefault();
			
			var id = $(this).attr('href');
			
			if($(id).hasClass('in')){
				$(id).collapse('hide');
			}else{
				$(id).collapse('show');
			}
		});
		
		$('[name="btnFiltrar"]').click(function() {
			var clasificacion = $('[name="ddlClasificInc"]').val();			
			var fec_registro  = $('[name="txtFecRegistro"]').val();
			
			/*fs_incidentes({
				'ddlClasificacion' : clasificacion,
				'txtFecRegistro'   : fec_registro
			});
			
			fs_heatmap({
				'ddlClasificacion' : clasificacion,
				'txtFecRegistro'   : fec_registro
			});*/
			
			fs_sectores({
				'ddlClasificacion' : clasificacion,
				'txtFecRegistro'   : fec_registro,
				'txtBusqueda'      : true
			});
			
			/*fs_grafico({
				grafico: 'incidente_x_tipo', 
				txtFecRegistro : fec_registro,
				ddlClasificacion : clasificacion
			});
			
			fs_grafico({
				grafico: 'incidente_x_dia', 
				txtFecRegistro : fec_registro,
				ddlClasificacion : clasificacion
			});
			
			fs_grafico({
				grafico: 'incidente_x_hora', 
				txtFecRegistro : fec_registro,
				ddlClasificacion : clasificacion
			});
			
			fs_grafico({
				grafico: 'incidente_x_sector', 
				txtFecRegistro : fec_registro,
				ddlClasificacion : clasificacion
			});*/
		});
	}
	
	var initButtons = function () {
		L.easyButton({
			id: 'btnMain', 
			position: 'topleft',
			type: 'replace',			
			leafletClasses: true,
			states:[{
				stateName: 'get-center',
				onClick: function(button, map){
					sidebar.toggle();
				},
				title: 'Filtros',
				icon: 'glyphicon-menu-hamburger'
			}]
		}).addTo(map);
		
		L.easyButton({
			id: 'btnChart', 
			position: 'topleft',
			type: 'replace',			
			leafletClasses: true,
			states:[{
				stateName: 'get-center',
				onClick: function(button, map){					
					sidebar2.toggle();
				},
				title: 'Gráficos',
				icon: 'fa-line-chart'
			}]
		}).addTo(map);
		
		L.easyButton({
			id: 'btnHome', 
			position: 'topleft',
			type: 'replace',
			leafletClasses: true,
			states:[{
				stateName: 'get-center',
				onClick: function(button, map){					
					map.setView([-7.164883, -78.510399], 14);
				},
				title: 'Inicio',
				icon: 'glyphicon-home'
		  }]
		}).addTo(map);
		
		L.easyButton({
			id: 'btnLayers', 
			position: 'topleft',
			type: 'replace',
			leafletClasses: true,
			states:[{
				stateName: 'get-center',
				onClick: function(button, map){					
					map.setZoom(map.getZoom() + 1);
				},
				title: 'Acercar',
				icon: 'glyphicon glyphicon-plus'
		  }]
		}).addTo(map);
		
		L.easyButton({
			id: 'btnLayers', 
			position: 'topleft',
			type: 'replace',
			leafletClasses: true,
			states:[{
				stateName: 'get-center',
				onClick: function(button, map){					
					map.setZoom(map.getZoom() - 1);
				},
				title: 'Alejar',
				icon: 'glyphicon glyphicon-minus'
		  }]
		}).addTo(map);
	}
	
	function onEachFeature(feature, layer) {
		layer.bindTooltip("S" + feature.properties.OBJECTID, {permanent:true, direction:'center', className: 'sectorizacion'});
		//layer.bindPopup("Cargando...", { closeButton: true, minWidth: 500 });
		
		layer.on('click', function(e) {			
			//layer._popup.setContent('AJAX');
		});	
    }
	
	function styleX(feature) {		
		return {
			fillColor : getColor(feature.properties.OBJECTID),
			fillOpacity: 0.5,
			color:'#000000',
			weight:2,
			opacity:.3
		};
	}
	
	function getColor(quantil) {		
		switch(quantil){
			case 5:
				return '#FF0000';
			break;
			case 4:
				return '#FFA500';
			break;
			case 3:
				return '#FFFF00';
			break;
			case 2:
				return '#93C572';
			break;
			case 1:
				return '#008F39';
			break;
			default:
				return 'transparent'
		}
	}
	
	var initPanelLayers = function () {
		
		/*var topoLayer  = new L.TopoJSON(null, { 
			style: {
				fillColor : 'transparent',
				fillOpacity: 0.5,
				color:'#000000',
				weight:2,
				opacity:.8
			},
			onEachFeature: onEachFeature
		}).addTo(map);
		
		$.getJSON('../../assets/app/json/sectores.topojson', function(data)  {							
			topoLayer.addData(data);				
		});*/
		
		var baseLayers = [
			{
				active: true,
				name: "Sector",
				layer: (function() {
					fs_sectores({
						'txtFecRegistro' : fecha_inicio.format('DD/MM/YYYY') + " - " + fecha_final.format('DD/MM/YYYY'), 'txtBusqueda': true
					});
					return lyrGroupSectores;
				}())
			},
			{
				active: false,
				name: "M. de calor",
				layer: (function() {					
					fs_heatmap({
						'txtFecRegistro' : fecha_inicio.format('DD/MM/YYYY') + " - " + fecha_final.format('DD/MM/YYYY')
					});
					return lyrHeatIncidentes;
				}())
			}			
		];
		
		var overLayers = [
			{
				active: true,
				name: "Incidentes",
				layer: (function() {					
					fs_incidentes({
						'txtFecRegistro' : fecha_inicio.format('DD/MM/YYYY') + " - " + fecha_final.format('DD/MM/YYYY')
					});					
					return lyrGroupIncidentes;
				}())
			},			
			{
				active: false,
				name: "C&aacute;maras",
				layer: (function() {
					var l   = L.geoJson();
					var obj = { class : 'CamaraController', method : 'index', geoJson: true };

					$.getJSON(path_ws, obj, function(data) {						
						data = L.geoJSON(JSON.parse(data), {
							style: function (feature) {
								return feature.properties && feature.properties.style;
							},
							pointToLayer: function (feature, latlng) {								
								var marker = L.marker(latlng,{
									title: 'Cámara ' + feature.properties.camara_id,
									icon: L.ExtraMarkers.icon({
										icon: 'fa-video-camera',
										shape: 'circle',
										markerColor: 'blue',
										prefix: 'fa',
										iconColor: feature.properties.wave_id.length == 0 ? 'red' : 'white'
									})
								});
						
								return marker;
							}
						}).addTo(l);
						
						data.on('click', function(e) {
							var obj  = e.layer.feature.properties;
							
							if(obj.wave_id.length > 0){
								$.get(path_root + "/users/camaras/show.php", { wave_id: obj.wave_id }, function(response) {
									dialog.setContent(response);
								});						
							}							
						});
					});
					
					return l;
				}())
			}
		];
		
		map.addControl(new L.Control.PanelLayers(baseLayers, overLayers,{
			title: 'Objetos del Mapa',
			position: 'topright',
			compact: true
		}));
	}
	
	var initChart = function (obj) {		
		fs_grafico({grafico: 'incidente_x_tipo', txtFecRegistro : fecha_inicio.format('DD/MM/YYYY') + " - " + fecha_final.format('DD/MM/YYYY')});
		fs_grafico({grafico: 'incidente_x_dia', txtFecRegistro : fecha_inicio.format('DD/MM/YYYY') + " - " + fecha_final.format('DD/MM/YYYY')});
		fs_grafico({grafico: 'incidente_x_hora', txtFecRegistro : fecha_inicio.format('DD/MM/YYYY') + " - " + fecha_final.format('DD/MM/YYYY')});
		fs_grafico({grafico: 'incidente_x_sector', txtFecRegistro : fecha_inicio.format('DD/MM/YYYY') + " - " + fecha_final.format('DD/MM/YYYY')});
	}
	
	var fs_incidentes = function (params = {}) {		
		var obj = { class : 'IncidenteController', method : 'index', geoJson : true, offset: false };
		
		if(Object.keys(params).length > 0){
			Object.assign(obj, params);			
		}
		
		for(var i=0; i<arrIncSectores.length; i++){
			arrIncSectores[i].clearLayers();
		}	

		$.getJSON(path_ws, obj, function(data) {			
			if(JSON.parse(data).features != null){
				for(var i = 1; i <= 24; i++){
					arrIncSectores[i-1].addLayer(
						L.geoJSON(JSON.parse(data), {
							filter: function(feature, layer) {						
								return feature.properties.sector_id == i;
							},
							pointToLayer: function (feature, latlng) {
								var marker = L.marker(latlng,{
									title: 'Incidente ' + feature.properties.incidente_id,
									icon: L.icon({
										iconUrl: '../../assets/app/img/' + feature.properties.icon,
										iconSize:     [24, 24],
										shadowSize:   [24, 24],
										iconAnchor:   [24, 24]
									})
								});
								
								marker.bindPopup("Cargando...", { closeButton: true, minWidth: 500 });
						
								return marker;
							}
						})
					);
					
					arrIncSectores[i-1].on('click', function(e) {
						var obj  = e.layer.feature.properties;
					
						$.get(path_root + "/users/incidentes/show.php", { incidente_id: obj.incidente_id }, function(response) {
							e.layer._popup.setContent(response);
						});
					});	
				}
			}
		});
	}
	
	var fs_sectores = function (params = {}) {
		var obj = { class : 'IncidenteController', method : 'sectorizacion' };
		
		if(Object.keys(params).length > 0){
			Object.assign(obj, params);
		}
		
		/*var topoLayer  = new L.TopoJSON(null, { 
			style: style,
			onEachFeature: onEachFeature
		});
		
		lyrGroupSectores.clearLayers();*/
		
		$.getJSON(path_ws, obj, function(data) {
			for (i = 0; i < data.length; i++) {				
				arrSectQuintil[parseInt(data[i].sector_id)].setStyle({
					fillColor: getColor(parseInt(data[i].quantil))
				});
			}
		
		
			//arrSectQuintil = JSON.parse(data);
			
			/*$.getJSON('../../assets/app/json/sectores.topojson', function(data)  {							
				topoLayer.addData(data);
				topoLayer.addTo(lyrGroupSectores);
			});*/
		});
	}
	
	var fs_heatmap = function (params = {}) {
		var tmp = [];
		var obj = { class : 'IncidenteController', method : 'heatMap' };
		
		if(Object.keys(params).length > 0){
			Object.assign(obj, params);			
		}
		
		lyrHeatIncidentes.clearLayers();
		
		$.getJSON(path_ws, obj, function(data) {			
			$.each(data, function(i, item) {							
				tmp.push([Number(item.latitud), Number(item.longitud), 0.15])							
			});
			
			L.heatLayer(tmp, {minOpacity : 0.5}).addTo(lyrHeatIncidentes);
		});
	}
	
	var fs_grafico = function (params) {		
		var obj = {
			class   : 'GraficoController',
			method  : 'findById'
		};
		
		if(Object.keys(params).length > 0){
			Object.assign(obj, params);			
		}
				
		$.getJSON(path_ws, obj, function(response) {
			var response = JSON.parse(response);
					
			if($('#' + obj.grafico).length > 0){
				response.plotOptions = {
					series: {
						cursor: 'pointer',
						events: {							
							click: function (event) {								
								fs_incidentes(
									JSON.parse(this.options.sql[event.point.x])
								);
								
								fs_heatmap(
									JSON.parse(this.options.sql[event.point.x])
								);
								
								fs_sectores(
									JSON.parse(this.options.sql[event.point.x])
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