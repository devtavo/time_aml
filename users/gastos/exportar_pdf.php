<?php
require_once '../../php/mpdf/vendor/autoload.php';
require_once '../../php/jpgraph/jpgraph.php';
require_once '../../php/jpgraph/jpgraph_bar.php';
require_once '../../php/jpgraph/jpgraph_line.php';
require_once '../../php/jpgraph/jpgraph_pie.php';
require_once '../../php/jpgraph/jpgraph_pie3d.php';
require_once '../../php/PgSql.php';
require_once '../../php/class/GraficoController.php';

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

$mpdf->WriteHTML(pdf_cover());
$mpdf->SetHTMLHeader(pdf_header());
$mpdf->AddPage();
$mpdf->SetHTMLFooter(pdf_footer());
$mpdf->WriteHTML(pdf_body());
$mpdf->Output();

function pdf_header(){
	return '<table width="100%" border="0" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;">
		<tr>
			<td width="33%" style="vertical-align:middle;color:#000">
				Gráficos estadísticos
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

function pdf_cover(){
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
		<br>Gráficos estadísticos
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

function chart_bar($obj, $data){
	$groupGraph = array();
	$graph = new Graph(580,300,'auto');    
	$graph->SetScale('textlin');
	$graph->SetFrame(false);
	$graph->img->SetMargin(40,20,46,80);
	$graph->SetShadow();
	
	foreach($data->series as $serie){		
		$chart = new BarPlot($serie->data);
		$chart->SetLegend($serie->name);
		array_push($groupGraph, $chart);
	}
	
	$gbplot = new GroupBarPlot($groupGraph);
	$graph->Add($gbplot);
	
	if($obj->grafico == "incidente_x_tipo"){
		$arrEstados = array('#FF0000', '#FFFF00', '#008F39');
		
		for($i=0;$i<count($groupGraph);$i++){			
			$groupGraph[$i]->SetColor("#FFF");
			$groupGraph[$i]->SetFillColor($arrEstados[$i]);
		}
	}
	
	$categories = $data->xAxis->categories;
	
	$graph->title->Set($obj->title);
	$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);
	$graph->yaxis->title->Set($data->yAxis->title->text);	
	$graph->yaxis->title->SetMargin(5);
	$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
	 
	$graph->xaxis->SetTickLabels($categories);

	$graph->legend->SetFrameWeight(1);
	$graph->legend->SetColumns(6);
	$graph->legend->SetColor('#4E4E4E','#4e4e4e');
	$graph->legend->SetPos(0.5,0.95,'center','bottom');
	
	$img = $graph->Stroke(_IMG_HANDLER);
	ob_start();
	imagepng($img);
	$img_data = ob_get_contents();
	ob_end_clean();
	
	return '<img src="data:image/png;base64,'.base64_encode($img_data).'" style="margin-top:10px;"/>';
}

function pdf_body(){
	$style  = '<style>
		.table {
			margin-left: 30px;
			margin-right: 10px;
			border-collapse: collapse;
			margin-bottom: 1rem;
			color: #212529;
		}
		.table thead th {		
			background-color: #f1f1f1;
			border-color: #f1f1f1;
			height: 15px;
			text-align: center;
		}
		.table tbody td {
			border-bottom: 1px solid #ddd;
			padding-left: 10px;
			border-color: #f1f1f1;
			height: 15px;
		}
		.text-center {
			text-align: center;
		}
		.text-right {
			text-align: right;
		}
	</style>';
	
	$html   = $style;
	
	$graphs = array(
		(object) array('title' => 'Total de casos por tipo de incidente', 'grafico' => 'incidente_x_tipo'),
		(object) array('title' => 'Total de casos por día de la semana', 'grafico' => 'incidente_x_dia'),
		(object) array('title' => 'Total de casos por hora', 'grafico' => 'incidente_x_hora'),
		(object) array('title' => 'Total de casos por sector', 'grafico' => 'incidente_x_sector')
	);
	
	$params   = json_decode($_GET['data']);	
	$instance = new GraficoController();
	
	foreach($graphs as $graph){
		
		$fs_graficos = json_decode($instance->findById(
			(object) array_merge(array(
				'grafico' => $graph->grafico,
				'txtFecRegistro' => $params->txtFecRegistro
			), (array) $params)
		));
		
		$fs_tablas = $instance->findById(
			(object) array_merge(array(
				'grafico' => $graph->grafico,
				'txtFecRegistro' => $params->txtFecRegistro,
				'table' => true
			), (array) $params)
		);
		
		if(count($fs_tablas) > 0){
			$th = '';
			
			
			switch($graph->grafico){
				case 'incidente_x_tipo':
					$th = '<th>Categoría de Incidente</th>
						   <th>Pendientes</th>
						   <th>Proceso</th>
						   <th>Atendidos</th>
						   <th>Total</th>';
				break;
				case 'incidente_x_dia':
					$th = '<th>Día</th>
						   <th>Incidentes</th>';					
				break;
				case 'incidente_x_hora':
					$th = '<th>Hora</th>
						   <th>Incidentes</th>';					
				break;
				case 'incidente_x_sector':
					$th = '<th>Sector</th>
						   <th>Incidentes</th>';					
				break;
			}
			
			$table = '<table class="table" border="1" width="100%">';
				$table.= '<thead>
					<tr>						
						' . $th . '
					<tr>
				</thead><tbody>';
				
				foreach ($fs_tablas as $fs_tabla){
					switch($graph->grafico){
						case 'incidente_x_hora':
							$table.= '<tr>
							<td>' 
								. (sprintf('%02d', $fs_tabla->valor) . ':00') .
							'</td>';
						break;
						case 'incidente_x_sector':
							$table.= '<tr>
							<td>S' 
								. $fs_tabla->valor .
							'</td>';
						break;
						default:
							$table.= '<tr>
							<td>' 
								. $fs_tabla->valor .
							'</td>';
					}
						
					switch($graph->grafico){
						case 'incidente_x_tipo':
							$table.= '<td class="text-right">' . $fs_tabla->pendientes .'</td>
							<td class="text-right">' . $fs_tabla->en_proceso .'</td>
							<td class="text-right">' . $fs_tabla->atendidos .'</td>
							<td class="text-right">' . ($fs_tabla->pendientes + $fs_tabla->en_proceso + $fs_tabla->atendidos) .'</td>';
						break;
						default:
							$table.= '<td class="text-right">' . $fs_tabla->registrados . '</td>';
					}
						
					$table.= '</tr>';					
				}
				
				$table.= '<tr>';
					$table.= '<td><b>Total</b></td>';
					switch($graph->grafico){
						case 'incidente_x_tipo':							
							$t_pendientes = array_sum(array_column($fs_tablas,'pendientes'));
							$t_en_proceso = array_sum(array_column($fs_tablas,'en_proceso'));
							$t_atendidas  = array_sum(array_column($fs_tablas,'atendidos'));
							
							$table.= '<td class="text-right">' . $t_pendientes .'</td>
							<td class="text-right">' . $t_en_proceso .'</td>
							<td class="text-right">' . $t_atendidas .'</td>
							<td class="text-right">' . ($t_pendientes + $t_en_proceso + $t_atendidas) .'</td>';
						break;
						default:
							$t_incidentes = array_sum(array_column($fs_tablas,'registrados'));
							
							$table.= '<td class="text-right">' . $t_incidentes .'</td>';
						break;
					}					
				$table.= '<tr>';
				
			$table.= '</tbody></table>';
		}
		
		$p = '
			<h2 class="text-center">Gráficos estadísticos</h2>
			<p>
				La información representada en los siguientes gráficos corresponde al período ' . $params->txtFecRegistro . '.
			</p>
		';
		$html.= chart_bar($graph, $fs_graficos) . $table;
	}
	
	return '<body>' . $p . $html . '</body>';
}