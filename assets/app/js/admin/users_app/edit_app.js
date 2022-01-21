var AppEditUsers_app = function() {
    var form;
    var m_reg_usuario_app;

    var initVars = function() {
        form = $('#frmEditUsuario');
        m_reg_usuario_app = $('#m_reg_usuario_app');
        clave = $('[name="txtClave"]');
    }

    var init = function() {
        initVars();
        jQueryEvts();
    }

    var jQueryEvts = function() {
        $('[name="chkClave"]').change(function() {
            if (!this.checked) {
                clave.val('');
            }
            clave.prop('readonly', !this.checked);
            clave.prop('required', this.checked);
        });

        form.validator().on('submit', function(e) {
            if (!e.isDefaultPrevented()) {
                fu_usuario();
            }

            return false;
        });
    }

    var fu_usuario = function() {
        var data = $('#frmEditUsuario').serializeObject();
        data.class = 'UsuarioAppController';
        data.method = 'update';

        $.ajax({
            url: path_ws,
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response) {
                $.post("usuarios_app.php", { txtUsuarioId: data.txtUsuarioId }, function(html) {
                    $('#tblUsuariosApp tr[data-id="' + data.txtUsuarioId + '"]').replaceWith(html);
                }).done(function() {
                    App.toaster('Notificación de actualización', 'Usuario actualizado', 'success');
                    m_reg_usuario_app.modal('hide');
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