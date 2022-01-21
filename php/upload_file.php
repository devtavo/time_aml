<?php
$dt	     = date("d-m-Y");
$path_dt = "../tmp/" . $dt;

if (!file_exists($path_dt)) {
	mkdir($path_dt, 0777, true);
}

if(count($_FILES) > 0){
	$arr = array();
	$file_name = "";
	
	foreach($_FILES as $file) {
		$file_name = uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
		
		if ($file['error'] == 0) {			
			move_uploaded_file($file['tmp_name'], $path_dt . '/' . $file_name);

			array_push($arr, array('path' => $dt . '/' . $file_name, 'name' => $file['name']));
		}		
	}
	
	echo json_encode($arr);
}