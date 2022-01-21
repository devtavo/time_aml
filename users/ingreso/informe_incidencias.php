<?php
require_once '../../php/mpdf/vendor/autoload.php';
require_once '../../php/PgSql.php';
require_once '../../php/class/IncidenteController.php';

if(!isset($_GET['id']) || strlen($_GET['id']) == 0){
	die("Identificador de incidencia no encontrado.");
}

$incidencia_id = $_GET['id'];

$mpdf = new \Mpdf\Mpdf([
	'default_font_size' => 9,
	'default_font' => 'dejavusans',
	'mode' => 'c',
	'margin_left' => 32,
	'margin_right' => 25,
	'margin_top' => 25,
	'margin_bottom' => 20,
	'margin_header' => 10,
	'margin_footer' => 10
]);
$mpdf->mirrorMargins = 0;

$mpdf->WriteHTML(pdf_cover($incidencia_id));
$mpdf->SetHTMLHeader(pdf_header($incidencia_id));
$mpdf->AddPage();
$mpdf->SetHTMLFooter(pdf_footer());
$mpdf->WriteHTML(pdf_body($incidencia_id));
$mpdf->Output();

function pdf_header($incidencia_id){
	return '<table width="100%" border="0" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;">
		<tr>
			<td width="33%" style="vertical-align:middle;color:#000">
				Informe de Incidencia N° ' . $incidencia_id . '
			</td>
			<td width="33%" align="center">
				<img src="../../assets/app/img/logo_small.png" width="126px" />
			</td>
			<td width="33%" style="vertical-align:middle;text-align: right;color:#000;">
				' . date("d/m/Y") . '
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

function pdf_cover($incidencia_id){
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
	<div style="text-align: center;">
	<img src="../../assets/app/img/logo_small.png" style="opacity: 0.5; margin-top: 110px;" />
	</div>
	<div style="text-align: center; margin-top: 450px;">
		<B>DOCUMENTO</B>
		<br>Informe de Incidencia N° ' . $incidencia_id . '
		<br>
		<br>
		<br>
		<table id="tblFooter" width="100%" border="1">
			<tr>
				<td width="33%" align="center" style="color: #9c9c9c;">CREADO POR</td>
				<td width="33%" align="center" style="color: #9c9c9c;">FECHA</td>
				<td width="33%" align="center" style="color: #9c9c9c;">VERSIÓN</td>
			</tr>
			<tr>
				<td width="33%" align="center">MP Cajamarca</td>
				<td width="33%" align="center">' . date("d/m/Y") . '</td>
				<td width="33%" align="center">1.0</td>
			</tr>
		</table>
	</div>';
}

function pdf_body($incidencia_id){	
	$instance = new IncidenteController();
	$fs_incidente = $instance->informe_incidente((object) ['incidente_id' => $incidencia_id]);	
	
	$style  = '<style>		
		.table {			
			border-collapse: collapse;
			border:1px solid black;
		}
		.table td {
			padding-left: 10px;
			padding-right: 10px;
			min-height: 10px;
			line-height: 2;
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
	</style>';
	
	$html  = $style;
	
	$table = '';
	
	$table.= '<div class="text-center"><h2>Incidente N° ' . $incidencia_id . '</h2></div>';
	
	$table.= '<table class="table" border="0" width="100%">
		<tr>
			<td><b>Fecha y hora de registro</b></td>
			<td><b>Origen</b></td>
			<td><b>Estado</b></td>
		</tr>
		<tr>
			<td>' . $fs_incidente->fecha_registro . '</td>
			<td>' . $fs_incidente->origen . '</td>
			<td>' . $fs_incidente->estado . '</td>
		</tr>
		<tr>
			<td><b>Nro. doc. identidad</b></td>
			<td><b>Denunciante</b></td>
			<td><b>Teléfono de contacto</b></td>
		</tr>
		<tr>
			<td>' . $fs_incidente->nro_doc_identidad . '</td>
			<td>' . $fs_incidente->ciudadano . '</td>
			<td>' . $fs_incidente->nro_telefono . '</td>
		</tr>
		<tr>
			<td><b>Clasificación</b></td>
			<td><b>Tipo</b></td>
			<td><b>Subtipo</b></td>
		</tr>
		<tr>
			<td>' . $fs_incidente->clasificacion_inc . '</td>
			<td>' . $fs_incidente->tipo_inc . '</td>
			<td>' . $fs_incidente->sub_tipo_inc . '</td>
		</tr>
		<tr>
			<td colspan="3"><b>Descripción de la incidencia</b></td>
		</tr>
		<tr>
			<td colspan="3" align="justify">' . $fs_incidente->incidencia_descripcion . '</td>			
		</tr>
		<tr>
			<td colspan="2"><b>Dirección</b></td>
			<td><b>Coordenadas</b></td>
		</tr>
		<tr>
			<td colspan="2">' . $fs_incidente->incidencia_direccion . '</td>
			<td>' . $fs_incidente->latitud . ', ' . $fs_incidente->longitud . '</td>
		</tr>
		<tr>
			<td><b>Nro.</b></td>
			<td><b>Interior</b></td>
			<td><b>Lote</b></td>
		</tr>
		<tr>
			<td>' . $fs_incidente->direccion_nro . '</td>
			<td>' . $fs_incidente->direccion_interior . '</td>
			<td>' . $fs_incidente->direccion_lote . '</td>
		</tr>
		<tr>
			<td colspan="3"><b>Referencia</b></td>
		</tr>
		<tr>
			<td colspan="3">' . $fs_incidente->direccion_referencia . '</td>
		</tr>
		<tr>
			<td colspan="3"><b>Ubicación de la incidencia</b></td>
		</tr>
		<tr>
			<td colspan="3">
				<img src="http://localhost/siae/php/static_maps/map.php?marker[]=lat:' . $fs_incidente->latitud . ';lng:' . $fs_incidente->longitud . ';icon:large-red-cutout&basemap=streets&width=550&height=350&zoom=18"/>
			</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
	</table>';
	$html.= $table;
	
	//echo '<body>' . $html . '</body>';die;
	return '<body>' . $html . '</body>';
}