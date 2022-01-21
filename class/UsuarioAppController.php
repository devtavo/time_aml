<?php
class UsuarioAppController
{
	
	function __construct()
	{
		
	}
 
	function index($params){
		$pg    = new PgSql();
		$where = [];
			
		if(isset($params->txtUsuarioId) && strlen($params->txtUsuarioId) > 0){
			array_push($where, "persona_id = " . $params->txtUsuarioId);
		}
		
		return $pg->getRows("select persona_id, 
		tipo_persona_id,
		apellido_paterno, 
		apellido_materno, 
		nombres, 
		nombres_apellidos_completos, 
		nro_doc_identidad, 
		telefono_movil, 
		correo_electronico, 
		estado, 
		to_char(fecha_registro,'dd/mm/yyyy HH24:MI:SS') as fecha_registro,
		to_char(fecha_actualizacion,'dd/mm/yyyy HH24:MI:SS') as fecha_actualizacion
		 from sae.ssc_persona
		where estado = 'A' and tipo_persona_id ='2' and " . (count($where) > 0 ? join(" and ", $where) : '1 = 1')  . "
		order by nombres_apellidos_completos");
	}
	
	function findById($params){
		$pg = new PgSql();
		return $pg->getRow("select persona_id, 
		tipo_persona_id,
		apellido_paterno, 
		apellido_materno, 
		nombres, 
		nombres_apellidos_completos, 
		tipo_doc_id,
		nro_doc_identidad, 
		telefono_movil, 
		correo_electronico, 
		estado, 
		to_char(fecha_registro,'dd/mm/yyyy HH24:MI:SS') as fecha_registro,
		to_char(fecha_actualizacion,'dd/mm/yyyy HH24:MI:SS') as fecha_actualizacion
		 from sae.ssc_persona
		where persona_id = " . $params->persona_id . "
		order by
		 2");
	}
	
	function create($params){
		$pg = new PgSql();
		return $pg->getRow("insert into sae.ssc_persona(tipo_doc_id, nro_doc_identidad, apellido_paterno, apellido_materno, nombres,nombres_apellidos_completos, telefono_movil, contrasena, tipo_persona_id) values (" . (int) $params->ddlTipoDoc . ", '" . $params->txtNroDoc . "', '" . $params->txtApePat . "', '" . $params->txtApeMat . "', '" . $params->txtNombres . "', '".$params->txtNombres." ".$params->txtApePat." ".$params->txtApeMat."','" . $params->txtUsuario . "', '" . md5($params->txtClave) . "', '" . $params->ddlTipoUsuario . "') RETURNING persona_id");
	}
	
	function update($params){
		$pg = new PgSql();
		return $pg->getRow("update 
		 sae.ssc_persona
		set
		 " . (strlen($params->txtClave) > 0 ? "contrasena = '" . md5($params->txtClave) . "'," : "") . "
		 tipo_doc_id       = " . (int) $params->ddlTipoDoc . ",
		 nro_doc_identidad = '" . $params->txtNroDoc . "',
		 apellido_paterno  = '" . $params->txtApePat . "',
         apellido_materno  = '" . $params->txtApeMat . "',
		 nombres  = '" . $params->txtNombres . "',
		 tipo_persona_id		   = '" .(int) $params->ddlTipoUsuario . "'		 
		where
		 persona_id = " . $params->txtUsuarioId);
	}
	
	function delete($params){
		$pg = new PgSql();
		return $pg->getRow("update sae.ssc_usuario set estado = 'X' where usuario_id = " . $params->usuario_id);
	}
	
	function login($user, $pass){
		$pg = new PgSql();
		return $pg->getRows("select * from sae.ssc_usuario where usuario = '" . $user . "' and clave = '" . md5($pass) . "' and estado = 'A'");
	}
	
	function ultimoAcceso($user_id){
		$pg = new PgSql();
		return $pg->getRow("update sae.ssc_usuario set ultimo_acceso = now() where usuario_id = " . $user_id);
	}
}