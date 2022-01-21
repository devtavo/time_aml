var AppCreateUsers = function () {
	var form;
	var m_reg_usuario;
	
	var initVars = function () {		
		form = $('#frmRegUsuario');
		txtNombres    = $("[name='txtNombres']");
		txtApePat	  = $("[name='txtApePat']");
		txtUsuario	  = $("[name='txtUsuario']");
		m_reg_usuario = $('#m_reg_usuario');
	}
	
	var init = function () {
		initVars();
		jQueryEvts();
	}
	
	var jQueryEvts = function () {
		txtNombres.blur(function() {
			txtUsuario.val(
				(txtNombres.val().charAt(0) + App.replaceAccents(txtApePat.val())).toLowerCase()
			);
		});
		
		form.validator().on('submit', function (e) {
			if (!e.isDefaultPrevented()) {
				fi_usuario();				
			}
			
			return false;
		});
	}
	
	var fi_usuario = function () {
		var data    = $('#frmRegUsuario').serializeObject();
		data.class  = 'UsuarioController';
		data.method = 'create';		
		
		$.ajax({
			url:  path_ws,
			type: 'post',
			dataType : 'json',
			data: data,
			success: function (response) {				
				$.post("usuarios.php", { txtUsuarioId: response.usuario_id }, function(html) {					
					$(html).insertBefore('#tblUsuarios > tbody > tr:first');
				}).done(function() {
					App.toaster('Notificación de registro', 'Usuario registrado', 'success');
					m_reg_usuario.modal('hide');
				});				
			}
		});
	}
	
	return {				
		init: function () {
			return init();
		}
	}	
} ();