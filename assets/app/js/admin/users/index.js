var AppIndexUsers = function () {	
	var m_reg_usuario = $('#m_reg_usuario');
	
	var init = function () {		
		jQueryEvts();
	}
	
	var jQueryEvts = function () {
		$(document).on('click', '[name="btnRegUsuario"]', function(e){
			fs_usuario({
				php: 'create.php',
				params: {
					
				}
			});
		});
		
		$(document).on('click', '[name="btnEditar[]"]', function(e){
			var tr = $(this).closest('tr');
			var usuario_id = Number(tr.attr('data-id'));
			
			fs_usuario({
				php: 'edit.php',
				params: {
					usuario_id : usuario_id
				}
			});
		});
		
		$(document).on('click', '[name="btnEliminar[]"]', function(e){
			var tr = $(this).closest('tr');
			var usuario_id = Number(tr.attr('data-id'));
			
			fd_usuario({				
				params: {
					usuario_id : usuario_id
				}
			});
		});
	}
	
	var fs_usuario = function (obj) {
		$.get(path_root + "/admin/users/" + obj.php, obj.params, function(data) {			
			m_reg_usuario.find('.modal-content').html(data);
			m_reg_usuario.modal('show');
		}).done(function() {
			if (obj.php == 'create.php') {
				AppCreateUsers.init();
			} else if (obj.php == 'edit.php') {
				AppEditUsers.init();
			}			
		});
	}
	
	var fd_usuario = function (obj) {
		var result = confirm("¿Está seguro que desea eliminar?");
		if (result) {
			$.ajax({
				url:  path_ws,
				type: 'post',
				dataType : 'json',
				data: {
					class      : 'UsuarioController',
					method     : 'delete',
					usuario_id : obj.params.usuario_id 
				},
				success: function (response) {				
					$('#tblUsuarios tr[data-id="' + obj.params.usuario_id + '"]').remove();			
				}
			});
		}
	}
	
	return {				
		init: function () {
			return init();
		}
	}	
} ();