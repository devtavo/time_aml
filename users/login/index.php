<?php
	session_start();
	if(isset($_SESSION['user_id'])){
		header('Location: ../login/index.php'); 
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>SIAE - Iniciar sesión</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicond.ico"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">	
	<link rel="stylesheet" type="text/css" href="../../assets/app/css/util_login.css">
	<link rel="stylesheet" type="text/css" href="../../assets/app/css/main_login.css">
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url(../../assets/app/img/bg-01.jpg);">
					<span class="login100-form-title-1">
						Iniciar sesión
					</span>
				</div>

				<form method="post" action="post_login.php" class="login100-form validate-form">
					<?php if(isset($_GET['e']) || isset($_GET['s'])){ ?>
					<div class="flex-sb-m w-full">
						<div class="alert alert-danger fade in alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
							<strong>Error!</strong> 
							<?php echo isset($_GET['e']) ? 'Usuario o contraseña incorrectos.' : '';?>
							<?php echo isset($_GET['s']) ? 'Debes iniciar sesión para acceder al sistema.' : '';?>
						</div>
					</div>
					<?php } ?>
					
					<div class="wrap-input100 validate-input m-b-26" data-validate="Ingrese usuario">
						<span class="label-input100">Usuario</span>
						<input class="input100" type="text" name="txtUsuario" placeholder="Ingrese usuario">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-18" data-validate = "Ingrese clave">
						<span class="label-input100">Contraseña</span>
						<input class="input100" type="password" name="txtContrasena" placeholder="Ingrese clave">
						<span class="focus-input100"></span>
					</div>

					<div class="flex-sb-m w-full p-b-30">
						<div class="contact100-form-checkbox" style="display: none;">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Recordar usuario
							</label>
						</div>

						<!-- <div>
							<a href="#" class="txt1">
								¿Olvidaste tu contraseña?
							</a>
						</div> -->
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn center-block">
							Acceder
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="../../assets/app/js/login.js"></script>	
</body>
</html>