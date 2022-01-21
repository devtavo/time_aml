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
				opacity: 0.5,
				color: '#3388ff',
				fillOpacity: 0.2
			}
		}).addTo(map);
		
		L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
			attribution: '&amp;copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(map);
	}
	
	var initToolBar = function () {
		drawnItems = new L.FeatureGroup();
		map.addLayer(drawnItems);
		
		options = {
			shapeOptions: {
				showArea: true,
				clickable: true
			},
			metric: true,
			edit: {
				featureGroup: drawnItems
			}
		};
			
		var drawControl = new L.Control.Draw(options);
		map.addControl(drawControl);
		
		map.on('draw:created', function(e) {
			var type = e.layerType,
			   layer = e.layer;
			drawnItems.addLayer(layer);
		});
		
		map.on('draw:editstop', function(e) {			
			fi_sector();
		});
		
		/*map.pm.addControls({
			position: 'topleft',
			drawCircle: false,
		});
		
		map.pm.setLang('es');
		
		map.on('pm:create', e => {
			fi_sector(e);
			
			e.layer.on('pm:edit', ({ layer }) => {
				console.log(layer);
			});
		});
		
		map.on('pm:remove', e => {
			alert("ELIMINAR");			
		});*/
	}
	
	var fi_sector = function (e) {	
		var data 	 = {};
		data.method	 = 'fi_sector';
		data.geojson = drawnItems.toGeoJSON();
		console.log(data);
		return false;
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
				L.geoJSON(JSON.parse(feature.geo_json)).eachLayer(function(l){
					drawnItems.addLayer(l);
				});				
				/*lyr = L.geoJSON(JSON.parse(feature.geo_json),{ pmIgnore : false }).addTo(map);
				
				lyr.on('pm:edit', e => {
					var layers = e.layers;
					console.log(e);
				});*/
			});
		});
	}
	
	return {
		init: function () {
			return init();
		}
	}	
} ();