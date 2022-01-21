var AppIndexNotifica = function() {
    var statusAudio = false;
    var limit = 20;
    var form = $('#frmIndex_notifica');
    var m_notificaciones = $('#m_notificaciones');
    var m_cerrar_incidencia = $('#m_cerrar_incidencia');

    var rango_fecha = $('input[name="txtFecRegistro"]');


    var init = function() {
        //initSocket();
        jQueryEvts();
        initSocket_noti();

        rango_fecha.daterangepicker({
            "locale": drp_es,
            //"timePicker": true,
            "opens": "center"
        });

        m_notificaciones.find('.modal-dialog').width(width_win * .6);

        form.trigger('submit');
    }

    var jQueryEvts = function() {

        $(document).on('change', '[id="ddlClasificInc"]', function(e) {
            var item = $(this);
            var params = { class: 'MultitablaController', method: 'index', tabla: 'ssc_tipo_inc', padre_id: item.val() };

            App.dropDownList('ddlTipoInc', params);
        });

        $(document).on('change', '[id="ddlTipoInc"]', function(e) {
            var item = $(this);
            var params = { class: 'MultitablaController', method: 'index', tabla: 'ssc_subtipo_inc', padre_id: item.val() };

            App.dropDownList('ddlSubTipoInc', params);
        });


        $(document).on('click', '[name="btnExportar"]', function(e) {
            window.open('informe_incidencias.php');
        });

        $(document).on('click', '[name="btnnuevanotifi"]', function(e) {
            var notificacion_id = 'nueva'
            var editado = ''
            modal_notificacion(notificacion_id, editado);
        });

        $('#frmIndex_notifica').submit(function(e) {
            var a = JSON.stringify(App.arrayToForm($("#frmIndex_notifica").serializeArray()));
            //console.log(a);
            App.tabStorage('form_notificacion', JSON.stringify(App.arrayToForm($("#frmIndex_notifica").serializeArray())));
            fs_incidentes();
            return false;
        });
        $(document).on('click', '[name="btneditar_noti[]"]', function(e) {
            var tr = $(this).closest('tr');
            var notificacion_id = Number(tr.attr('data-id'));
            var editado = 'editado';

            modal_notificacion(notificacion_id, editado);
        });
        $(document).on('click', '[name="btneliminar_noti[]"]', function(e) {
            var tr = $(this).closest('tr');
            var notificacion_id = Number(tr.attr('data-id'));
            //var editado = 'editado';

            fu_notifica(notificacion_id);
        });
        $(document).on('click', '[name="btnLimpiar"]', function(e) {
            location.href = 'notifica.php';
        });
    }


    var initSocket_noti = function() {
        var socket_pbx = io.connect('//192.168.4.6:5000');

        socket_pbx.on('connect', function() {
            console.log('connectado_noti');
            socket_pbx.on('connect user', function(obj) {

                if (obj.flag == 'update') {

                    //console.log("actualizado");

                    $.post("notificaciones.php", { notificacion_id: obj.notificacion_id }, function(html) {
                        //console.log(html);
                        $('#tblNotificacion tr[data-id="' + obj.notificacion_id + '"]').replaceWith(html);
                    }).done(function() {
                        App.toaster('Notificación de actualización', 'Notificación programada ha sido enviada con exito', 'success');
                    });

                } else {
                    $.post("notificaciones.php", { notificacion_id: obj.notificacion_id, highlight: 'highlight-sos' }, function(data) {
                        //fs_incidentes();
                        // console.log(obj);
                        fs_incidente_sckapp(obj.notificacion_id, data, 'highlight-sos');
                    });
                }

            });
            $(document).on('click', '[name="close"]', function(e) {
                $('[name="alerta"]').attr('style', 'display:none');

            });

            $(document).on('click', '[id="envio"]', function(e) {
                //var socket_pbx = io.connect();
                var titulo = $('[name="txtTitulo"]').val();
                var descripcion = $('[name="txtDescripcion"]').val();
                //var nueva = $('[name="editado"]').val();
                if ((titulo && descripcion) == '') {
                    $('[name="alerta"]').attr('style', 'display');

                } else {
                    var envio = $('[id="envio"]').text();
                    var flag = $('[name="editado"]').val();
                    var a = {};
                    //console.log(flag);
                    if (envio == 'Enviar Notificación' && flag == 'editado') {
                        a = {
                            "tipo": $('[name="ddlTipo"]').val(),
                            "titulo": $('[name="txtTitulo"]').val(),
                            "descripcion": $('[name="txtDescripcion"]').val(),
                            "fecha_registro": $('[name="txtFecRegistro2"]').val(),
                            "fecha_lanzamiento": $('[name="txtFecRegistro_"]').val(),
                            "estado": "A"
                        };
                        console.log(a);
                        socket_pbx.emit('notificacion', a);
                        fu_notificacion();

                    } else if (envio == 'Enviar Notificación') {
                        a = {
                            "tipo": $('[name="ddlTipo"]').val(),
                            "titulo": $('[name="txtTitulo"]').val(),
                            "descripcion": $('[name="txtDescripcion"]').val(),
                            "fecha_registro": $('[name="txtFecRegistro2"]').val(),
                            "fecha_lanzamiento": $('[name="txtFecRegistro_"]').val(),
                            "estado": "A"
                        };
                        console.log(a);
                        socket_pbx.emit('notificacion', a);
                        App.toaster('Notificación de actualización', 'Notificacion enviada', 'success');
                    } else if (envio == 'Grabar envio' && flag == 'editado') {
                        fu_notificacion();


                    } else if (envio == 'Grabar envio') {

                        a = {
                            "tipo": $('[name="ddlTipo"]').val(),
                            "titulo": $('[name="txtTitulo"]').val(),
                            "descripcion": $('[name="txtDescripcion"]').val(),
                            "fecha_registro": $('[name="txtFecRegistro2"]').val(),
                            "fecha_lanzamiento": $('[name="txtFecRegistro_"]').val(),
                            "estado": "P"

                        };
                        socket_pbx.emit('notificacion', a);
                        App.toaster('Notificación de actualización', 'Notificacion programada', 'success');
                    }
                    m_notificaciones.modal('hide');


                }

            });


        });

        function fs_incidente_sckapp(incidente_id, data, highlight) {
            var rows = $('#tblNotificacion > tbody > tr.rows_0').length;

            if (rows == 0) {
                $(data).insertBefore('#tblNotificacion > tbody > tr:first');
            } else {
                $('#tblNotificacion > tbody').html(data);
            }

            setTimeout(function() {
                $('#tblNotificacion tr[data-id="' + incidente_id + '"]').removeClass(highlight);
            }, 3000);

            return false;
        }
    }

    var modal_notificacion = function(notificacion_id, editado) {
        //console.log(notificacion_id, " ", editado);
        $.get(path_root + "/users/incidentes/n_notificacion.php", { notificacion_id: notificacion_id, editado: editado }, function(data) {
            m_notificaciones.find('.modal-content').html(data);
            m_notificaciones.modal('show');
        }).done(function() {
            AppEnviarNotificacion.init();
        });
    }
    var fu_notificacion = function() {
        var data = App.arrayToForm($("#frmEditarnoti").serializeArray());
        data.class = 'NotificaController';
        data.method = 'update';

        $.ajax({
            url: path_ws,
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response) {
                $.post("notificaciones.php", { notificacion_id: data.txtNotificacionId }, function(html) {
                    $('#tblNotificacion tr[data-id="' + data.txtNotificacionId + '"]').replaceWith(html);
                }).done(function() {
                    App.toaster('Notificación de actualización', 'Notificación actualizada', 'success');
                    // m_notificaciones.modal('hide');
                });
            }
        });
    }
    var fu_notifica = function(notificacion_id) {
        var data = {};
        data.class = 'NotificaController';
        data.method = 'update';
        data.anula = 'N';
        data.id = notificacion_id;
        $.ajax({
            url: path_ws,
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response) {
                $.post("notificaciones.php", { notificacion_id: data.id }, function(html) {
                    $('#tblNotificacion tr[data-id="' + data.id + '"]').replaceWith(html);
                }).done(function() {
                    App.toaster('Notificación de actualización', 'Notificación anulada', 'success');
                    // m_notificaciones.modal('hide');
                });
            }
        });
    }
    var fu_incidente = function(data) {
        data['class'] = 'IncidenteController';
        data['method'] = 'update';

        $.ajax({
            url: path_ws,
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response) {
                $.post("notificaciones.php", { txtNroCaso: data.incidente_id }, function(html) {
                    $('#tblIncidencias tr[data-id="' + data.incidente_id + '"]').replaceWith(html);
                }).done(function() {
                    App.toaster('Notificación de actualización', 'Incidente actualizado', 'success');
                    m_cerrar_incidencia.modal('hide');
                });
            }
        });
    }

    var fs_incidentes = function(pagina = 0) {
        //console.log(pagina);
        var data = App.arrayToForm($("#frmIndex_notifica").serializeArray());
        //console.log(data);
        data.class = 'NotificaController';
        data.method = 'index';
        data.txtPagina = pagina;

        $.get(path_root + '/users/incidentes/notificaciones.php', data, function(response) {
            $('#tblNotificacion tbody').html(response);
            $('#hlDescData').attr('href', path_root + '/users/incidentes/exportar_excel.php?data=' + encodeURIComponent(JSON.stringify(data)));
            if (pagina == 0) {
                fs_incidente_pg();
            }
        });
    }

    var fs_incidente_pg = function() {
        var data = App.arrayToForm($("#frmIndex_notifica").serializeArray());
        data.class = 'NotificaController';
        data.method = 'countBySql';

        $.post(path_ws, data, function(response) {
            var cantidad = parseInt(response.cantidad);
            var paginas = parseInt(response.paginas);

            var pg = App.paginator('paginator', paginas);

            App.paginatorMsg(
                'TblIncMsg',
                (cantidad > 0 ? 1 : 0),
                (cantidad < limit ? cantidad : limit),
                response.cantidad
            );

            pg.on('page', function(event, num) {

                App.paginatorMsg(
                    'TblIncMsg',
                    ((num - 1) * limit) + 1, num * limit, response.cantidad
                );
                App.tabStorage('form_incidente', JSON.stringify(App.arrayToForm($("#frmIndex_notifica").serializeArray())));
                fs_incidentes(num);
            });
        }, "json");
    }


    return {
        init: function() {
            return init();
        }
    }
}();