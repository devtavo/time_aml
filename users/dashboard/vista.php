<?php
$obj  = count($_GET) > 0 ? $_GET : $_POST;
$_GET = $_POST = array();
$webconfig = include("../../webconfig.php");
require_once($webconfig['path_ws']);
//var_dump($obj);
$fs_incidentes = callFunction((object) ['class' => 'EnviosController', 'method' => 'index']);
//var_dump($fs_incidentes);
$cont = 0;
if (count($fs_incidentes) > 0) {
	foreach ($fs_incidentes as $fs_incidente) {
		$cont++;
		$class = isset($obj['highlight']) ? $obj['highlight'] : '';
?>
		<tr class="<?php echo $class; ?>" data-id="<?php echo $fs_incidente->id_envios; ?>">
			<!-- <td>
				<input type="checkbox" name="chkSel[]" value="<?php echo $fs_incidente->id_envios; ?>" />
			</td> -->

			<td>
				<?php echo $fs_incidente->id_envios; ?>
				</a>
			</td>
			<td>
				<?php
				if ($fs_incidente->dequien == 0) {
					echo "Ninguno";
				} elseif ($fs_incidente->dequien == 1) {
					echo "Karen Leon";
				} elseif ($fs_incidente->dequien == 2) {
					echo "Alberto Maguiña";
				} elseif ($fs_incidente->dequien == 3) {
					echo "Cesar Canales";
				} elseif ($fs_incidente->dequien == 7) {
					echo "Jesus Vera";
				} elseif ($fs_incidente->dequien == 5) {
					echo "IDRA - Capacitaciones";
				} elseif ($fs_incidente->dequien == 8) {
					echo "Samantha Salazar";
				} elseif ($fs_incidente->vendedor == 9) {
					echo "Rosalina Moya";
				} elseif ($fs_incidente->vendedor == 10) {
					echo "Nadia Espino";
				} elseif ($fs_incidente->vendedor == 11) {
					echo "Jade Perez";
				} elseif ($fs_incidente->vendedor == 12) {
					echo "Naomy Tello";
				} elseif ($fs_incidente->vendedor == 13) {
					echo "Ryu Hanashiro Kohira";
				} elseif ($fs_incidente->vendedor == 14) {
					echo "Diego Rafael García Risco";
				}
				?>
			</td>
			<td><?php echo $fs_incidente->nombres; ?></td>

			<td>
				<label name="lblClasificInc[]"><?php echo $fs_incidente->fechaenvio ?></label>
			</td>
			<td>
				<label name="estado[]"><?php
										if ($fs_incidente->estado == '0') {
											echo "Pendiente de envio";
										} else if ($fs_incidente->estado == '1') {
											echo "Enviado";
										}
										?></label>
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


			</td>
		</tr>
	<?php
	}
} else { ?>
	<tr class="rows_0">
		<td colspan="11" class="text-center">No se encontraron registros de envios</td>
	</tr>
<?php
}
?>