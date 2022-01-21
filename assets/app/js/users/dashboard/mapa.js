var lyrGroupIncidentes = new L.layerGroup();
var ArrIncidentes = new Array();
var ArrRadios = new Array();

var AppMapaIncidente = function() {

    var init = function() {
        initMap();
        initSocket();
        initPanelLayers();
        initDialog();

        window.addEventListener('storage', function(e) {
            if (e.key === 'detalle_incidente') {
                if ('I_' + e.newValue in ArrIncidentes) {
                    if (typeof circle != 'undefined') {
                        map.removeLayer(circle);
                    }

                    circle = L.circle(ArrIncidentes['I_' + e.newValue].getLatLng(), {
                        color: 'red',
                        fillColor: '#f03',
                        fillOpacity: 0.5,
                        radius: 50
                    }).addTo(map);

                    map.setView(ArrIncidentes['I_' + e.newValue].getLatLng(), 18);
                }
            }

            if (e.key === 'form_incidente') {
                fs_incidentes(JSON.parse(e.newValue));
            }

            localStorage.clear();
        });
    }

    var initMap = function() {
        map = L.map('map', {
            center: [-7.164883, -78.510399],
            zoom: 14,
            zoomControl: false,
            attributionControl: false
        });

        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&amp;copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        lyrGroupIncidentes.addTo(map);
    }

    var initLogo = function() {
        L.Control.Watermark = L.Control.extend({
            onAdd: function(map) {
                var img = L.DomUtil.create('img');

                img.id = 'logo';
                img.src = '../../assets/app/img/logo_mapa.png';
                img.style.width = '220px';

                return img;
            },
            onRemove: function(map) {}
        });

        L.control.watermark = function(opts) {
            return new L.Control.Watermark(opts);
        }

        L.control.watermark({ position: 'topleft' }).addTo(map);
    }

    var initDialog = function() {
        dialog = L.control.dialog({
            anchor: [0, 0],
            size: [parseInt(width_win * 0.35), 350],
            maxSize: [550, 550],
            initOpen: false
        }).addTo(map);
    }

    var initSocket = function() {
        var socket_gps = io.connect('//95.217.44.43:3000');

        socket_gps.on('connect', function() {
            console.log('connected');

            socket_gps.on('gps_actualizar', function(obj) {
                $.each(obj, function(key, feature) {
                    var newLatLng = new L.LatLng(Number(feature.LATITUDE), Number(feature.LONGITUDE));
                    if (feature.DEVICEID in ArrRadios) {
                        ArrRadios[feature.DEVICEID].setLatLng(newLatLng);
                    }
                });
            });

            socket_gps.on('disconnect', function() {
                console.log('disconnected');
            });
        });
    }

    function onEachFeature(feature, layer) {
        layer.bindTooltip("S" + feature.properties.OBJECTID, { permanent: true, direction: 'center', className: 'sectorizacion' });
    }

    var initPanelLayers = function() {
        var baseLayers = [

        ];

        var overLayers = [{
                active: true,
                name: "Sector",
                layer: (function() {
                    var topoLayer = new L.TopoJSON(null, {
                        style: {
                            fillColor: 'transparent',
                            weight: 2
                        },
                        onEachFeature: onEachFeature
                    });

                    $.getJSON('../../assets/app/json/sectores.topojson', function(data) {
                        topoLayer.addData(data);
                    });

                    return topoLayer;
                }())
            },
            /*{
            	active: true,
            	name: "Jerarquización",
            	layer: (function() {
            		var topoLayer = new L.TopoJSON(null, { style: {
            			fillColor: 'transparent',
            			weight: 2						
            		}, onEachFeature: onEachFeature });
			
            		$.getJSON('../../assets/app/json/jerarquizacion.topojson', function(data)  {
            			topoLayer.addData(data);
            		});
            		
            		return topoLayer;
            	}())
            },*/
            {
                active: true,
                name: "Incidentes",
                layer: (function() {
                    var l = fs_incidentes({
                        ddlEstado: ['D']
                    });
                    return lyrGroupIncidentes;
                }())
            },
            {
                active: true,
                name: "C&aacute;maras",
                layer: (function() {
                    var l = L.geoJson();
                    var obj = { class: 'CamaraController', method: 'index', geoJson: true };

                    $.getJSON(path_ws, obj, function(data) {
                        data = L.geoJSON(JSON.parse(data), {
                            style: function(feature) {
                                return feature.properties && feature.properties.style;
                            },
                            pointToLayer: function(feature, latlng) {
                                var marker = L.marker(latlng, {
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
                            var obj = e.layer.feature.properties;

                            if (obj.ptz == true) {
                                var height = $('.leaflet-control-dialog').height() / 2;
                                var width = $('.leaflet-control-dialog').width() / 2;
                                if (obj.wave_id.length > 0) {
                                    dialog.setSize([parseInt(width_win * .6), 630]);
                                    $.get(path_root + "/users/camaras/show.php", { wave_id: obj.wave_id, height: height, width: width, ptz: obj.ptz }, function(response) {

                                        dialog.setContent(response);

                                        player = new JSMpeg.Player('ws://172.40.2.62:' + (8000 + obj.camara_id), {
                                            canvas: document.getElementById('canvas')
                                        })
                                        player = new JSMpeg.Player('ws://172.40.2.62:' + (8002), {
                                            canvas: document.getElementById('canvas2')
                                        })
                                        player = new JSMpeg.Player('ws://172.40.2.62:' + (8003), {
                                            canvas: document.getElementById('canvas3')
                                        })
                                        player = new JSMpeg.Player('ws://172.40.2.62:' + (8004), {
                                            canvas: document.getElementById('canvas4')
                                        })

                                    });
                                }

                            } else {
                                var win_w = $(window).width();

                                var height = $('.leaflet-control-dialog').height();
                                var width = $('.leaflet-control-dialog').width();

                                if (obj.wave_id.length > 0) {
                                    $.get(path_root + "/users/camaras/show.php", { wave_id: obj.wave_id, height: height, width: width, ptz: obj.ptz }, function(response) {
                                        // dialog.setSize([parseInt(width_win * .4), 308]);

                                        dialog.setContent(response);
                                        player = new JSMpeg.Player('ws://172.40.2.62:' + (8000 + obj.camara_id), {
                                            canvas: document.getElementById('canvas')
                                        })
                                    });
                                }
                            }

                        });
                    });

                    return l;
                }())
            },
            {
                active: true,
                name: "Radios",
                layer: (function() {
                    var l = L.layerGroup();
                    var obj = { class: 'RadioController', method: 'index' };

                    $.getJSON(path_ws, obj, function(data) {
                        $.each(data, function(key, feature) {
                            var marker = L.marker(new L.LatLng(Number(feature.latitude), Number(feature.longitude)), {
                                title: 'Radio ' + feature.radio_id,
                                icon: L.ExtraMarkers.icon({
                                    icon: 'fa-fax',
                                    shape: 'circle',
                                    markerColor: 'green',
                                    prefix: 'fa',
                                    iconColor: 'white'
                                })
                            }).addTo(l);

                            ArrRadios[feature.radio_id] = marker;
                        });
                    });

                    return l;
                }())
            }
        ];

        map.addControl(new L.Control.PanelLayers(baseLayers, overLayers, {
            title: 'Objetos del Mapa',
            position: 'topright',
            compact: true
        }));
    }

    var addIncidente = function(obj) {
        L.marker([Number(obj.latitud), Number(obj.longitud)]).addTo(map);
    }

    var fs_radios = function(obj) {
        var obj = { class: 'RadioController', method: 'update' };

        $.getJSON(path_ws, obj, function(data) {
            $.each(JSON.parse(data).features, function(key, feature) {
                var coordinates = feature.geometry.coordinates;
                ArrRadios[feature.properties.radio_id].setLatLng(L.latLng(coordinates[1], coordinates[0]));
            });
        });
    }

    var fs_incidentes = function(params = {}) {
        var l = L.geoJson();
        var obj = { class: 'IncidenteController', method: 'index', geoJson: true, ddlEstado: params.ddlEstado };

        if (Object.keys(params).length > 0) {
            Object.assign(obj, params);
        }

        lyrGroupIncidentes.clearLayers();

        $.getJSON(path_ws, obj, function(data) {
            if (JSON.parse(data).features != null) {
                data = L.geoJSON(JSON.parse(data), {
                    style: function(feature) {
                        return feature.properties && feature.properties.style;
                    },
                    pointToLayer: function(feature, latlng) {
                        var marker = L.marker(latlng, {
                            title: 'Incidente ' + feature.properties.incidente_id,
                            icon: L.ExtraMarkers.icon({
                                icon: 'fa-number',
                                shape: 'square',
                                number: feature.properties.incidente_id,
                                markerColor: 'red',
                                iconColor: 'white'
                            })
                        });

                        ArrIncidentes['I_' + feature.properties.incidente_id] = marker;

                        marker.bindPopup("Cargando...", { closeButton: true, minWidth: 550 });

                        return marker;
                    }
                }).addTo(lyrGroupIncidentes);

                data.on('click', function(e) {
                    var obj = e.layer.feature.properties;

                    $.get(path_root + "/users/incidentes/show.php", { incidente_id: obj.incidente_id }, function(response) {
                        e.layer._popup.setContent(response);
                        $('[name="ddlSupervisores"]').multiSelect();
                    });
                });
            }
        });

        return l;
    }

    return {
        init: function() {
            return init();
        }
    }
}();