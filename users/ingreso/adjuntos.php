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
		<div class="row">
			<div class="col-lg-6">
				<div class="row">
					<div class="col-lg-12"> 
						<div class="form-group">
							<label>Archivos:</label>
							<ul>											
								<?php 
									foreach ($fs_archivo_inc as $key_archivo_inc){ 
										$path = "../../docs/" . $key_archivo_inc->fecha_registro . "/" . $key_archivo_inc->nombre_fisico;
								?>
									<li>
										<a href="javascript:;" data-route="<?php echo $path;?>" onclick="App.refreshIframe('ifAdjuntos', '<?php echo $path;?>');">
											<?php echo $key_archivo_inc->nombre_real;?>
										</a>
										
										<a href="<?php echo $path;?>" target="_blank">
											<span class="glyphicon glyphicon-share" aria-hidden="true"></span>
										</a>
									</li>							
									<li class="hide">
										<a href="../../docs/<?php echo $key_archivo_inc->fecha_registro;?>/<?php echo $key_archivo_inc->nombre_fisico;?>" target="_blank"><?php echo $key_archivo_inc->nombre_real;?></a>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="form-group">
							<label>Comentarios/Observaciones</label>
							<textarea name="txtComentarios" class="form-control" cols="105" rows="3" style="text-align: justify;font-size: 12px;" readonly><?php echo isset($fs_cierre_inc_det->comentario) ? $fs_cierre_inc_det->comentario : '';?></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="form-group">
							<label>Palabras clave</label>
							<input type="text" name="txtPalabrasClave" class="form-control" value="<?php echo isset($fs_cierre_inc_det->palabras_clave) ? $fs_cierre_inc_det->palabras_clave : '';?>" disabled />
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<?php if(count($fs_archivo_inc) > 0){?>
				<iframe id="ifAdjuntos" class="" src="../../docs/<?php echo $fs_archivo_inc{0}->fecha_registro;?>/<?php echo $fs_archivo_inc{0}->nombre_fisico;?>" height="500px"width="100%"></iframe>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="modal-footer hide" style="text-align: center">
		<button type="button" id="btnGrabar" class="btn btn-primary">Grabar</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	</div>
<?php
	}
?>