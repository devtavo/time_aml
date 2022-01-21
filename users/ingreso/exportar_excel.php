<?php
require '../../php/PhpSpreadsheet-master/vendor/autoload.php';
require '../../php/PgSql.php';
require '../../php/class/IncidenteController.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
ob_clean();

$params = json_decode($_GET['data']);
$params->pagination = false;
$instance = new IncidenteController();
$fs_incidentes = $instance->index($params);

$spreadsheet = new Spreadsheet();
$spreadsheet->getProperties()
->setCreator('MP Cajamarca')
->setLastModifiedBy('MP Cajamarca')
->setTitle('Listado de Incidencias')
->setSubject('Listado de Incidencias')
->setDescription('Listado de Incidencias')
->setKeywords('Listado de Incidencias')
->setCategory('Listado de Incidencias');

$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Incidencias - MP Cajamarca');

$rowCount = 5;

if(count($fs_incidentes) > 0){
	foreach ($fs_incidentes as $fs_incidente){
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $rowCount, $fs_incidente->canal_comunicacion);
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $rowCount, $fs_incidente->incidente_id);
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $rowCount, ucwords(strtolower($fs_incidente->ciudadano)));
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $rowCount, $fs_incidente->telefono);
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $rowCount, $fs_incidente->incidencia_descripcion);
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $rowCount, $fs_incidente->clasificacion_inc);
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $rowCount, $fs_incidente->tipo_inc);
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $rowCount, $fs_incidente->subtipo_inc);
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $rowCount, $fs_incidente->latitud);
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $rowCount, $fs_incidente->longitud);
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('K' . $rowCount, $fs_incidente->sector_subsector);
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('L' . $rowCount, "-");
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('M' . $rowCount, $fs_incidente->fecha_registro);
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('N' . $rowCount, $fs_incidente->estado == 'P' ? 'Pendiente' : 'Cerrado');
		$rowCount++;
	}
}
//telefono
//incidencia_direccion
$cell_title =[
	'font' =>['bold' => true],
	'alignment' =>['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
	'borders'=>['bottom' =>['style'=> \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM]]
];

$cell_st =[
	'font' =>['bold' => true],
	'alignment' =>['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
	'borders'=>['bottom' =>['style'=> \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM]]
];

$spreadsheet->getActiveSheet()->getStyle('B1:B2')->applyFromArray($cell_title);
$spreadsheet->getActiveSheet()->getStyle('A4:N4')->applyFromArray($cell_st);
$spreadsheet->getActiveSheet()->mergeCells("C1:E1");

foreach (range('A','N') as $col) {
	$spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);  
}

$sheet
->setCellValue('A4', 'Canal de comunicación')
->setCellValue('B4', 'Nro. de caso')
->setCellValue('C4', 'Denunciante')
->setCellValue('D4', 'Teléfono')
->setCellValue('E4', 'Descripción de incidencia')
->setCellValue('F4', 'Clasificación')
->setCellValue('G4', 'Tipo')
->setCellValue('H4', 'Subtipo')
->setCellValue('I4', 'Latitud')
->setCellValue('J4', 'Longitud')
->setCellValue('K4', 'Sector')
->setCellValue('L4', 'Dirección')
->setCellValue('M4', 'Fecha de registro')
->setCellValue('N4', 'Estado')
->setCellValue('B1', 'Reporte:')
->setCellValue('B2', 'Desde-hasta:')
->setCellValue('C1', 'Listado de Incidencias reportadasde la MP Cajamarca')
->setCellValue('C2', $params->txtFecRegistro);

$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
$drawing->setName('Paid');
$drawing->setDescription('Paid');
$drawing->setPath('../../assets/app/img/logo_small.png'); // put your path and image here
$drawing->setCoordinates('A1');
$drawing->setOffsetX(10);
$drawing->setOffsetY(5);
$drawing->getShadow()->setVisible(true);
$drawing->setWorksheet($spreadsheet->getActiveSheet());


// OUTPUT
$writer = new Xlsx($spreadsheet);

// OR FORCE DOWNLOAD
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Incidencias_MP_Cajamarca.xlsx"');
header('Cache-Control: max-age=0');
header('Expires: Fri, 11 Nov 2011 11:11:11 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: cache, must-revalidate');
header('Pragma: public');
$writer->save('php://output');