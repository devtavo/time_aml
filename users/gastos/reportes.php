<!DOCTYPE html>
<html>
<head>
	<title>SIAE - Registro de Incidentes</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css"/>
	<link rel="stylesheet" href="../../assets/app/css/app.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<img src="../../assets/app/img/logo.png">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Reportes</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-4">
								<div class="panel panel-default">
									<div class="panel-body">
										<div id="incidente_x_tipo"></div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="panel panel-default">
									<div class="panel-body">
										<div id="incidente_x_dia"></div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="panel panel-default">
									<div class="panel-body">
										<div id="incidente_x_hora"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4">
								<div class="panel panel-default">
									<div class="panel-body">
										<div id="incidente_x_sector"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://code.highcharts.com/highcharts.js"></script>
	<script type="text/javascript" src="https://code.highcharts.com/modules/exporting.js"></script>
	<script type="text/javascript" src="https://code.highcharts.com/modules/export-data.js"></script>
	<script type="text/javascript" src="../../assets/app/js/app.js"></script>
	<script type="text/javascript" src="../../assets/app/js/users/incidentes/reportes.js"></script>
	<script>
		$(document).ready(function() {			
			AppReportesIncidente.init();
		});
	</script>
</body>
</html>