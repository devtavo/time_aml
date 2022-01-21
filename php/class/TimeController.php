<?php
class TimeController
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
		return $pg->getRows("SELECT * FROM testing.persona where nombres_completos like '%".$params->nombre."%' and estado!='X' ");
	}

	function findByIdPersona($params){
		$pg = new MySql();
		return $pg->getRows("SELECT * from testing.persona p inner join testing.timeline t on p.idpersona=t.id_persona where p.idpersona=$params->idpersona");
	}

	function findByIdTime($params){
		$pg = new MySql();
		return $pg->getRows("SELECT * FROM testing.persona where idpersona=$params->idpersona ");
	}

	function findByIdDip($params){
		$pg = new MySql();
		return $pg->getRows("SELECT * FROM idrapex1_certificado.cert_disponible where estado!='X' and nombre_cert like '%".$params->nombre."%' ");
	}
	function UpdatePersona($params){
		error_reporting(0);

		$pg = new MySql();
		return $pg->getRows("update testing.persona set nombres_completos='".$params->nombres_completos."', nro_doc_identidad='".$params->nro_doc_identidad."', correo='".$params->correo."' ,celular='".$params->celular."' where idpersona='$params->idpersona' ");
	}
	function DeletePersona($params){
		error_reporting(0);

		$pg = new MySql();
		return $pg->getRows(" update testing.persona set estado='X' where idpersona='$params->idpersona'");
	}
	function CreatePersona($params){
		error_reporting(0);

		$pg = new MySql();
		$x=$pg->getRow("select max(idpersona)+1 id_registro from testing.persona");
		return $pg->getRows("insert into testing.persona(idpersona,nombres_completos,nro_doc_identidad,correo,celular,estado,fecha_registro) values(".(int) $x->id_registro.",'".$params->nombres_completos."','".$params->nro_doc_identidad."','".$params->correo."','".$params->celular."','A',now()) ");
	}
	function findByIdi($params){ 
		$pg = new MySql();
		return $pg->getRows("SELECT * FROM idrapex1_certificado.cert_disponible where estado!='X' ;");
	}
	function lst_usuario($params){ 
		$pg = new MySql();
		return $pg->getRows("SELECT * FROM testing.persona where estado!='X' ");
	}
	function lst_alumnos($params){ 
		$pg = new MySql();
		return $pg->getRows("SELECT * FROM idrapex1_certificado.usuario;");
	}
	function lst_certi($params){ 
		$pg = new MySql();
		return $pg->getRows("SELECT * FROM idrapex1_certificado.reg_usu_cert;");
	}

	function creaCerti($params){
		
		error_reporting(0);
		$pg = new MySql();
        $x=$pg->getRow("select max(idreg_usu_cert)+1 id_registro from idrapex1_certificado.reg_usu_cert;");
		$pg->getRow("insert into reg_usu_cert(idreg_usu_cert,id_usuario,id_cert,fecha_emite,cod_verifica) values(".(int) $x->id_registro.",".(int) $params->nombre.",".(int) $params->diplomado.",'".$params->fechae."','".$params->cod_registro."');");
		// return 	$x->id_registro;
		// return json_encode($params);
		return 	$x->id_registro;

	}


    function create($params)
    {	error_reporting(0);
        $pg = new MySql();
        $x=$pg->getRow("select max(idusuario)+1 id_usuario from idrapex1_certificado.usuario");
		$pg->getRow("insert into idrapex1_certificado.usuario (idusuario,nombre, apellidos, nombres_completos, dni, correo, tipo, estado, fecha_registro, pass) VALUES (".(int) $x->id_usuario.", '".$params->nombre."',  '".$params->apellidos."', '".$params->nombres_completos."', '".$params->dni."', '".$params->correo."', '1', 'A','asdsa','1245' );");
		return 	$x->id_usuario;
	}
    function creaRegistroCert($params)
    {
			// error_reporting(0);
        $pg = new MySql();
        $x=$pg->getRow("select max(idreg_usu_cert)+1 id_registro from idrapex1_certificado.reg_usu_cert;");
		$pg->getRow("insert into reg_usu_cert(idreg_usu_cert,id_usuario,id_cert,fecha_emite,cod_verifica) values(".(int) $x->id_registro.",".(int) $params->cod_nombre.",".(int) $params->cod_diplomado.",'".$params->fecha_emision."','".$params->cod_certificado."');");
		// return 	$x->id_registro;
		// return json_encode($params);
		return 	$x->id_registro;

	}
	function getssdiplomados($params){
		$pg= new MySql();
		return $pg->getRows("SELECT * FROM idrapex1_certificado.cert_disponible WHERE $params->nombre!='0' ");
	    
		// return $pg->getRows("select * from idrapex1_certificado.usuario");

		// return "select idcert_disponible id, nombre_cert nombre, horas_academicas horas,fecha_inicio fechai, fecha_fin fechaf from idrapex1_certificado.cert_disponible";
    
	}

	function get_codigo($params){
		$pg= new MySql();
		return $pg->getRows("
		select momen cod_nuevo,ultimo from (select idcert_disponible id,concat(momenclatura,mes,ano)momen from idrapex1_certificado.cert_disponible where idcert_disponible='".$params->id."') a 
		inner join 
		(select id_cert id,count(*)+1 ultimo from idrapex1_certificado.reg_usu_cert where id_cert='".$params->id."') b on a.id=b.id

		");

	}
	function get_codigo_nom($params){
		$pg=new MySql();

		return $pg->getRow("select idcert_disponible id,concat(momenclatura,mes,ano)momen, count(*) cantidad from idrapex1_certificado.cert_disponible where idcert_disponible='".$params->id."'  ");
		// return $pg->getRows("select idcert_disponible id, nombre_cert nombre, horas_academicas horas,fecha_inicio fechai, fecha_fin fechaf from idrapex1_certificado.cert_disponible");
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