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


        map_edit = $('#map_edit');
        nro_telef = $('[name="txtNroTelef"]');
        nro_doc_identidad = $('[name="txtNroDocIde"]');
        origen = $('[name="ddlFuenteInfo"]');
        denunciante = $('[name="txtDenunciante"]');
        coordenadas = $('[name="txtCoordenadas"]');
        direccion = $('[name="txtDireccion"]');
        form = $('[role="form"]');
        m_det_incidencia = $('#m_det_incidencia');


    }

    var init = function() {
        initVars();
        jQueryEvts();
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

        $('[name="guardaenvio"]').click(function() {
            var estado = document.getElementById("ddlestado").value;
            var id_envios = document.getElementById("id_envios").value;
            var numerotrack = document.getElementById("numerotrack").value;


            fu_envio(estado, id_envios, numerotrack);
        });

        form.validator().on('submit', function(e) {
            if (!e.isDefaultPrevented()) {
                fu_incidente();
            }

            return false;
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
    var fu_envio = function(estado, id_envios, numerotrack) {
        var data = {};

        data.class = 'EnviosController';
        data.method = 'update';
        data.estado = estado;
        data.id_envios = id_envios;
        data.numerotrack = numerotrack;
        $.ajax({
            url: path_ws,
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response) {
                // $.post("incidentes.php", { txtNroCaso: data.txtIncidenteId }, function(html) {
                //     $('#tblIncidencias tr[data-id="' + data.txtIncidenteId + '"]').replaceWith(html);
                // }).done(function() {
                //     App.toaster('Notificación de actualización', 'Incidente actualizado', 'success');
                //     m_det_incidencia.modal('hide');
                // });
                console.log("llegoqui");
                console.log(estado);


            }
        });
        m_det_incidencia.modal('hide');

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