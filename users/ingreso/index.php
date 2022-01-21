<?php 
// session_destroy();

?>

<!DOCTYPE html>

<html lang="en">

<head>
	<title>CFC FOREM </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="assets/login/images/logoe.ico" type="image/png" />

	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="assets/login/images/icons/icon.png" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/login/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/login/vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/login/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" href="assets/toastr/toastr.css">
	<!-- Estiilos de los Alertasd -->
	<link rel="stylesheet" href="assets/sweetalert2/sweetalert2.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/login/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/login/css/main.css">
	<!--===============================================================================================-->
</head>

<body>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('assets/login/images/fondo-azul-marino.png');">
			<div class="wrap-login100 p-l-25 p-r-25 p-t-20 p-b-20">
				<div class="login100-form validate-form flex-sb flex-w">
					<div style="text-align: center;">
						<img src="assets/login/images/forem_lgoo.png" align="center" style="width: 100%; padding-left: 10px;">
					</div>
					<span class="login100-form-title p-b-15 ">
						Acceso
					</span>
					<div class="wrap-input100 validate-input m-b-8" data-validate="Usuario es requerido">
						<input class="input100" type="text" name="usuario" id="txtusu" placeholder="Usuario">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate="Password es requerido">
						<input class="input100" type="password" name="pass" id="txtpwd" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
					</div>
					<div class="container-login100-form-btn m-t-15">
						<button class="login100-form-btn" onclick="prueba();">
							Acceder
						</button>
					</div>

					<div class="w-full text-center p-t-10">

					</div>
					<div class="text-center w-full  p-t-05">
						<span class="txt2">
							Copyright © 2021 - CFC FOREM 
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!--===============================================================================================-->
	<script src="assets/login/vendor/jquery/jquery-3.2.1.min.js"></script>

	<!--===============================================================================================-->
	<script src="assets/login/vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="assets/login/vendor/bootstrap/js/popper.js"></script>
	<script src="assets/login/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<!--===============================================================================================-->
	<script src="assets/toastr/toastr.min.js"></script>
	<script src="assets/sweetalert2/sweetalert2.min.js"></script>
	<!--<script src="assets/app/js/login.js"></script>-->

	<script>
		function prueba() {
			var usu = document.getElementById('txtusu').value;
			var pwd = document.getElementById('txtpwd').value;
			var dato;
			if (validarVacios(usu, pwd) != 0) {
				var data = {};
				data.class = 'UsuarioController';
				data.method = 'sesione';
				data.usuario = usu;
				data.formulario='ingreso';
				// console.log(data);
				$.ajax({
					url: '../../php/ws.php',
					type: 'POST',
					dataType: 'json',
					data: data,
					success: function(response) {						
					}
				});
				$.ajax({
					url: 'session.php',
					data: {
						user: usu,
						pass: pwd,
						action: 'login'
					},
					type: 'POST',
					dataType: 'json',
					success: function(json) {
						console.log(json);
						if (Object.keys(json).length > 0) {
							Swal.fire({
								icon: 'success',
								title: 'Bienvenido al Sistema',
								text: json.data,
								showConfirmButton: false,
							});

							setTimeout(function() {
								window.location.href = "../../formulario.php?user="+usu;
							}, 100);
						}
					},
					error: function(xhr, status) {
						Swal.fire({
							icon: 'error',
							title: '',
							text: 'Las credenciales del Inicio de Session no se encuentran registradas.',
						});
					}
				});
			}
		}
		var validarVacios = function(usu, pwd) {
			var rpta = 0;
			if (usu.length == 0) {
				toastr.warning('El usuario no debe estar en blanco', 'Warning', {
					timeOut: 2000,
					closeButton: true,
					onclick: null,
					progressBar: true
				});
			} else if (pwd === '') {
				toastr.warning('La contrase&ntilde;a no debe estar en blanco', 'Warning', {
					timeOut: 2000,
					closeButton: true,
					onclick: null,
					progressBar: true
				});
			} else {
				rpta = 1;
			}
			return rpta;
		}
	</script>

</body>

</html>