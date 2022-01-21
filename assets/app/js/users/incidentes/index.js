var AppIndexIncidente = function() {
    var statusAudio = false;
    var limit = 20;
    var form = $('#frmIndex');
    var m_audio = $('#m_audio');
    var m_video = $('#m_video');
    var m_det_incidencia = $('#m_det_incidencia');
    var m_crear_incidencia = $('#m_crear_incidencia');
    var m_cerrar_incidencia = $('#m_cerrar_incidencia');
    var m_adj_incidencia = $('#m_adj_incidencia');
    var m_adj_unidad = $('#m_adj_unidad');
    var m_agr_incidencia = $('#m_agr_incidencia');
    var m_video_incidencia = $('#m_ver_video');
    var clasificacion_inc = $('#txtClasfInc');
    var nro_pagina = $('[name="txtPagina"]');
    var fec_registro = $('[name="txtFecRegistro"]');
    var ciudadano = $('[name="txtCiudadano"]');
    var nro_contacto = $('[name="txtNroContacto"]');
    var direccion = $('[name="txtDireccion"]');
    var sector = $('[name="txtSector"]');
    var incidencia_det = $('[name="txtDetIncidencia"]');
    var rango_fecha = $('input[name="txtFecRegistro"]');
    var btnAgrupar = $('[name="btnAgrupar"] span');
    var chkAll = $('[name="chkAll"]');
    var login = localStorage.getItem('logged-in');
    var init = function() {
        //initSocket();
        jQueryEvts();
        if (login == 'false') {
            window.location.href = '/siae-web/users/login/cerrar_sesion.php';

        }
        rango_fecha.daterangepicker({
            "locale": drp_es,
            "opens": "center"
        });


        m_det_incidencia.find('.modal-dialog').width(width_win * .7);
        m_crear_incidencia.find('.modal-dialog').width(width_win * .7);

        //form.trigger('submit');
    }

    var jQueryEvts = function() {

        $(document).on('change', '[name="curso[]"]', function(e) {
            // var sel = document.getElementById('curso[]').selected;4
            document.getElementById('seleccionados').innerHTML = '';
            var sel = document.getElementById('curso[]');
            for (var i = 0; i < sel.options.length; i++) {
                if (sel.options[i].selected == true) {
                    document.getElementById('seleccionados').innerHTML += '*' + sel.options[i].text + '<br>';
                }
            }
        });
        $(document).on('change', '[name="certificado"]', function(e) {
            var x = document.getElementById('certificado').value;
            if (x == '1') {
                document.getElementById('cuanto').removeAttribute('hidden');
            } else {
                document.getElementById("cuanto").setAttribute("hidden", "hidden");

            }
        });
        $(document).on('click', '[name="cerrarsesion"]', function(e) {
            localStorage.setItem('logged-in', false);
            sessionStorage.setItem('logged-in', false);

        });
        $(document).on('click', '[name="btnEditarInc[]"]', function(e) {
            var tr = $(this).closest('tr');
            var incidente_id = Number(tr.attr('data-id'));

            App.tabStorage('detalle_incidente', incidente_id);
            modal_det_incidente(incidente_id);
        });
        $(document).on('click', '[name="btndescarga[]"]', function(e) {

            var incidente_id = "nuevo";

            //App.tabStorage('detalle_incidente', incidente_id);
            modal_create_incidente(incidente_id);
        });


        $(document).on('change', '[name="txtAdjunto[]"]', function(e) {
            App.uploadFile('txtAdjunto[]', 'txtAdjTmp');
        });



        $('#frmIndex').submit(function(e) {

            App.tabStorage('form_incidente', JSON.stringify(App.arrayToForm($("#frmIndex").serializeArray())));

            fs_incidente();

            location.href = 'index.php';
            return false;
        });

        $(document).on('click', '[name="btnLimpiar"]', function(e) {
            location.href = 'index.php';
        });
    }


    var modal_agr_incidente = function() {
        $.get(path_root + "/users/incidentes/agrupar.php", function(data) {
            m_agr_incidencia.find('.modal-content').html(data);
            m_agr_incidencia.modal('show');
        }).done(function() {
            AppAgruparIncidente.init();
        });
    }
    var modal_det_incidente = function(incidente_id) {
        $.get(path_root + "/users/certificados/edit.php", { incidente_id: incidente_id }, function(data) {
            m_det_incidencia.find('.modal-content').html(data);
            m_det_incidencia.modal('show');
        }).done(function() {
            AppEditIncidente.init();
        });
    }
    var modal_create_incidente = function(incidente_id) {
        $.get(path_root + "/users/certificados/create.php", { incidente_id: incidente_id }, function(data) {
            m_crear_incidencia.find('.modal-content').html(data);
            m_crear_incidencia.modal('show');
        }).done(function() {
            AppCreateIncidente.init();
        });
    }

    var modal_cerrar_incidente = function(incidente_id) {
        $.get(path_root + "/users/certificados/cerrar.php", { incidente_id: incidente_id }, function(data) {
            m_cerrar_incidencia.find('.modal-content').html(data);
            m_cerrar_incidencia.modal('show');
        }).done(function() {
            AppCerrarIncidente.init();
        });
    }

    var modal_adj_incidente = function(incidente_id) {
        $.get(path_root + "/users/certificados/adjuntos.php", { incidente_id: incidente_id }, function(data) {
            m_adj_incidencia.find('.modal-content').html(data);
            m_adj_incidencia.modal('show');
        });
    }

    var modal_adj_unidad = function(incidente_id) {
        $.get(path_root + "/users/incidentes/unidad_movil.php", { incidente_id: incidente_id }, function(data) {
            m_adj_unidad.find('.modal-content').html(data);
            m_adj_unidad.modal('show');
        }).done(function() {
            AppEditUndMov.init();
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
                $.post("incidentes.php", { txtNroCaso: data.incidente_id }, function(html) {
                    $('#tblIncidencias tr[data-id="' + data.incidente_id + '"]').replaceWith(html);
                }).done(function() {
                    App.toaster('Notificaci車n de actualizaci車n', 'Incidente actualizado', 'success');
                    m_cerrar_incidencia.modal('hide');
                });
            }
        });
    }

    var fs_incidente = function(pagina = 0) {
        var data = $("#frmIndex").serializeObject();
        data.class = 'IncidenteController';
        data.method = 'create';
        data.txtPagina = pagina;
        $.ajax({
            url: path_ws,
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response) {


                App.toaster('Notificaci車n de actualizaci車n', 'Incidente actualizado', 'success');

            }
        });
        // $.get(path_root + '/users/certificados/incidentes.php', data, function(response) {
        //     $('#tblIncidencias tbody').html(response);
        //     $('#hlDescData').attr('href', path_root + '/users/incidentes/exportar_excel.php?data=' + encodeURIComponent(JSON.stringify(data)));

        //     chkAll.prop('checked', false);

        //     if (pagina == 0) {
        //         fs_incidente_pg();
        //     }
        // });


    }

    var fs_incidente_pg = function() {
        var data = App.arrayToForm($("#frmIndex").serializeArray());
        data.class = 'IncidenteController';
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
                App.tabStorage('form_incidente', JSON.stringify(App.arrayToForm($("#frmIndex").serializeArray())));
                fs_incidente(num);
            });
        }, "json");
    }

    var dialog_position = function(id) {
        var m_buscador = $('#m_buscador');
        var dialog = $('[aria-describedby="' + id + '"]');
        var _left = parseInt($(window).width() - (dialog.width() + (dialog.width() * 0.1)));
        var _top = m_buscador.offset().top + parseInt(m_buscador.css('padding-top').replace('px', ''));

        dialog.css({
            "top": _top,
            "left": _left
        });

        $('.ui-dialog-titlebar-close').html("X");
    }

    return {
        init: function() {
            return init();
        }
    }
}();