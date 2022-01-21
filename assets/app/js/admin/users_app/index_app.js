var AppIndexUsers_app = function() {
    var m_reg_usuario_app = $('#m_reg_usuario_app');

    var init = function() {
        jQueryEvts();
    }

    var jQueryEvts = function() {
        $(document).on('click', '[name="btnRegUsuario"]', function(e) {
            fs_usuario({
                php: 'create_app.php',
                params: {

                }
            });
        });

        $(document).on('click', '[name="btnEditar[]"]', function(e) {
            var tr = $(this).closest('tr');
            var persona_id = Number(tr.attr('data-id'));

            fs_usuario({
                php: 'edit_app.php',
                params: {
                    persona_id: persona_id
                }
            });
        });

        $(document).on('click', '[name="btnEliminar[]"]', function(e) {
            var tr = $(this).closest('tr');
            var usuario_id = Number(tr.attr('data-id'));

            fd_usuario({
                params: {
                    persona_id: persona_id
                }
            });
        });
    }

    var fs_usuario = function(obj) {
        $.get(path_root + "/admin/user_app/" + obj.php, obj.params, function(data) {
            m_reg_usuario_app.find('.modal-content').html(data);
            m_reg_usuario_app.modal('show');
        }).done(function() {
            if (obj.php == 'create_app.php') {
                AppCreateUsers_app.init();
            } else if (obj.php == 'edit_app.php') {
                AppEditUsers_app.init();
            }
        });
    }

    var fd_usuario = function(obj) {
        var result = confirm("¿Está seguro que desea eliminar?");
        if (result) {
            $.ajax({
                url: path_ws,
                type: 'post',
                dataType: 'json',
                data: {
                    class: 'UsuarioAppController',
                    method: 'delete',
                    usuario_id: obj.params.persona_id
                },
                success: function(response) {
                    $('#tblUsuariosApp tr[data-id="' + obj.params.persona_id + '"]').remove();
                }
            });
        }
    }

    return {
        init: function() {
            return init();
        }
    }
}();