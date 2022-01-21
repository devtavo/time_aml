<?php
	$webconfig = include("../../webconfig.php");
	require_once($webconfig['path_ws']);
	
	if(count($_GET) > 0){
		$params		  = (object)$_GET;
		
		$fs_incidente    = callFunction((object) ['class' => 'IncidenteController', 'method' => 'findById', 'incidente_id' => $params->incidente_id]);
		$fs_archivo_inc  = callFunction((object) ['class' => 'ArchivoController', 'method' => 'findById', 'incidente_id' => $params->incidente_id]);
		$fs_cierre_inc   = callFunction((object) ['class' => 'IncidenteLogController', 'method' => 'findById', 'incidente_id' => $params->incidente_id, 'tipo_evento_id' => 129]);
		$fs_cierre_inc_det = $fs_cierre_inc != null ? json_decode($fs_cierre_inc->detalle) : '';		
?>		
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Cerrar Incidente N° <?php echo $params->incidente_id;?></h4>
	</div>	
	<div class="modal-body">
		<input type="hidden" id="txtIndicenteId" value="<?php echo $params->incidente_id;?>"/>		
		<form id="frmCerrarCaso" data-toggle="validator" role="form">			
			<input type="text" name="txtAdjTmp" class="hide"/>					
			<div class="row">
				<div class="col-lg-12"> 
					<div class="form-group">
						<label>Adjunto</label>
						<input type="file" name="txtAdjunto[]" accept="application/pdf" multiple />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">
						<label>Comentarios/Observaciones</label>
						<textarea name="txtComentarios" class="form-control" cols="105" rows="3" style="text-align: justify;font-size: 12px;" required></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">
						<label>Palabras clave</label>
						<input type="text" name="txtPalabrasClave" class="form-control"/>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 text-center">
					<button type="submit" class="btn btn-primary">Grabar</button>
					<button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</form>		
	</div>
	<div class="modal-footer hide" style="text-align: center">
		<button type="button" id="btnGrabar" class="btn btn-primary">Grabar</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	</div>
<?php
	}
?>