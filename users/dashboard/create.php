<?php
$webconfig = include("../../webconfig.php");
require_once($webconfig['path_ws']);

//$fs_incidentes = callFunction((object) ['class' => 'IncidenteController', 'method' => 'index', 'ddlEstado' => array("R")]);
// $fs_ciudadano  = array();
// $url_params    = isset($_GET['data']) ? json_decode($_GET['data']) : false;
// $fs_clasf_inc = callFunction((object) ['class' => 'MultitablaController', 'method' => 'index', 'tabla' => 'ssc_clasificacion_inc']);
// $fs_tipo_inc  = callFunction((object) ['class' => 'MultitablaController', 'method' => 'index', 'tabla' => 'ssc_tipo_inc']);
// $fs_subtipo_inc  = callFunction((object) ['class' => 'MultitablaController', 'method' => 'index', 'tabla' => 'ssc_subtipo_inc']);
// $fs_origen_inc = callFunction((object) ['class' => 'MultitablaController', 'method' => 'index', 'tabla' => 'ssc_origen_inc']);
// 	if($url_params != false){
// //		$fs_ciudadano = callFunction((object) ['class' => 'CiudadanoController', 'method' => 'findById', 'nro_telefono' => $url_params->CALLERIDNUM]);

// 	}
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Validación de certificado</h4>
</div>
<div class="modal-body">
	<form id="frmCrearCaso" data-toggle="validator" role="form">
		<input type="text" id="txtIncidenteId" name="txtIncidenteId" value="<?php echo $params->incidente_id; ?>" class="hide" />
		<div class="row">
			<div class="col-lg-6">

				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">

							<div class="col-lg-4">
								<div class="form-group">
									<label>Codigo de verificacion</label>
									<input type="text" name="txtNroDocIde" class="form-control input-sm" value="<?php echo isset($_POST['txtNroDocIde']) ? $_POST['txtNroDocIde'] : ''; ?>" placeholder="Nro. documento del alumno">
								</div>
							</div>
							<div class="col-lg-8">
								<div class="form-group">
									<label>&nbsp;</label>
									<div class="row">
										<div class="col-lg-6">
											<input type="submit" name="btnBuscar" class="btn btn-primary btn-sm btn-block" value="Validar" />
										</div>
										<div class="col-lg-6">
											<input type="button" name="btnLimpiar" class="btn btn-sm btn-block" value="Limpiar" />
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<img src="../../assets/app/img/detalle.png" width="100%" heigth="100%"> 
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</form>
</div>