<?php
session_start();
require '../../php/MySql.php';
require '../../php/class/UsuarioController.php';

if(! empty($_POST)){	
	if(isset($_POST['txtUsuario']) && isset($_POST['txtContrasena'])) {
		$user = isset($_POST['txtUsuario'])    ? $_POST['txtUsuario'] : '';
		$pass = isset($_POST['txtContrasena']) ? $_POST['txtContrasena'] : '';
		
		$fs_usuario = UsuarioController::login($user, $pass);
var_dump($fs_usuario);
die;
		if(count($fs_usuario) > 0){
			$fs_usuario = $fs_usuario{0};
			
			$_SESSION['is_admin'] = $fs_usuario->esadmin == 't' ? true : false;
			$_SESSION['user_id']  = (int) $fs_usuario->usuario_id;			
			$_SESSION['user']     = $fs_usuario->nombres . ' ' . $fs_usuario->apellido_paterno;
			$_SESSION['permisos'] = json_decode($fs_usuario->permisos);
			
			UsuarioController::ultimoAcceso((int) $fs_usuario->usuario_id);
			header('Location: ../gastos/index.php'); 
			if($fs_usuario->esadmin == 'f'){				
				header('Location: ../gastos/index.php'); 
			}elseif ($fs_usuario->esadmin == 't') {
				header('Location: ../gastos/index.php'); 
			}
		}else{
			header('Location: index.php?e');
		}
    }
}else{
	header('Location: index.php'); 
}
?>