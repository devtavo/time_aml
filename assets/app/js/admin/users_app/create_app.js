var AppCreateUsers_app = function() {
    var form;
    var m_reg_usuario_app;

    var initVars = function() {
        form = $('#frmRegUsuario');
        txtNombres = $("[name='txtNombres']");
        txtApePat = $("[name='txtApePat']");
        txtUsuario = $("[name='txtUsuario']");
        m_reg_usuario_app = $('#m_reg_usuario_app');
    }

    var init = function() {
        initVars();
        jQueryEvts();
    }

    var jQueryEvts = function() {
        // txtNombres.blur(function() {
        //     txtUsuario.val(
        //         (txtNombres.val().charAt(0) + App.replaceAccents(txtApePat.val())).toLowerCase()
        //     );
        // });

        form.validator().on('submit', function(e) {
            if (!e.isDefaultPrevented()) {
                fi_usuario();
            }

            return false;
        });
    }

    var fi_usuario = function() {
        var data = $('#frmRegUsuario').serializeObject();
        data.class = 'UsuarioAppController';
        data.method = 'create';
        console.log(data);
        $.ajax({
            url: path_ws,
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response) {
                $.post("usuarios_app.php", { txtUsuarioId: response.persona_id }, function(html) {
                    $(html).insertBefore('#tblUsuariosApp > tbody > tr:first');
                }).done(function() {
                    App.toaster('Notificaci�n de registro', 'Usuario APP registrado', 'success');
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