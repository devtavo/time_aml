<?php
$obj  = count($_GET) > 0 ? $_GET : $_POST;
$_GET = $_POST = array();
$webconfig = include("../../webconfig.php");
require_once($webconfig['path_ws']);
//var_dump($obj);
$fs_incidentes = callFunction((object) array_merge(['class' => 'IncidenteController', 'method' => 'index'], $obj));
//var_dump($fs_incidentes);
if (count($fs_incidentes) > 0) {
	foreach ($fs_incidentes as $fs_incidente) {
		$class = isset($obj['highlight']) ? $obj['highlight'] : '';
?>
		<tr class="<?php echo $class; ?>" data-id="<?php echo $fs_incidente->idusuario; ?>" >
			<td>
				<input type="checkbox" name="chkSel[]" value="<?php echo $fs_incidente->idusuario; ?>" />
			</td>
			
			<td>
				<a href="informe_incidencias.php?id=<?php echo $fs_incidente->idusuario; ?>" target="_blank"> <?php echo $fs_incidente->idusuario; ?>
				</a>
			</td>
			<td><?php echo $fs_incidente->nombres_completos; ?></td>
			<td><?php echo $fs_incidente->fecha_registro; ?></td>
			
			<td>
				<label name="lblClasificInc[]">cpp-001</label>
			</td>
		
			<td class="text-left">
				

				<?php
				$msj = 'Ver documento';
				$disabled = '';

				?>

				
					<button type="button" class="btn btn-success btn-xs" name="btnEditarInc[]" <?php echo $disabled; ?> data-toggle="tooltip" data-placement="top" title="<?php echo $msj; ?>" title="Cerrar caso">
						<!--Cerrar caso-->
						<span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
					</button>
					<button type="button" class="btn btn-success btn-xs" name="btndescarga[]" <?php echo $disabled; ?> data-toggle="tooltip" data-placement="top" title="Descargar documento" title="Cerrar caso">
						<!--Cerrar caso-->
						<span class="glyphicon glyphicon-download" aria-hidden="true"></span>
					</button>

				<?php
				if ($fs_incidente->estado == 'C') {
				?>
					<button type="button" class="btn btn-success btn-xs" name="btnAdjInc[]" title="Ver documento de cierre">
						<!--Doc. Cierre-->
						<span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>
					</button>
				<?php
				}
				?>
			</td>
		</tr>
	<?php
	}
} else { ?>
	<tr class="rows_0">
		<td colspan="11" class="text-center">No se encontraron registros coincidentes</td>
	</tr>
<?php
}
?>