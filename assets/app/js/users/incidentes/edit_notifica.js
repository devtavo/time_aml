var AppEditIncidente = function() {
    var marker;
    var map_edit;
    var nro_telef;
    var nro_doc_identidad;
    var origen;
    var denunciante;
    var coordenadas;
    var direccion;
    var form;
    var m_det_incidencia;

    var initVars = function() {
        marker = L.marker([0, 0], {
            draggable: true,
            icon: L.ExtraMarkers.icon({
                icon: 'fa-crosshairs',
                shape: 'circle',
                prefix: 'fa',
                markerColor: 'red',
                iconColor: 'white'
            })
        }).addTo(map);

        map_edit = $('#map_edit');
        nro_telef = $('[name="txtNroTelef"]');
        nro_doc_identidad = $('[name="txtNroDocIde"]');
        origen = $('[name="ddlFuenteInfo"]');
        denunciante = $('[name="txtDenunciante"]');
        coordenadas = $('[name="txtCoordenadas"]');
        direccion = $('[name="txtDireccion"]');
        form = $('[role="form"]');
        m_det_incidencia = $('#m_det_incidencia');

        if (coordenadas.val().length > 10) {
            var latlng = coordenadas.val().trim().split(",");
            marker.setLatLng(latlng);
            map.fitBounds([latlng]);
        }
    }

    var init = function() {
        initMap();
        initGeocoder();
        initVars();
        jQueryEvts();
    }

    var initMap = function() {
        map = L.map('map_edit', {
            center: [-7.168631636423349, -78.5031096066236],
            zoom: 17,
            zoomControl: false,
            attributionControl: false
        });

        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&amp;copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        setTimeout(function() {
            map_edit.height(
                m_det_incidencia.find('.modal-body').height()
            );
            map.invalidateSize();
        }, 400);

        L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
    }

    var initGeocoder = function() {
        L.control.scale().addTo(map);
        var searchControl = new L.esri.Controls.Geosearch().addTo(map);

        searchControl.on('results', function(data) {
            for (var i = data.results.length - 1; i >= 0; i--) {
                if (marker != undefined) {
                    direccion.val(data.results[i].address);
                    marker.setLatLng(data.results[i].latlng);
                    coordenadas.val(Number(data.results[i].latlng.lat).toFixed(6) + ', ' + Number(data.results[i].latlng.lng).toFixed(6));
                };
            }
        });
    }

    var jQueryEvts = function() {
        $('[name="txtNroDocIde"]').keyup(function() {
            if ($(this).val().length == 8) {
                fs_ciudadano('', $(this).val());
            }
        });

        $('[name="txtDescIncidencia"]').keyup(function() {
            $('[name="txtDescIncidencia"]').next().find('label').text(
                $(this).val().length
            );
        });

        map.on('click', function(e) {
            if (marker != undefined) {
                marker.setLatLng(e.latlng);
                coordenadas.val(e.latlng.lat.toFixed(6) + ', ' + e.latlng.lng.toFixed(6));
            };
        });

        form.validator().on('submit', function(e) {
            if (!e.isDefaultPrevented()) {
                fu_incidente();
            }

            return false;
        });

        marker.on('dragend', function(e) {
            if (marker != undefined) {
                coordenadas.val(e.target.getLatLng().lat.toFixed(6) + ', ' + e.target.getLatLng().lng.toFixed(6));
            };
        });
    }

    var fs_ciudadano = function(nro_telefono, nro_doc_ide) {
        var data = {};
        data.class = 'CiudadanoController';
        data.method = 'findById';
        data.nro_telefono = nro_telefono;
        data.nro_doc_ide = nro_doc_ide;

        $.ajax({
            url: path_ws,
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response) {
                if (Object.keys(response).length > 0) {
                    denunciante.attr("readonly", true);
                    denunciante.val(response.ciudadano);
                    nro_doc_identidad.val(response.nro_doc_identidad);
                } else {
                    denunciante.attr("readonly", false);
                    denunciante.val('');
                }
            }
        });
    }

    var fu_incidente = function() {
        var data = App.arrayToForm($("#frmEditarCaso").serializeArray());
        data.class = 'IncidenteController';
        data.method = 'update';

        $.ajax({
            url: path_ws,
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response) {
                $.post("incidentes.php", { txtNroCaso: data.txtIncidenteId }, function(html) {
                    $('#tblIncidencias tr[data-id="' + data.txtIncidenteId + '"]').replaceWith(html);
                }).done(function() {
                    App.toaster('Notificación de actualización', 'Incidente actualizado', 'success');
                    m_det_incidencia.modal('hide');
                });
            }
        });
    }

    return {
        init: function() {
            return init();
        }
    }
}();