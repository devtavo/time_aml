<?php
class EnviosController
{
	
	function __construct()
	{
		
	}
 
	function index($params){
		$pg    = new MySql();			
		return $pg->getRows("select * from envios");
	}
	
	function findById($params){
		$pg = new MySql();
		return $pg->getRow("select * from envios
		where
		id_envios = " . $params->id_envios . "
		order by
		 1");
	}
	
	function create($params){
		$pg = new MySql();
		// var_dump($params);
	   return $pg->getRow("insert into envios(nombres,dni,telefono,direccion,correo,distrito,provincia,departamento,referencia,dequien,estado,pagorealizado,fechapago,montopagado,observaciones,nrotrack,fechaenvio) 
	   values('".$params->nombrer."',
	   			'".$params->rucr."',
				 '".$params->telefonor."',
				 '".$params->domicilior."',
				 '".$params->correo."',
				 '".$params->distritor."',
				 '".$params->provinciar."',
				 '".$params->departamentor."',
				 '".$params->referenciar."',
				 '".$params->dequien."',
				 '0',
				 '".$params->pagorealizado."',
				 '".$params->fechapago."',
				 '".$params->montopagado."',
				 '".$params->observaciones."',
				 '".$params->numerotrack."',
				 now()) ");

	}
	
	function update($params){
		$pg = new MySql();
		// return "update envios set estado='".$params->estado."' where id_envios='".$params->id_envios."' ";

		$pg->getRow("update envios set estado=$params->estado, nrotrack=$params->numerotrack where id_envios=$params->id_envios; ");
		return "0";
	}
	
	function delete($params){
		$pg = new MySql();
		return $pg->getRow("update sae.ssc_usuario set estado = 'X' where usuario_id = " . $params->usuario_id);
	}
	
	function login($user, $pass){
		$pg = new MySql();
		
		//echo "select * from usuario where usuario = '" . $user . "' and clave = '" . md5($pass) . "' and estado = 'A'";
		echo md5($pass);
		return $pg->getRows("select * from gasto.usuario where usuario = '" . $user . "' and clave = '" . md5($pass) . "' and estado = 'A'");

	}
	
	function ultimoAcceso($user_id){
		$pg = new MySql();
		return $pg->getRow("update usuario set ultimo_acceso = now() where usuario_id = " . $user_id);
	}
}