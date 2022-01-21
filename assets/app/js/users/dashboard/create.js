var AppCreateIncidente = function() {
    var marker;
    var urlData = '';
    var totalSeconds = 0;
    var tblBandejaInc = $("#tblBandejaInc tbody");
    var nro_telef = $('[name="txtNroTelef"]');
    var nro_llamada = $('[name="lblNroTlf"]');
    var nro_doc_identidad = $('[name="txtNroDocIde"]');
    var origen = $('[name="ddlFuenteInfo"]');
    var denunciante = $('[name="txtDenunciante"]');
    var minutos = $('[name="lblMinutos"]');
    var segundos = $('[name="lblSegundos"]');
    var latitud = $('[name="txtLat"]');
    var longitud = $('[name="txtLng"]');
    var llamada = $('[name="txtAudioLlamada"]');
    var form = $('[role="form"]');
    var origen;
    m_crear_incidencia;


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
        origen = $('[name="ddlOrigen"]');
        denunciante = $('[name="txtDenunciante"]');
        coordenadas = $('[name="txtCoordenadas"]');
        direccion = $('[name="txtDireccion"]');
        form = $('[role="form"]');
        m_crear_incidencia = $('#m_crear_incidencia');

        if (coordenadas.val().length > 10) {
            var latlng = coordenadas.val().trim().split(",");
            marker.setLatLng(latlng);
            map.fitBounds([latlng]);
        }
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
                m_crear_incidencia.find('.modal-body').height()
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
    var init = function() {
        initMap();
        initGeocoder();
        initVars();
        jQueryEvts();
        initSocket();
        setInterval(setTime, 1000);
    }

    var setTime = function() {
        ++totalSeconds;
        minutos.text(App.pad(parseInt(totalSeconds / 60)));
        segundos.text(App.pad(totalSeconds % 60));
    }

    // var initMap = function() {
    //     map = L.map('map', {
    //         center: [-7.168631636423349, -78.5031096066236],
    //         zoom: 17,
    //         zoomControl: false,
    //         attributionControl: false
    //     });

    //     L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    //         attribution: '&amp;copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    //     }).addTo(map);
    // }

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



        marker.on('dragend', function(e) {
            if (marker != undefined) {
                coordenadas.val(e.target.getLatLng().lat.toFixed(6) + ', ' + e.target.getLatLng().lng.toFixed(6));
            };
        });
    }

    var initSocket = function() {
        // var socket = io.connect('//95.217.44.43:3000');

        // socket.on('connect', function() {
        //     console.log('connected');

        //     // socket.on('app_incidente', function(obj) {
        //     //     tblBandejaInc.prepend(
        //     //         '<tr>' +
        //     //         '<td>' + obj.fec_reg + '</td>' +
        //     //         '<td></td>' +
        //     //         '<td><button type="button" class="btn btn-primary btn-xs" onclick="AppCreateIncidente.fs_incidente(this);" data-id="' + obj.incidente_id + '">Atender</button></td>' +
        //     //         '</tr>'
        //     //     );
        //     // });

        //     socket.on('disconnect', function() {
        //         console.log('disconnected');
        //     });
        // });

        var socket_pbx = io.connect('//192.168.4.9:3000');

        socket_pbx.on('connect', function() {
            console.log('connectado');

            socket_pbx.on('contestar_llamada', function(obj) {
                window.open('create.php?data=' + encodeURIComponent(JSON.stringify(obj)), '_blank');
            });

            socket_pbx.on('disconnect', function() {
                console.log('disconnected');
            });
            socket_pbx.on('app_incidente', function(obj) {
                //console.log(obj);
                $.post("incidentes.php", { txtNroCaso: obj, highlight: 'highlight' }, function(data) {
                    fs_incidente_sckapp(obj, data, 'highlight');
                    //console.log(data);
                });
            });
        });

        form.validator().on('submit', function(e) {
            if (!e.isDefaultPrevented()) {
                fi_incidente();


            }
            return false;
        });
        var fi_incidente = function() {
            var data = App.arrayToForm($("#frmCrearCaso").serializeArray());
            data.class = 'IncidenteController';
            data.method = 'create';
            data.socket = true;
            //console.log("aqui");
            $.ajax({
                url: path_ws,
                type: 'post',
                dataType: 'json',
                data: data,
                success: function(response) {
                    var response = JSON.parse(response.data);
                    // console.log(response.incidente_id);
                    incidente = response.incidente_id;
                    socket_pbx.emit('app_incidente', incidente);

                    //console.log(incidente);
                    m_crear_incidencia.modal('hide');
                    $.toast({
                        heading: 'Notificaci&oacute;n de registro',
                        text: 'Incidente registrado',
                        icon: 'success',
                        loader: true,
                        loaderBg: '#9EC600'
                    });

                }
            });
        }

        function fs_incidente_sckapp(incidente_id, data, highlight) {
            var rows = $('#tblIncidencias > tbody > tr.rows_0').length;

            if (rows == 0) {
                $(data).insertBefore('#tblIncidencias > tbody > tr:first');
            } else {
                $('#tblIncidencias > tbody').html(data);
            }

            setTimeout(function() {
                $('#tblIncidencias tr[data-id="' + incidente_id + '"]').removeClass(highlight);
            }, 3000);

            return false;
        }

    }


    // var fs_incidente = function(obj) {
    //     var data = {};
    //     data.class = 'IncidenteController';
    //     data.method = 'findById';
    //     data.incidente_id = parseInt($(obj).attr("data-id"));
    //     data.socket = true;

    //     $.ajax({
    //         url: path_ws,
    //         type: 'post',
    //         dataType: 'json',
    //         data: data,
    //         success: function(response) {
    //             $('[name="txtIncidenteId"]').val(response.incidente_id);
    //             $('[name="txtEstadoInc"]').val('D');
    //             $('[name="ddlFuenteInfo"] option[value="2"]').attr("selected", true);
    //             $('[name="txtNroTelef"]').val(response.telefono);
    //             $('[name="txtNroDocIde"]').val(response.nro_doc_identidad);
    //             $('[name="txtDenunciante"]').val(response.ciudadano);
    //             $('[name="txtDescIncidencia"]').val(response.incidencia_descripcion);
    //             latitud.val(parseFloat(response.latitud).toFixed(6));
    //             longitud.val(parseFloat(response.longitud).toFixed(6));

    //             if (marker != undefined) map.removeLayer(marker);
    //             marker = L.marker([response.latitud, response.longitud]).addTo(map);
    //             map.setView(marker.getLatLng(), 17);
    //             form.validator('update');
    //         }
    //     });
    // }

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
                // console.log(response);
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

    return {
        init: function() {
            return init();
        },
        fi_incidente: function() {
            return fi_incidente();
        },
        fs_incidente: function(obj) {
            return fs_incidente(obj);
        }
    }
}();