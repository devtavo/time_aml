<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

$query = $_SERVER['PHP_SELF'];
$path  = pathinfo($query);
$what_you_want = '/siae' . $path['dirname'] . '/' . $path['basename'];

?>
<div class="logo">
	<center><img src="../../assets/app/img/logo.png" width="160px" height="48px" alt=""></center>


</div>
<!-- <div class="header-content-center">
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Navegación</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">
					<center><img src="../../assets/app/img/logo.png" width="160px" height="48px" alt=""></center>
				</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li class="<?php echo $what_you_want == '/siae/users/incidentes/index.php' ? 'active' : ''; ?>">
						<a href="../incidentes/index.php"></a>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
						Anonimo<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li class="disabled"><a href="#">Mis datos</a></li>
						<li class="disabled"><a href="#">Cambiar contraseña</a></li>								
						<li role="separator" class="divider"></li>
						<li><a href="../login/cerrar_sesion2.php">Cerrar sesión</a></li>								
					</ul>
				</li>
			</ul>
			</div>
		</div>
	</nav>
</div> -->