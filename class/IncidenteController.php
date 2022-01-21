<?php
class IncidenteController
{
	private $limit = 20;

	function __construct()
	{
	}
	function index($params)
	{
		$sql = new MySql();

		return $sql->getRows("select * from usuario where dni=" . $params->txtNroDocIde);
	}
	function index2($params)
	{
		$pg        = new PgSql();
		$where     = [];
		$txtPagina = isset($params->txtPagina) ? (int) $params->txtPagina : 1;
		$offset    = (($txtPagina == 0 ? 1 : $txtPagina) - 1) * $this->limit;

		if (isset($params->ddlOrigen) && count($params->ddlOrigen) > 0) {
			array_push($where, "canal_comunicacion_id in(" . join(",", $params->ddlOrigen) . ")");
		}

		if (isset($params->txtNroCaso) && strlen($params->txtNroCaso) > 0) {
			array_push($where, "incidente_id = " . $params->txtNroCaso);
		}

		if (isset($params->txtNroDocIde) && strlen($params->txtNroDocIde) > 0) {
			array_push($where, "nro_doc_identidad = '" . $params->txtNroDocIde . "'");
		}

		if (isset($params->txtInformante) && strlen($params->txtInformante) > 0) {
			array_push($where, "COALESCE(COALESCE(ps.nombres_apellidos_completos,INITCAP(ps.nombres || ' ' || ps.apellido_paterno || ' ' || ps.apellido_materno)), inc.nro_telefono) like '%" . $params->txtInformante . "%'");
		}

		if (isset($params->ddlClasificacion) && count($params->ddlClasificacion) > 0) {
			array_push($where, "clasificacion_incidente_id in(" . join(",", $params->ddlClasificacion) . ")");
		}

		if (isset($params->txtDia) && isset($params->txtDia) > 0) {
			array_push($where, "extract(isodow from inc.fecha_registro) in (" . join(",", $params->txtDia) . ")");
		}

		if (isset($params->txtHora) && isset($params->txtHora) > 0) {
			array_push($where, "extract(hour from inc.fecha_registro) in (" . join(",", $params->txtHora) . ")");
		}

		if (isset($params->txtSector) && isset($params->txtSector) > 0) {
			array_push($where, "inc.sector_id in (" . join(",", $params->txtSector) . ")");
		}

		if (isset($params->txtFecRegistro) && strlen($params->txtFecRegistro) > 0) {
			$txtFecRegistro = explode(" ", $params->txtFecRegistro);
			if (count($txtFecRegistro) == 3) {
				array_push($where, "inc.fecha_registro::date between to_date('" . $txtFecRegistro[0] . "', 'dd-mm-yyyy') and to_date('" . $txtFecRegistro[2] . "', 'dd-mm-yyyy')");
			}
		}

		if (isset($params->ddlEstado) && count($params->ddlEstado) > 0) {
			$tmp = array();

			foreach ($params->ddlEstado as &$estado) {
				array_push($tmp, "'" . $estado . "'");
			}

			if (count($tmp)) {
				array_push($where, "estado_atencion in(" . join(",", $tmp) . ")");
			}
		}

		if (isset($params->ddlAnioMes) && count($params->ddlAnioMes) > 0) {
			array_push($where, "to_char(inc.fecha_registro, 'yyyymm')::integer in(" . join(",", $params->ddlAnioMes) . ")");
		}

		if (isset($params->ddlSector) && count($params->ddlSector) > 0) {
			array_push($where, "sector_id in(" . join(",", $params->ddlSector) . ")");
		}

		if (isset($params->geoJson)) {
			$data = $pg->getRow("SELECT
             row_to_json(fc) as vo_ch_coordinates
            FROM (
             SELECT
              'FeatureCollection' As type,
              array_to_json(array_agg(f)) As features
             FROM (
              SELECT
               'Feature' As type,
               ST_AsGeoJSON(ST_MakePoint(inc.longitud, inc.latitud))::json As geometry,
               row_to_json((SELECT l FROM (
			    SELECT 
				 incidente_id, 
				 estado_atencion,
				 case
				  when clasificacion_incidente_id = 8 then 'circle'
				  when clasificacion_incidente_id = 7 then 'square'
				  when clasificacion_incidente_id = 5 then 'triangle-up'
				  when clasificacion_incidente_id = 9 then 'triangle-down'
				  when clasificacion_incidente_id = 6 then 'diamond'
				 end as shape,
				 case
				  when estado_atencion = 'P' then '#FF0000'
				  when estado_atencion = 'T' then '#FFFF00'
				  when estado_atencion = 'C' then '#008F39'
				 end as color
			   ) As l)) As properties
              FROM sae.ssc_incidente As inc
			  left join sae.ssc_persona ps on ps.persona_id = inc.persona_id
			  where incidente_padre_id = 0 and " . (count($where) > 0 ? join(" and ", $where) : '1 = 1')  . "
			  order by inc.incidente_id desc
			  " . (isset($params->offset) ? "" : "offset " . $offset . " limit " . $this->limit . "") . "
             ) As f 
            )  As fc");

			return $data->vo_ch_coordinates;
		} elseif (isset($params->esri)) {
			$data = $pg->getRow("select
			   string_agg(
                'lat:' || latitud || ';lng:' || longitud || ';icon:' || icon || color, ',') as vo_ch_coordinates
			 from(
			  select	 
			   round(latitud,4) as latitud,
			   round(longitud,4) as longitud,
			   case
			    when estado_atencion = 'P' then 'red'
			    when estado_atencion = 'T' then 'yellow'
			    when estado_atencion = 'C' then 'green'
			   end as color,
			   case
			    when ntile(2) over (order by count(*) desc) = 2 then 'dot-large-'
				else 'dot-small-'
			   end as icon
              from sae.ssc_incidente As inc
              left join sae.ssc_persona ps on ps.persona_id = inc.persona_id
              where 
               incidente_padre_id = 0 and
			   " . (count($where) > 0 ? join(" and ", $where) : '1 = 1')  . "
			  group by
			   round(latitud,4),
			   round(longitud,4),
			   estado_atencion
			 ) x");

			/*$data = $pg->getRow("select
 string_agg('lat:' || latitud || ';lng:' || longitud || ';icon:dot-large-blue', ',') as vo_ch_coordinates 
from(
 select round(min(latitud),5) as latitud, round(min(longitud),6) as longitud from sae.ssc_incidente where estado_atencion = 'P' union all
 select round(max(latitud),6) as latitud, round(max(longitud),6) as longitud from sae.ssc_incidente where estado_atencion = 'P'
) x");*/
			return $data->vo_ch_coordinates;
		} else {
			return $pg->getRows("select 
			 inc.incidente_id,
			 inc.clasificacion_incidente_id as clasificacion_inc_id,
			 cla.valor as clasificacion_inc,
			 inc.tipo_incidente_id,
			 tip.valor as tipo_inc,
			 inc.subtipo_incidente_id,
			 sub.valor as subtipo_inc,
			 to_char(inc.fecha_registro, 'dd/mm/yyyy hh:mm') as fecha_registro,
			 COALESCE(COALESCE(ps.nombres_apellidos_completos,INITCAP(ps.nombres || ' ' || ps.apellido_paterno || ' ' || ps.apellido_materno)), inc.nro_telefono) as ciudadano,
			 inc.canal_comunicacion_id,
			 case inc.canal_comunicacion_id
			  when 1 then 'Llamadas Telefónicas'
			  when 2 then 'Aplicativo Móvil'
			  when 3 then 'Página Web'
              when 4 then 'Correo Electrónico'
			 end as canal_comunicacion,
			 inc.incidencia_descripcion,
			 inc.latitud,
			 inc.longitud,
			 nro_telefono as telefono,
			 inc.incidencia_direccion,
			 sector_id as sector_subsector,
			 inc.estado_atencion as estado,
			 audio,
			 video,
			 llamada
			from sae.ssc_incidente inc
			left join sae.ssc_persona ps on ps.persona_id = inc.persona_id
			left join sae.ssc_multitabla cla on cla.tabla = 'ssc_clasificacion_inc' and cla.multitabla_id = inc.clasificacion_incidente_id
			left join sae.ssc_multitabla tip on tip.tabla = 'ssc_tipo_inc' and tip.multitabla_id 	 = inc.tipo_incidente_id
			left join sae.ssc_multitabla sub on sub.tabla = 'ssc_subtipo_inc' and sub.multitabla_id  = inc.subtipo_incidente_id
			where incidente_padre_id = 0 and " . (count($where) > 0 ? join(" and ", $where) : '1 = 1')  . "
			order by inc.incidente_id desc
			" . (isset($params->pagination) && !$params->pagination ? "" : "offset " . $offset . " limit " . $this->limit));
		}
	}

	function countBySql($params)
	{
		$pg    = new PgSql();
		$where = [];

		if (isset($params->ddlOrigen) && count($params->ddlOrigen) > 0) {
			array_push($where, "canal_comunicacion_id in(" . join(",", $params->ddlOrigen) . ")");
		}

		if (isset($params->txtNroCaso) && strlen($params->txtNroCaso) > 0) {
			array_push($where, "incidente_id = " . $params->txtNroCaso);
		}

		if (isset($params->txtNroDocIde) && strlen($params->txtNroDocIde) > 0) {
			array_push($where, "nro_doc_identidad = '" . $params->txtNroDocIde . "'");
		}

		if (isset($params->txtInformante) && strlen($params->txtInformante) > 0) {
			array_push($where, "COALESCE(COALESCE(ps.nombres_apellidos_completos,INITCAP(ps.nombres || ' ' || ps.apellido_paterno || ' ' || ps.apellido_materno)), inc.nro_telefono) like '%" . $params->txtInformante . "%'");
		}

		if (isset($params->ddlClasificacion) && count($params->ddlClasificacion) > 0) {
			array_push($where, "clasificacion_incidente_id in(" . join(",", $params->ddlClasificacion) . ")");
		}

		if (isset($params->txtDia) && isset($params->txtDia) > 0) {
			array_push($where, "extract(isodow from inc.fecha_registro) in (" . join(",", $params->txtDia) . ")");
		}

		if (isset($params->txtHora) && isset($params->txtHora) > 0) {
			array_push($where, "extract(hour from inc.fecha_registro) in (" . join(",", $params->txtHora) . ")");
		}

		if (isset($params->txtSector) && isset($params->txtSector) > 0) {
			array_push($where, "inc.sector_id in (" . join(",", $params->txtSector) . ")");
		}

		if (isset($params->txtFecRegistro) && strlen($params->txtFecRegistro) > 0) {
			$txtFecRegistro = explode(" ", $params->txtFecRegistro);
			if (count($txtFecRegistro) == 3) {
				array_push($where, "inc.fecha_registro::date between to_date('" . $txtFecRegistro[0] . "', 'dd-mm-yyyy') and to_date('" . $txtFecRegistro[2] . "', 'dd-mm-yyyy')");
			}
		}

		if (isset($params->ddlEstado) && count($params->ddlEstado) > 0) {
			$tmp = array();

			foreach ($params->ddlEstado as &$estado) {
				array_push($tmp, "'" . $estado . "'");
			}

			if (count($tmp)) {
				array_push($where, "estado_atencion in(" . join(",", $tmp) . ")");
			}
		}

		if (isset($params->ddlAnioMes) && count($params->ddlAnioMes) > 0) {
			array_push($where, "to_char(inc.fecha_registro, 'yyyymm')::integer in(" . join(",", $params->ddlAnioMes) . ")");
		}

		return $pg->getRow("select         
		 count(*) as cantidad,
		 CEIL(count(*)::decimal / " . $this->limit . ") as paginas
		from sae.ssc_incidente inc
		left join sae.ssc_persona ps on ps.persona_id = inc.persona_id
		left join sae.ssc_multitabla cla on cla.tabla = 'ssc_clasificacion_inc' and cla.multitabla_id = inc.clasificacion_incidente_id
		left join sae.ssc_multitabla tip on tip.tabla = 'ssc_tipo_inc' and tip.multitabla_id 	 = inc.tipo_incidente_id
		left join sae.ssc_multitabla sub on sub.tabla = 'ssc_subtipo_inc' and sub.multitabla_id  = inc.subtipo_incidente_id
		where " . (count($where) > 0 ? join(" and ", $where) : '1 = 1')  . "");
	}

	function findById($params)
	{
		$pg   = new PgSql();
		return $pg->getRow("select 
         inc.incidente_id,
         inc.clasificacion_incidente_id as clasificacion_inc_id,
         cla.valor as clasificacion_inc,
         inc.tipo_incidente_id,
         tip.valor as tipo_inc,
         inc.subtipo_incidente_id,
         sub.valor as subtipo_inc,
         to_char(inc.fecha_registro, 'dd/mm hh:mm') as fecha_registro,
		 ps.nro_doc_identidad as nro_doc_identidad,
         COALESCE(ps.nombres_apellidos_completos,INITCAP(ps.nombres || ' ' || ps.apellido_paterno || ' ' || ps.apellido_materno)) as ciudadano,
         inc.canal_comunicacion_id,
         case inc.canal_comunicacion_id
          when 1 then 'Llamadas Telefónicas'
          when 2 then 'Aplicativo Móvil'
          when 3 then 'Página Web'
          when 4 then 'Correo Electrónico'
         end as canal_comunicacion,
         inc.incidencia_descripcion,
         inc.latitud,
         inc.longitud,
         nro_telefono as telefono,
         inc.incidencia_direccion,
		 inc.direccion_nro,
		 inc.direccion_interior,
		 inc.direccion_lote,
		 inc.direccion_referencia,
         inc.estado_atencion as estado
        from sae.ssc_incidente inc
        left join sae.ssc_persona ps on ps.persona_id = inc.persona_id
        left join sae.ssc_multitabla cla on cla.tabla = 'ssc_clasificacion_inc' and cla.multitabla_id = inc.clasificacion_incidente_id
        left join sae.ssc_multitabla tip on tip.tabla = 'ssc_tipo_inc' and tip.multitabla_id 	 = inc.tipo_incidente_id
        left join sae.ssc_multitabla sub on sub.tabla = 'ssc_subtipo_inc' and sub.multitabla_id = inc.subtipo_incidente_id
		where
		 inc.incidente_id = " . $params->incidente_id . "
        order by
         inc.incidente_id desc");
	}

	function create($params)
	{
		if (strlen($params->txtAdjTmp) > 0) {
			createFolder();
			foreach (json_decode($params->txtAdjTmp) as $key) {
				$file = "../tmp/" . $key->path;
				if (file_exists($file)) {
					$nombre_fisico = $key->path;
					if (file_exists($file)) {
						$fileMoved = rename($file, "../docs/" . $key->path);
					}
				}
			}	
		}

		$pg  = new MySql();
		return $pg->getRow("insert into gasto(fecha,vendedor,cod_vendedor,nombre,dni,correo,profesion,lugar,celular,banco,voucher,monto,cuanto,curso,archivo,certificado,observaciones) 
		values(
		'" . $params->fecha . "',
		'" . $params->vendedor . "',
		'" . $params->codigo . "',
		'" . $params->nombre . "',
		'" . $params->dni . "',
		'" . $params->correo . "',
		'" . $params->profesion . "',
		'" . $params->lugar . "',
		'" . $params->celular . "',
		'" . $params->banco . "',
		'" . $params->voucher . "',
		'" . $params->monto . "',
		'" . $params->cuantos . "',
		'" . json_encode($params->curso) . "',
		'" . $nombre_fisico . "',
		'" . $params->certificado . "',
		'" . $params->observaciones . "'
			)");
	}

	function update($params)
	{
		$pg  = new PgSql();
		return $pg->getRow("select sae.fu_incidente(
		" . (int)$params->txtIncidenteId . ",
		'" . $params->txtNroTelef . "',
		'" . $params->txtNroDocIde . "',
		'" . $params->txtDenunciante . "',
		'" . $params->txtDescIncidencia . "',
		'" . $params->txtDireccion . "',
		'" . $params->txtDirNro . "',
		'" . $params->txtDirInterior . "',
		'" . $params->txtDirLote . "',
		'" . $params->txtDirReferencia . "',
		'" . $params->txtCoordenadas . "',
		" . (int)$params->ddlClasificInc . ",
		" . (int)$params->ddlTipoInc . ",
		" . (int)$params->ddlSubTipoInc . ") as data");

		/*$pg->getRow("DELETE FROM sae.ssc_incidente_personal where incidente_id = " . (int)$params->incidente_id);
		
		if(isset($params->supervisores)){
			foreach($params->supervisores as $supervisor){
				$pg->getRow("INSERT INTO sae.ssc_incidente_personal(incidente_id, persona_id) VALUES (" . (int)$params->incidente_id . ", " . (int)$supervisor . ")");
			}
		}		
		
		return $pg->getRow("select sae.fu_incidente(
		'" . (int)$params->incidente_id . "',
		'" . (int)$params->clasificacion_inc_id . "',
		'" . (int)$params->tipo_inc_id . "',
		'" . (int)$params->subtipo_inc_id . "') as data");*/
	}

	function heatMap($params)
	{
		$pg    = new PgSql();
		$where = [];

		if (isset($params->ddlClasificacion) && isset($params->ddlClasificacion) > 0) {
			array_push($where, "clasificacion_incidente_id in(" . join(",", $params->ddlClasificacion) . ")");
		}

		if (isset($params->txtFecRegistro) && strlen($params->txtFecRegistro) > 0) {
			$txtFecRegistro = explode(" ", $params->txtFecRegistro);
			if (count($txtFecRegistro) == 3) {
				array_push($where, "fecha_registro::date between to_date('" . $txtFecRegistro[0] . "', 'dd-mm-yyyy') and to_date('" . $txtFecRegistro[2] . "', 'dd-mm-yyyy')");
			}
		}

		if (isset($params->ddlEstado) && count($params->ddlEstado) > 0) {
			$tmp = array();

			foreach ($params->ddlEstado as &$estado) {
				array_push($tmp, "'" . $estado . "'");
			}

			if (count($tmp)) {
				array_push($where, "estado_atencion in(" . join(",", $tmp) . ")");
			}
		}

		if (isset($params->txtDia)) {
			array_push($where, "extract(isodow from fecha_registro) in (" . join(",", $params->txtDia) . ")");
		}

		if (isset($params->txtHora)) {
			array_push($where, "extract(hour from fecha_registro) in (" . join(",", $params->txtHora) . ")");
		}

		if (isset($params->ddlSector) && count($params->ddlSector) > 0) {
			array_push($where, "sector_id in(" . join(",", $params->ddlSector) . ")");
		}

		//$da="select latitud, longitud from sae.ssc_incidente where incidente_padre_id = 0 and " . (count($where) > 0 ? join(" and ", $where) : '1 = 1');
		//var_dump($da);
		return $pg->getRows("select latitud, longitud from sae.ssc_incidente where incidente_padre_id = 0 and " . (count($where) > 0 ? join(" and ", $where) : '1 = 1'));
	}

	function cerrarCaso($params)
	{
		if (strlen($params->adjuntos) > 0) {
			$archivo     = ArchivoController::create($params);
			$inc_archivo = IncArchivoController::create((int)$params->incidente_id, $archivo);
		}

		$pg   = new PgSql();
		return $pg->getRow("select sae.fu_cerrar_incidente(" . (int)$params->incidente_id . ", '" . $params->comentarios . "', '" . $params->palabras_clave . "')");
	}

	function sectorizacion($params)
	{
		$pg    = new PgSql();
		$where = [];
		$where_out = [];

		if (isset($params->ddlClasificacion) && isset($params->ddlClasificacion) > 0) {
			array_push($where, "inc.clasificacion_incidente_id in(" . join(",", $params->ddlClasificacion) . ")");
		}

		if (isset($params->txtFecRegistro) && strlen($params->txtFecRegistro) > 0) {
			$txtFecRegistro = explode(" ", $params->txtFecRegistro);
			if (count($txtFecRegistro) == 3) {
				array_push($where, "fecha_registro::date between to_date('" . $txtFecRegistro[0] . "', 'dd-mm-yyyy') and to_date('" . $txtFecRegistro[2] . "', 'dd-mm-yyyy')");
			}
		}

		if (isset($params->ddlSector) && count($params->ddlSector) > 0) {
			array_push($where_out, "sector_id in(" . join(",", $params->ddlSector) . ")");
		}

		if (isset($params->ddlEstado) && count($params->ddlEstado) > 0) {
			$tmp = array();

			foreach ($params->ddlEstado as &$estado) {
				array_push($tmp, "'" . $estado . "'");
			}

			if (count($tmp)) {
				array_push($where, "estado_atencion in(" . join(",", $tmp) . ")");
			}
		}

		return $pg->getRows("select 
         x.sector_id,
         ntile(5) over (order by (pendientes + en_proceso + atendidas) desc) as quantil
        from(
         select
          st.objectid as sector_id, 
          COUNT(case when inc.sector_id = st.objectid and inc.estado_atencion = 'P' then 1 end) as pendientes, 
          COUNT(case when inc.sector_id = st.objectid and inc.estado_atencion = 'T' then 1 end) as en_proceso, 
          COUNT(case when inc.sector_id = st.objectid and inc.estado_atencion = 'C' then 1 end) as atendidas
         from sae.ssc_sector st 
         inner join sae.ssc_incidente inc on inc.sector_id = st.objectid 
         where " . (count($where) > 0 ? join(" and ", $where) : '1 = 1') . "
         group by 
          st.objectid
         order by
          (COUNT(case when inc.sector_id = st.objectid and inc.estado_atencion = 'P' then 1 end) +
          COUNT(case when inc.sector_id = st.objectid and inc.estado_atencion = 'T' then 1 end) + 
          COUNT(case when inc.sector_id = st.objectid and inc.estado_atencion = 'C' then 1 end)) desc
        ) x
		where " . (count($where_out) > 0 ? join(" and ", $where_out) : '1 = 1'));

		/*return $pg->getRows("select
         y.sector_id as sector_id,
         COALESCE(x.cant,0) as quantil
        from(
         select
          *
         from(
          select
           st.objectid as sector_id,
           ntile(5) over (order by count(*)) as cant
          from sae.ssc_sector st
          inner join sae.ssc_incidente inc on inc.sector_id = st.objectid
		  where " . (count($where) > 0 ? join(" and ", $where) : '1 = 1') . "
          group by
           st.objectid
          order by
           1
         ) x
		where " . (count($where_out) > 0 ? join(" and ", $where_out) : '1 = 1') . "
        ) x
        full outer join(
         select objectid as sector_id from sae.ssc_sector order by 1
        ) y on (x.sector_id = y.sector_id)");*/
	}

	function incidencias_agrupadas($params)
	{
		$pg    = new PgSql();
		$where = [];

		if (isset($params->ddlIncidentes) && count($params->ddlIncidentes) > 0) {
			array_push($where, "inc.incidente_id in(" . join(",", $params->ddlIncidentes) . ")");
		}

		return $pg->getRows("select 
         inc.incidente_id,  
         to_char(inc.fecha_registro, 'dd/mm/yyyy hh:mm') as fecha_registro,
         COALESCE(COALESCE(ps.nombres_apellidos_completos,INITCAP(ps.nombres || ' ' || ps.apellido_paterno || ' ' || ps.apellido_materno)), inc.nro_telefono) as ciudadano,
         estado_atencion
        from sae.ssc_incidente inc
        left join sae.ssc_persona ps on ps.persona_id = inc.persona_id
        where " . (count($where) > 0 ? join(" and ", $where) : '1 = 1')  . "
		order by
		 inc.fecha_registro");
	}

	function agrupar($params)
	{
		$rbtInc = 0;
		$pg    = new PgSql();
		$where = [];

		if (isset($_SESSION['chkSel']) && count($_SESSION['chkSel']) > 1) {
			$chkSel = $_SESSION['chkSel'];
			$rbtInc = $chkSel{
				0};

			if (($key = array_search($rbtInc, $chkSel)) !== false) {
				unset($chkSel[$key]);
			}

			$pg->getRows("update sae.ssc_incidente set incidente_padre_id = " . $rbtInc . " where incidente_id in(" . join(",", $chkSel) . ")");

			$_SESSION['chkSel'] = array();

			return $chkSel;
		}
	}

	function chkSel($params)
	{
		if (isset($_SESSION['chkSel']) == false) {
			$_SESSION['chkSel'] = array();
		}

		if (count($params->rbtIncidente) > 0) {
			foreach ($params->rbtIncidente as $rbtIncidente) {
				if (in_array($rbtIncidente, $_SESSION['chkSel'])) {
					if (($key = array_search((int) $rbtIncidente, $_SESSION['chkSel'])) !== false) {
						unset($_SESSION['chkSel'][$key]);
					}
				} else {
					array_push($_SESSION['chkSel'], (int) $rbtIncidente);
				}
			}
		}

		return $params->rbtIncidente;
	}

	function reporte($params)
	{
		$pg = new PgSql();

		if (isset($params->geoJson)) {
			$data = $pg->getRow("SELECT
             row_to_json(fc) as vo_ch_coordinates
            FROM (
             SELECT
              'FeatureCollection' As type,
              array_to_json(array_agg(f)) As features
             FROM (
              SELECT
               'Feature' As type,
               ST_AsGeoJSON(ST_MakePoint(inc.longitud, inc.latitud))::json As geometry,
               row_to_json((SELECT l FROM (
			    SELECT 
				 incidente_id
			   ) As l)) As properties
              from sae.ssc_incidente inc 
			  left join sae.ssc_persona ps on ps.persona_id = inc.persona_id
			  left join sae.ssc_multitabla cla on cla.tabla = 'ssc_clasificacion_inc'
			  where
			   ps.nro_doc_identidad = '" . $params->dni . "'
			  order by inc.fecha_registro desc
			  limit 100
             ) As f 
            )  As fc");
			return $data->vo_ch_coordinates;
		} else {
			return $pg->getRows("select 			 
			 inc.latitud, 
			 inc.longitud, 
			 cla.valor as clasificacion, 
			 to_char(inc.fecha_registro, 'dd/mm/yyyy hh:mm') as fecha_registro, inc.incidencia_descripcion, 
			 inc.estado_atencion 
			from sae.ssc_incidente inc 
			left join sae.ssc_persona ps on ps.persona_id = inc.persona_id
			left join sae.ssc_multitabla cla on cla.tabla = 'ssc_clasificacion_inc' and cla.multitabla_id = inc.clasificacion_incidente_id
			where
			 ps.nro_doc_identidad = '" . $params->dni . "'
			order by inc.fecha_registro desc
			limit 100");
		}
	}

	function informe_incidente($params)
	{
		$pg = new PgSql();

		return $pg->getRow("select 
         to_char(inc.fecha_registro, 'dd/mm/yyyy hh:mm') as fecha_registro,
         case
          when inc.canal_comunicacion_id = 1 then 'PBX'
          when inc.canal_comunicacion_id = 2 then 'APP'
          when inc.canal_comunicacion_id = 3 then 'SOS'
         end as origen,
         case
          when inc.estado_atencion = 'P' then 'Pendiente'
          when inc.estado_atencion = 'T' then 'En proceso'
          when inc.estado_atencion = 'C' then 'Concluido'
         end as estado,
         ps.nro_doc_identidad,
         COALESCE(COALESCE(ps.nombres_apellidos_completos,INITCAP(ps.nombres || ' ' || ps.apellido_paterno || ' ' || ps.apellido_materno)), inc.nro_telefono) as ciudadano,
         inc.nro_telefono,
         cla.valor as clasificacion_inc,         
         tip.valor as tipo_inc,
		 sub.valor as sub_tipo_inc,
         inc.incidencia_descripcion,
         inc.incidencia_direccion,
         round(inc.latitud,6) as latitud,
		 round(inc.longitud,6) as longitud,
         inc.direccion_nro,
         inc.direccion_interior,
         inc.direccion_lote,
         inc.direccion_referencia
        from sae.ssc_incidente inc
        left join sae.ssc_persona ps on ps.persona_id = inc.persona_id
        left join sae.ssc_multitabla cla on cla.tabla = 'ssc_clasificacion_inc' and cla.multitabla_id = inc.clasificacion_incidente_id
        left join sae.ssc_multitabla tip on tip.tabla = 'ssc_tipo_inc' and tip.multitabla_id 	 = inc.tipo_incidente_id
        left join sae.ssc_multitabla sub on sub.tabla = 'ssc_subtipo_inc' and sub.multitabla_id  = inc.subtipo_incidente_id
        where
		 inc.incidente_id = " . $params->incidente_id);
	}

	function geoserver_incidentes($params, $status)
	{
		$pg        = new PgSql();
		$where     = [];

		if (isset($params->ddlClasificacion) && count($params->ddlClasificacion) > 0) {
			array_push($where, "clasificacion_incidente_id in(" . join(",", $params->ddlClasificacion) . ")");
		}

		if (isset($params->txtSector) && isset($params->txtSector) > 0) {
			array_push($where, "sector_id in (" . join(",", $params->txtSector) . ")");
		}

		if (isset($params->txtFecRegistro) && strlen($params->txtFecRegistro) > 0) {
			$txtFecRegistro = explode(" ", $params->txtFecRegistro);
			if (count($txtFecRegistro) == 3) {
				array_push($where, "fecha_registro::date between to_date('" . $txtFecRegistro[0] . "', 'dd-mm-yyyy') and to_date('" . $txtFecRegistro[2] . "', 'dd-mm-yyyy')");
			}
		}

		if (isset($status)) {
			array_push($where, "estado_atencion = '" . $status . "'");
		}

		return $pg->getRows("select
		 'S' || sector_id as sector_id,
		 count(*) as cant,
		 round(COUNT(*) / sum(COUNT(*)) over (partition by 1) * 100,2) as porcentaje
		from sae.ssc_incidente
		where " . (count($where) > 0 ? join(" and ", $where) : '1 = 1') .
			"group by
		 sector_id
		order by
		 cant desc");
	}

	function geoserver_incidentes_t($params)
	{
		$pg        = new PgSql();
		$where     = [];

		if (isset($params->ddlClasificacion) && count($params->ddlClasificacion) > 0) {
			array_push($where, "clasificacion_incidente_id in(" . join(",", $params->ddlClasificacion) . ")");
		}

		if (isset($params->txtSector) && isset($params->txtSector) > 0) {
			array_push($where, "sector_id in (" . join(",", $params->txtSector) . ")");
		}

		if (isset($params->txtFecRegistro) && strlen($params->txtFecRegistro) > 0) {
			$txtFecRegistro = explode(" ", $params->txtFecRegistro);
			if (count($txtFecRegistro) == 3) {
				array_push($where, "fecha_registro::date between to_date('" . $txtFecRegistro[0] . "', 'dd-mm-yyyy') and to_date('" . $txtFecRegistro[2] . "', 'dd-mm-yyyy')");
			}
		}

		return $pg->getRows("select 
         sector_id, 
         pendientes, 
         en_proceso, 
         atendidas,
         pendientes + en_proceso + atendidas as total,
         round((pendientes + en_proceso + atendidas) / sum(pendientes + en_proceso + atendidas) over (partition by 1) * 100,2) as porcentaje
        from( 
         select 
          'S' || sector_id as sector_id, 
          COUNT(case when estado_atencion = 'P' then 1 end) as pendientes, 
          COUNT(case when estado_atencion = 'T' then 1 end) as en_proceso, 
          COUNT(case when estado_atencion = 'C' then 1 end) as atendidas 
         from sae.ssc_incidente 
         where " . (count($where) > 0 ? join(" and ", $where) : '1 = 1') . "
         group by 
          sector_id 
        ) x
        order by
         porcentaje desc");
	}
}
