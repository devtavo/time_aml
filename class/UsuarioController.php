<?php
class UsuarioController
{
	
	function __construct()
	{
		
	}
 
	function index($params){
		$pg    = new MySql();
		$where = [];
			
		if(isset($params->txtUsuarioId) && strlen($params->txtUsuarioId) > 0){
			array_push($where, "usuario_id = " . $params->txtUsuarioId);
		}
		
		return $pg->getRows("select
         usuario_id,
		 tipo_doc_id,
		 nro_doc_identidad,		 
		 apellido_paterno,
		 apellido_materno,
		 nombres,
		 usuario,
		 to_char(fecha_registro, 'dd/mm/yyyy HH24:MI:SS') as fecha_registro,
		 to_char(ultimo_acceso, 'dd/mm/yyyy HH24:MI:SS') as ultimo_acceso		
		from sae.ssc_usuario
		where estado = 'A' and " . (count($where) > 0 ? join(" and ", $where) : '1 = 1')  . "
		order by
		 usuario");
	}
	
	function findById($params){
		$pg = new MySql();
		return $pg->getRow("select
         usuario_id,
		 tipo_doc_id,
		 nro_doc_identidad,		 
		 apellido_paterno,
		 apellido_materno,
		 nombres,
		 usuario,
		 permisos,
		 es_admin,		 
		 to_char(fecha_registro::date, 'dd/mm/yyyy hh24:mm') as fecha_registro,
		 to_char(ultimo_acceso::date, 'dd/mm/yyyy hh24:mm') as ultimo_acceso
		from sae.ssc_usuario
		where
		 usuario_id = " . $params->usuario_id . "
		order by
		 2");
	}
	
	function create($params){
		$pg = new MySql();
		return $pg->getRow("insert into sae.ssc_usuario(tipo_doc_id, nro_doc_identidad, apellido_paterno, apellido_materno, nombres, usuario, clave, permisos, es_admin) values (" . (int) $params->ddlTipoDoc . ", '" . $params->txtNroDoc . "', '" . $params->txtApePat . "', '" . $params->txtApeMat . "', '" . $params->txtNombres . "', '" . $params->txtUsuario . "', '" . md5($params->txtClave) . "', '" . json_encode($params->ddlPermisos) . "', '" . $params->ddlTipoUsuario . "') RETURNING usuario_id");
	}
	
	function update($params){
		$pg = new MySql();
		return $pg->getRow("UPDATE 
		 sae.ssc_usuario
		SET
		 " . (strlen($params->txtClave) > 0 ? "clave = '" . md5($params->txtClave) . "'," : "") . "
		 tipo_doc_id       = " . (int) $params->ddlTipoDoc . ",
		 nro_doc_identidad = '" . $params->txtNroDoc . "',
		 apellido_paterno  = '" . $params->txtApePat . "',
         apellido_materno  = '" . $params->txtApeMat . "',
		 nombres           = '" . $params->txtNombres . "',
		 permisos          = '" . json_encode($params->ddlPermisos) . "',
		 es_admin		   = '" . $params->ddlTipoUsuario . "'		 
		where
		 usuario_id = " . $params->txtUsuarioId);
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