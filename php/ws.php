<?php
	if (session_status() == PHP_SESSION_NONE) {		
		session_start();
	}
	
	//oAuth();
    require 'MySql.php';
	
	//require 'PgSql.php';

	require 'class/IncidenteController.php';
	require 'class/DashboardController.php';
	require 'class/UsuarioController.php';
	require 'class/EnviosController.php';
	require 'class/TimeController.php';

	if(count($_POST) > 0 && isset($_POST)){

		$params = (object)$_POST;
	
		if(isset($params->method)){
			$response = callFunction($params);
			echo json_encode($response);
		}
	}elseif (count($_GET) > 0 && isset($_GET)) {
		$params = (object)$_GET;
		if(isset($params->method)){
			$response = callFunction($params);
			echo json_encode($response);
		}
	}
	
	function callFunction($params){

		$class    = $params->class;
		$method   = $params->method;
		$instance = new $class();		
		return $instance->$method($params);
	}
	
	function createFolder(){
		$dt	     = date("d-m-Y");
		$path_dt = "../docs/" . $dt;

		if (!file_exists($path_dt)) {
			mkdir($path_dt, 0777, true);
		}
	}
	
	function getMonthName($month){
		$months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
		return $months[(int) $month - 1];
	}

	function oAuth(){		
		if(!isset($_SESSION['user_id'])){
			header('Location: ../../users/login/index.php?s');
		}
	}
	
	function getColor($quantil) {		
		switch($quantil){
			case 5:
				return '#FF0000';
			break;
			case 4:
				return '#FFA500';
			break;
			case 3:
				return '#FFFF00';
			break;
			case 2:
				return '#93C572';
			break;
			case 1:
				return '#008F39';
			break;
			default:
				return 'transparent';
		}
	}
	
	function getColorInv($quantil) {		
		switch($quantil){
			case 1:
				return '#FF0000';
			break;
			case 2:
				return '#FFA500';
			break;
			case 3:
				return '#FFFF00';
			break;
			case 4:
				return '#93C572';
			break;
			case 5:
				return '#008F39';
			break;
			default:
				return 'transparent';
		}
	}
?>