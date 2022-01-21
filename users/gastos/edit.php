<?php
$webconfig = include("../../webconfig.php");
require_once($webconfig['path_ws']);

if (count($_GET) > 0) {
	$params		  = (object)$_GET;

	// $fs_incidente = callFunction((object) ['class' => 'IncidenteController', 'method' => 'findById', 'incidente_id' => $params->incidente_id]);	
	// $fs_ciudadano = callFunction((object) ['class' => 'CiudadanoController', 'method' => 'findById', 'nro_telefono' => $fs_incidente->telefono]);
	// $fs_clasf_inc = callFunction((object) ['class' => 'MultitablaController', 'method' => 'index', 'tabla' => 'ssc_clasificacion_inc']);
	// $fs_tipo_inc  = callFunction((object) ['class' => 'MultitablaController', 'method' => 'index', 'tabla' => 'ssc_tipo_inc', 'padre_id' => $fs_incidente->clasificacion_inc_id]);
	// $fs_subtipo_inc  = callFunction((object) ['class' => 'MultitablaController', 'method' => 'index', 'tabla' => 'ssc_subtipo_inc', 'padre_id' => $fs_incidente->tipo_incidente_id]);
?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Certificado nro° </h4>
	</div>
	<div class="modal-body">

		<div class="contenedor">
			<img src="../../assets/app/img/fondo2.png" width="100%" height="100%" alt="">
			<div class="texto-encima">

				<img src="../../assets/app/img/logocert.png">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-8 cabecera"><br><br>EL INSTITUTO DE REALIZACIÓN ACADÉMICA S.A.C.</div>
							</div>
							<div class="row">
								<div class="col-lg-6 cabecera">CERTIFICA QUE:</div>
							</div>
							<div class="row">
								<div class="col-lg-10 nombre"><br>Alex tordoya tprdoya tordoya</div>
							</div>
							<div class="row">
								<div class="col-lg-5 "><hr style="border: 1px solid #16837D;"></div>
							</div>
							
							<div class="row">
								<div class="col-lg-5 curso">APROBÓ SATISFACTORIAMENTE EL CURSO – TALLER EN PLANEAMIENTO, PRESUPUESTO PÚBLICO, CONTROL Y CONTRATACIONES PÚBLICAS, DESARROLLADO DEL 06 DE JULIO AL 07 DE AGOSTO DE 2020 CON UN TOTAL DE 80 HORAS ACADÉMICAS </div>
							</div>
							<div class="row">
								<div class="col-lg-6"><img src="../../assets/app/img/firma.png"></div>
							</div>
							<div class="row">
								<div class="col-lg-10 text-right fecha">Lima, 18 de agosto de 2020<br></div>
							</div><br>
							<div class="row">
								<div class="col-lg-12 footer"><p>El presente certificado y las firmas consignadas en ella han sido emitidas a través de medios digitales, al amparo de lo dispuesto en el
									artículo 141-A del Código Civil: "Artículo 141-A.- En los casos en que la ley establezca que la manifestación de voluntad debe hacerse
									a través de alguna formalidad expresa o requerida de firma, ésta podrá ser generada o comunicada a través de medios electrónicos,
									ópticos o cualquier otro análogo. Tratándose de instrumentos públicos, la autoridad competente deberá dejar constancia del medio
									empleado y conservar una versión íntegra para su ulterior consulta ."</p></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>