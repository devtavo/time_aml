<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
date_default_timezone_set("America/Lima");
require_once '../../php/mpdf/vendor/autoload.php';
require_once '../../php/PgSql.php';
require_once '../../php/class/IncidenteController.php';

ob_clean();

$params = array();

if(isset($_GET['data'])){	
	$params = (object) json_decode($_GET['data']);
}

$mpdf = new \Mpdf\Mpdf([
	'default_font_size' => 9,
	'default_font' => 'dejavusans',
	'mode' => 'c',
	'margin_left' => 32,
	'margin_right' => 25,
	'margin_top' => 25,
	'margin_bottom' => 20,
	'margin_header' => 10,
	'margin_footer' => 10,
	'debug' => true
]);
$mpdf->mirrorMargins = 0;

$mpdf->WriteHTML(pdf_cover($params));
$mpdf->SetHTMLHeader(pdf_header());
//$mpdf->AddPage();
$mpdf->SetHTMLFooter(pdf_footer());
$mpdf->WriteHTML(pdf_body($params));
$mpdf->Output();

function pdf_header(){
	return '<table width="100%" border="0" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;">
		<tr>
			<td width="33%" style="vertical-align:middle;color:#000">
				Informe de mapa del delito
			</td>
			<td width="33%" align="center">
				<img src="../../assets/app/img/logo_small.png" width="126px" />
			</td>
			<td width="33%" style="vertical-align:middle;text-align: right;color:#000;">
				' . date("d/m/Y H:i") . '
			</td>
		</tr>
	</table>';
}

function pdf_footer(){
	return '<table width="100%" border="0" style="font-size:7.5pt;">
		<tr>
			<td style="color: #686668">
				Av. Alameda de los Incas Nro. 253, Qhapac ñan – Cajamarca
				<br>(076) 599 250 • centroatencionciudadano@municaj.gob.pe • www.municaj.gob.pe
			</td>
			<td align="right">
				Página <span style="font-size:9pt;">{PAGENO}</span>
			</td>
		</tr>
	</table>';
}

function pdf_cover($params){
	return '
	<style>
		table {
		  border-collapse: collapse;
		}
		tr {
		  border: none;
		}
		td:first-child {
		  border-right: solid 1px #f00;			  
		}		
	</style>
	<div style="border:0px solid black;height:150px;text-align: center;">
		<img src="../../assets/app/img/logo_small.png" style="opacity: 0.5;" />
	</div>
	<div style="border:0px solid black;height:100px;font-size:15px;text-align: center;">
		<B>DOCUMENTO</B>
		<br>Informe de mapa del delito
	</div>
	<div style="border:0px solid black;height:500px;text-align: left;font-size:12px;margin-left:55px;">
		<p><b>Criterios de búsqueda:</b></p>
		' .criterio_busqueda($params) . '
	</div>
	<div style="border:0px solid black;height:100px;">
		<table id="tblFooter" width="100%" border="1">
			<tr>
				<td width="33%" align="center" style="color: #9c9c9c;">CREADO POR</td>
				<td width="33%" align="center" style="color: #9c9c9c;">FECHA Y HORA</td>
				<td width="33%" align="center" style="color: #9c9c9c;">USUARIO</td>
			</tr>
			<tr>
				<td width="33%" align="center">MP Cajamarca</td>
				<td width="33%" align="center">' . date("d/m/Y H:i") . '</td>
				<td width="33%" align="center">' . (isset($_SESSION['user']) ? $_SESSION['user'] : '-') . '</td>
			</tr>
		</table>
	</div>';
}

function pdf_body($params){
	$where = array();
	
	if(isset($params->ddlClasificacion) && count($params->ddlClasificacion) > 0){
		array_push($where, "clasificacion_incidente_id in(" . join(",", $params->ddlClasificacion) . ")");
	}
	
	if(isset($params->ddlSector) && isset($params->ddlSector) > 0){
		array_push($where, "sector_id in (" . join(",", $params->ddlSector) . ")");
	}
	
	if(isset($params->txtFecRegistro) && strlen($params->txtFecRegistro) > 0){
		$txtFecRegistro = explode(" ", $params->txtFecRegistro);
		if(count($txtFecRegistro) == 3){
			$_txtFecIni = explode("/", $txtFecRegistro[0]);
			$_txtFecFin = explode("/", $txtFecRegistro[2]);
			
			$txtFecIni = $_txtFecIni[2].'-'.$_txtFecIni[1].'-'.$_txtFecIni[0];
			$txtFecFin = $_txtFecFin[2].'-'.$_txtFecFin[1].'-'.$_txtFecFin[0];
			
			array_push($where, "fecha_registro AFTER " . $txtFecIni . "T00:00:00Z AND fecha_registro BEFORE " . $txtFecFin . "T23:59:59Z");
		}
	}

	$style  = '<style>		
		.table {			
			border-collapse: collapse;
			border:1px solid black;
		}
		.table td {
			padding-left: 10px;
			padding-right: 10px;
			min-height: 10px;
			line-height: 15px;
		}
		.text-center {
			text-align: center;
		}
		.text-right {
			text-align: right;
		}
		.text-justify {
			text-align: justify;
		}
		.table thead th {		
			background-color: #f1f1f1;
			border-color: #f1f1f1;
			height: 15px;
		}
		.table tbody td {
			border-bottom: 1px solid #ddd;
			padding-left: 10px;
			border-color: #f1f1f1;
			height: 15px;
		}
		.dot {
			height: 12px;
			width: 12px;			
			border-radius: 50%;
			display: inline-block;
		}
		.dot_pendiente {
			background-color: #FF0000;
		}
		.dot_proceso {
			background-color: #FFFF00;
		}
		.dot_concluido {
			background-color: #008F39;
		}
	</style>';
	
	$html  = $style;
	$html .= '<pagebreak orientation="landscape" />';
	
	$geoserver_path = 'http://95.217.44.43:8080/geoserver/cajamarca/wms?service=WMS&version=1.1.0&request=GetMap&';
	
	$inc_pendientes = '<img src="' . $geoserver_path . 'layers=mapa_cajamarca,cajamarca:sectores,cajamarca:incidencias_pendientes&styles=&bbox=-78.5368613159144,-7.211527,-78.4386264,-7.11058029473683&width=850&height=750&srs=EPSG:4326&format=image%2Fpng&CQL_FILTER=1=1;1=1;' . (count($where) > 0 ? join(" and ", $where) : '1=1') . '"/>';
	
	$inc_proceso = '<img src="' . $geoserver_path . 'layers=mapa_cajamarca,cajamarca:sectores,cajamarca:incidencias_proceso&styles=&bbox=-78.5367502715042,-7.211527,-78.4386264,-7.11161400543928&width=850&height=750&srs=EPSG:4326&format=image%2Fpng&CQL_FILTER=1=1;1=1;' . (count($where) > 0 ? join(" and ", $where) : '1=1') . '"/>';
	
	$inc_concluido = '<img src="' . $geoserver_path . 'layers=mapa_cajamarca,cajamarca:sectores,cajamarca:incidencias_concluido&styles=&bbox=-78.5365295858682,-7.211527,-78.4386264,-7.11058029473683&width=850&height=750&srs=EPSG:4326&format=image%2Fpng&CQL_FILTER=1=1;1=1;' . (count($where) > 0 ? join(" and ", $where) : '1=1') . '"/>';
	
	$inc_total = '<img src="' . $geoserver_path . 'layers=mapa_cajamarca,cajamarca:sectores,cajamarca:incidencias_pendientes,cajamarca:incidencias_proceso,cajamarca:incidencias_concluido&styles=&bbox=-78.5368613159144,-7.211527,-78.4386264,-7.11058029473683&width=850&height=750&srs=EPSG:4326&format=image%2Fpng&CQL_FILTER=1=1;1=1;' . (count($where) > 0 ? join(" and ", $where) : '1=1') . ';' . (count($where) > 0 ? join(" and ", $where) : '1=1') . ';' . (count($where) > 0 ? join(" and ", $where) : '1=1') . '"/>';
	
	$logo_pendiente = '&nbsp;<span class="dot dot_pendiente"></span>'; 
	$logo_proceso   = '&nbsp;<span class="dot dot_proceso"></span>';
	$logo_concluido = '&nbsp;<span class="dot dot_concluido"></span>';
	
	if(isset($params->ddlEstado)){
		if(in_array("P", $params->ddlEstado)){
			$html.= '<h3>Mapa de Incidencias pendientes ' . $logo_pendiente . '</h3> 
			<table class="table" border="0" width="100%">
				<tr>
					<td valign="top">' . tbl_inc_det($params, 'P') . '</td>
					<td width="80%">' . $inc_pendientes . '</td>
				</tr>
			</table>
			<pagebreak/>';
		}
		if(in_array("T", $params->ddlEstado)){
			$html.= '<h3>Mapa de Incidencias en proceso' . $logo_proceso . '</h3>
			<table class="table" border="0" width="100%">
				<tr>
					<td valign="top">' . tbl_inc_det($params, 'T') . '</td>
					<td width="80%">' . $inc_proceso . '</td>
				</tr>
			</table>
			<pagebreak/>';
		}
		if(in_array("C", $params->ddlEstado)){
			$html.= '<h3>Mapa de Incidencias concluidas' . $logo_concluido . '</h3>
			<table class="table" border="0" width="100%">
				<tr>
					<td valign="top">' . tbl_inc_det($params, 'C') . '</td>
					<td width="80%">' . $inc_concluido . '</td>
				</tr>
			</table>';
		}
	}else{
		$html.= '<h3>Mapa de Incidencias pendientes' . $logo_pendiente . '</h3>
		<table class="table" border="0" width="100%">
			<tr>
				<td valign="top">' . tbl_inc_det($params, 'P') . '</td>
				<td width="80%">' . $inc_pendientes . '</td>
			</tr>
		</table>';
		
		$html.= '<h3>Mapa de Incidencias en proceso' . $logo_proceso . '</h3>
		<table class="table" border="0" width="100%">
			<tr>
				<td valign="top">' . tbl_inc_det($params, 'T') . '</td>
				<td width="80%">' . $inc_proceso . '</td>
			</tr>
		</table>';
		
		$html.= '<h3>Mapa de Incidencias concluidas' . $logo_concluido . '</h3>
		<table class="table" border="0" width="100%">
			<tr>
				<td valign="top">' . tbl_inc_det($params, 'C') . '</td>
				<td width="80%">' . $inc_concluido . '</td>
			</tr>
		</table>';
	}
	
	$html.= '<h3>Mapa de incidencias pendientes' . $logo_pendiente . ', en proceso' . $logo_proceso . ' y concluidas' . $logo_concluido . '</h3>
		<table class="table" border="0" width="100%">
			<tr>
				<td valign="top">' . tbl_inc_total($params) . '</td>
				<td width="70%">' . $inc_total . '</td>
			</tr>
		</table>';
	
	return '<body>' . $html . '</body>';die;
}

function criterio_busqueda($params){
	$html = '';
	
	if(count((array)$params)){
		if(isset($params->ddlClasificacion) && count($params->ddlClasificacion) > 0){
			$html.= '<ul><li>Clasificación de incidencia</li>';
			$html.= '<ul>';
				foreach($params->ddlClasificacion as $tipo){
					switch($tipo){
						case 8; $html.= '<li>Accidentes</li>'; break;
						case 7; $html.= '<li>Apoyo de seguridad</li>'; break;
						case 5; $html.= '<li>Delito</li>'; break;
						case 9; $html.= '<li>Falta</li>'; break;
						case 6; $html.= '<li>Queja</li>'; break;
						default: $html.= '<li>Todos</li>';
					}
				}
			$html.= '</ul></ul>';
		}
		
		if(isset($params->ddlEstado) && count($params->ddlEstado) > 0){
			$html.= '<ul><li>Estado</li>';
			$html.= '<ul>';
				foreach($params->ddlEstado as $estado){
					switch($estado){
						case 'P'; $html.= '<li>Pendiente</li>'; break;
						case 'T'; $html.= '<li>Proceso</li>'; break;
						case 'C'; $html.= '<li>Concluido</li>'; break;			default: $html.= '<li>Todos</li>';
					}
				}
			$html.= '</ul></ul>';
		}
		
		if(isset($params->ddlSector) && count($params->ddlSector) > 0){
			$tmp  = array();
			$html.= '<ul><li>Sector</li>';
			$html.= '<ul><li>';			
			foreach($params->ddlSector as $sector){
				array_push($tmp, "S" . $sector);					
			}
			$html.= join(",", $tmp);
			$html.= '</li></ul></ul>';
		}
		
		if(isset($params->txtFecRegistro) && strlen($params->txtFecRegistro) > 0){
			$txtFecRegistro = explode(" ", $params->txtFecRegistro);
			if(count($txtFecRegistro) == 3){			
				$html.= '<ul><li>Rango de fechas</li>';
				$html.= '<ul><li> ' . $txtFecRegistro[0] . ' - ' . $txtFecRegistro[2] . '</li>';
				$html.= '</ul></ul>';
				
			}
		}
	}
	
	return $html;
}

function tbl_inc_det($params, $status){
	$instance = new IncidenteController();
	$fs_incidente = $instance->geoserver_incidentes($params, $status);
	
	$html = '';
	$html.= '<table width="100%" border="0">
		<thead>
			<tr>
				<th>Sector</th>
				<th>Total</th>
				<th>Porcentaje</th>
			</tr>
		</thead>
		<tbody>';
		foreach($fs_incidente as $incidente){
			$html.= '<tr><td>' . $incidente->sector_id . '</td>
			<td class="text-right">' . $incidente->cant . '</td>
			<td class="text-right">' . $incidente->porcentaje . '%</td>
			</tr>';
		}
		$html.= '<tr><td><b>Total</b></td>
		<td class="text-right">' . array_sum(array_column($fs_incidente,'cant')) . '</td>
		<td class="text-right">' . round(array_sum(array_column($fs_incidente,'porcentaje'))) . '%</td>
		</tr>';
	$html .= '</thead>
	</table>';
	
	return $html;
}

function tbl_inc_total($params){
	$instance = new IncidenteController();
	$fs_incidente = $instance->geoserver_incidentes_t($params);
	
	$html = '';
	$html.= '<table width="100%" border="0">
		<thead>
			<tr>
				<th>Sector</th>
				<th>Pendiente</th>
				<th>Proceso</th>
				<th>Concluido</th>
				<th>Total</th>
				<th>Porcentaje</th>
			</tr>
		</thead>
		<tbody>';
		foreach($fs_incidente as $incidente){
			$html.= '<tr><td>' . $incidente->sector_id . '</td>
			<td class="text-right">' . $incidente->pendientes . '</td>
			<td class="text-right">' . $incidente->en_proceso .'</td>
			<td class="text-right">' . $incidente->atendidas .'</td>
			<td class="text-right">' . $incidente->total .'</td>
			<td class="text-right">' . $incidente->porcentaje . '%</td>
			</tr>';
			
		}
		$html.= '<tr><td><b>Total</b></td>
		<td class="text-right">' . array_sum(array_column($fs_incidente,'pendientes')) . '
		</td><td class="text-right">' . array_sum(array_column($fs_incidente,'en_proceso')) . '</td>
		<td class="text-right">' . array_sum(array_column($fs_incidente,'atendidas')) . '</td>
		<td class="text-right">' . array_sum(array_column($fs_incidente,'total')) . '</td>
		<td class="text-right">' . round(array_sum(array_column($fs_incidente,'porcentaje'))) . '%</td>
		</tr>';
	$html .= '</thead>
	</table>';
	
	return $html;
}