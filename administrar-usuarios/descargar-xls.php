<?php

ini_set("memory_limit","500M");

$relative = '..';
require '../includes/common.php';

header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Usuarios monique.xls"');
header('Cache-Control: max-age=0');

$userStats = loadUser();
if ($userStats['user']->administrador == 0 ) {

	echo "Acceso restringido!";
	exit;

}

include_once '../includes/phpexcel/PHPExcel.php';

$todosLosUsuarios = obtenerUsuarios(isset($_GET['id']) ? $_GET['id'] : null);
// echo '<pre>';
// print_r($todosLosUsuarios);
// echo '</pre>';

$xls = new PHPExcel();

$xls->getProperties()
->setCreator("Monique.com.uy")
->setLastModifiedBy("Monique.com.uy")
->setTitle("Usuarios registrados")
->setSubject("Usuarios registrados")
->setDescription("Lista de usuarios registrados en monique.com.uy");

$xls->setActiveSheetIndex(0);

$xls->getActiveSheet()->setCellValue('A1', 'ID');
$xls->getActiveSheet()->setCellValue('B1', 'Nombre');
$xls->getActiveSheet()->setCellValue('C1', 'RUT');
$xls->getActiveSheet()->setCellValue('D1', 'E-Mail');
$xls->getActiveSheet()->setCellValue('E1', 'Dirección');
$xls->getActiveSheet()->setCellValue('F1', 'Teléfonos');
$xls->getActiveSheet()->setCellValue('G1', 'Localidad');
$xls->getActiveSheet()->setCellValue('H1', 'Total Compras');

$usrIndx = 2;
foreach ($todosLosUsuarios as $usuario) {


	if(fmod($usrIndx, 5010) == 0) {
		sleep(1);
		set_time_limit(60);
		break;
	}

	$xls->getActiveSheet()->setCellValue('A'.$usrIndx, $usuario->id);
	$xls->getActiveSheet()->setCellValue('B'.$usrIndx, $usuario->nombre .' '. $usuario->apellido);
	$xls->getActiveSheet()->setCellValue('C'.$usrIndx, $usuario->rut);
	$xls->getActiveSheet()->setCellValue('D'.$usrIndx, $usuario->email);
	$xls->getActiveSheet()->setCellValue('E'.$usrIndx, $usuario->direccion);
	$xls->getActiveSheet()->setCellValue('F'.$usrIndx, $usuario->telefono .'/'. $usuario->celular);
	$xls->getActiveSheet()->setCellValue('G'.$usrIndx, $usuario->ciudad .', '. $usuario->departamento);
	$xls->getActiveSheet()->setCellValue('H'.$usrIndx, $usuario->total_pedidos != "NULL" ? $usuario->total_pedidos : 0);

	$usrIndx++;

}

$xls->getActiveSheet()->setTitle('Usuarios');
$xls->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel2007');
$objWriter->save('php://output');

exit;

?>