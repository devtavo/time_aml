<?php
	$webconfig = include("../../webconfig.php");
	require_once($webconfig['path_ws']);
	
	if(count($_SESSION['chkSel']) > 0){		
		$fs_incidentes = callFunction((object) ['class' => 'IncidenteController', 'method' => 'incidencias_agrupadas', 'ddlIncidentes' => $_SESSION['chkSel']]);
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Agrupar Incidentes</h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-lg-12">
			<p>Presione clic en el círculo para identificar cual será la incidencia principal que agrupará a las demás.</p>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12" style="height: 400px; overflow-y: scroll;">
			<table class="table table-striped table-responsive">
				<thead>
					<tr>
						<th></th>
						<th>Nro. Caso</th>
						<th>Fecha</th>
						<th>Denunciante</th>
						<th>Estado</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($fs_incidentes as $fs_incidente){ ?>
						<tr>
							<td>
								<input type="radio" name="rbtIncidente[]" value="<?php echo $fs_incidente->incidente_id;?>" <?php echo $fs_incidentes{0}->incidente_id == $fs_incidente->incidente_id ? 'checked' : ''; ?> />
							</td>
							<td><?php echo $fs_incidente->incidente_id;?></td>
							<td><?php echo $fs_incidente->fecha_registro;?></td>
							<td><?php echo $fs_incidente->ciudadano;?></td>
							<td>
								<?php if($fs_incidente->estado_atencion == "D"){ ?>
									<span class="label label-default">Pendiente</span>
								<?php }elseif ($fs_incidente->estado_atencion == "C") {?>			
									<span class="label label-success">Cerrado</span>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="modal-footer" style="text-align: center !important;"> 
	<button type="button" name="btnAgrInc" class="btn btn-primary">Guardar</button> 
	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button> 
</div>
<?php
	}
?>