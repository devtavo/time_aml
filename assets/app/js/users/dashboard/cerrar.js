var AppCerrarIncidente = function() {
    var m_cerrar_incidencia;

    var initVars = function() {
        m_cerrar_incidencia = $('#m_cerrar_incidencia');
    }

    var init = function() {
        initVars();
        jQueryEvts();
    }

    var jQueryEvts = function() {
        $('[name="txtPalabrasClave"]').tagsinput({
            maxTags: 5
        });

        $('#frmCerrarCaso').validator().on('submit', function(e) {
            if (!e.isDefaultPrevented()) {
                var incidente_id = $('#txtIndicenteId').val();
                var adjuntos = $('[name="txtAdjTmp"]').val();
                var comentarios = $('[name="txtComentarios"]').val();
                var palabras_clave = $('[name="txtPalabrasClave"]').val();

                fi_cerrar_incidente({
                    'incidente_id': incidente_id,
                    'adjuntos': adjuntos,
                    'comentarios': comentarios,
                    'palabras_clave': palabras_clave
                });
            }

            return false;
        });
    }

    var fi_cerrar_incidente = function(data) {
        data['class'] = 'IncidenteController';
        data['method'] = 'cerrarCaso';

        $.ajax({
            url: path_ws,
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response) {
                $('#tblIncidencias tr[data-id="' + data.incidente_id + '"]').remove();
                App.toaster('Notificación de actualización', 'Incidente actualizado', 'success');
                m_cerrar_incidencia.modal('hide');
            }
        });
    }

    return {
        init: function() {
            return init();
        }
    }
}();