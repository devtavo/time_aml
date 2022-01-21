var AppSectores = function () {
	var init = function () {		
		initMap();
		initToolBar();
		fs_sector();		
	}
	
	var initMap = function () {
		map = L.map('map',{
			center: [-7.051830774037793, -78.57559204101564],
			zoom: 12,
			zoomControl: false,
			attributionControl: false
		});
		
		L.geoJSON(cajamarca, {
			style: {
				fillColor: '#3388ff',
				weight: 2,
				opacity: 1,
				color: '#3388ff',
				fillOpacity: 0.2
			},
			pmIgnore : true
		}).addTo(map);
		
		L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
			attribution: '&amp;copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(map);
	}
	
	var initToolBar = function () {		
		drawnItems = new L.FeatureGroup();
		map.addLayer(drawnItems);
		
		map.pm.addControls({
			position: 'topleft',
			drawCircle: true
		});
		
		map.pm.setLang('es');
		
		map.on('pm:create', e => {
			console.log(e.layer.toGeoJSON());
			/*drawnItems.addLayer(e.layer);
			fi_sector();*/
		});
		
		map.on('pm:remove', e => {
			console.log(e.layer);
			/*drawnItems.removeLayer(e.layer);			
			fi_sector();*/
		});
		
		drawnItems.on('pm:edit', e => {
			console.log(e);
			/*fi_sector();*/
		});
		
		drawnItems.on('click', function(e){
			if(!map.pm.globalDragModeEnabled()){
				var lyr = e.layer;
				console.log(lyr);
				$.get("create.php", {}, function(response) {					
					lyr.bindPopup(response, { minWidth : 300 });
					lyr.openPopup();
					$('.colorpicker-component').colorpicker();					
				});
			}			
		});
	}
	
	var fi_sector = function () {	
		var data 	 = {};
		data.method	 = 'fi_sector';
		data.geojson = drawnItems.toGeoJSON();
		
		$.ajax({
			url:  '../../php/ws.php',
			type: 'post',
			dataType : 'json',
			data: data,
			success: function (response) {				
				console.log(response);
			}
		});
	}
	
	var fs_sector = function (e) {	
		var obj = { method : 'fs_sector', geoJson : true };
		
		$.getJSON('../../php/ws.php', obj, function(data) {
			$.each(data, function(key, feature) {				
				if('features' in JSON.parse(feature.geo_json)){					
					L.geoJSON(JSON.parse(feature.geo_json),{ pmIgnore : false }).eachLayer(function(l){
						drawnItems.addLayer(l);
					});
				}
			});
		});
	}
	
	function createUUID() {
		return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
			var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
			return v.toString(16);
		});
	}
	
	return {
		init: function () {
			return init();
		}
	}	
} ();