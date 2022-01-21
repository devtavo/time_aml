<?php
$webconfig = include("webconfig.php");
require_once($webconfig['path_ws']);

if (count($_GET) > 0) {
    $params = (object)$_GET;

    $fs_incidente = callFunction((object) ['class' => 'TimeController', 'method' => 'findByIdPersona', 'idpersona' => $params->idpersona]);

    // var_dump($fs_incidente);
    // $fs_ciudadano = callFunction((object) ['class' => 'CiudadanoController', 'method' => 'findById', 'nro_telefono' => $fs_incidente->telefono]);
    // $fs_clasf_inc = callFunction((object) ['class' => 'MultitablaController', 'method' => 'index', 'tabla' => 'ssc_clasificacion_inc']);
    // $fs_tipo_inc  = callFunction((object) ['class' => 'MultitablaController', 'method' => 'index', 'tabla' => 'ssc_tipo_inc', 'padre_id' => $fs_incidente->clasificacion_inc_id]);
    // $fs_subtipo_inc  = callFunction((object) ['class' => 'MultitablaController', 'method' => 'index', 'tabla' => 'ssc_subtipo_inc', 'padre_id' => $fs_incidente->tipo_incidente_id]);
?>
    <div class="modal-header">
        <h4 class="modal-title">Detalle Nro° <? echo $fs_incidente[0]->idpersona ?></h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>

    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">Datos personales del cliente</div>
                        <div id="m_buscador" class="panel-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Nombre y apellidos</label>
                                                    <input class="input form-control input-sm" type="text" name="nombre" id="nombre" placeholder="" value="<?php echo $fs_incidente[0]->nombres_completos; ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>DNI </label>
                                                    <input class="input form-control input-sm" type="number" name="dni" id="dni" placeholder="" value="<?php echo $fs_incidente[0]->nro_doc_identidad; ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Correo </label>
                                                    <div class="input-group">
                                                        <input class="input form-control input-sm" type="text" name="correo" id="correo" placeholder="" value="<?php echo $fs_incidente[0]->correo; ?>"><span class="input-group-addon"> <i class="glyphicon glyphicon-envelope"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Proceso</th>
                                                        <th>Descripción / Area</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <? $i = 0;
                                                    foreach ($fs_incidente as $key) {
                                                        $i++; ?>
                                                        <tr data-id=<? echo $key->id ?>>
                                                            <td><? echo $i; ?></td>
                                                            <td><? echo $key->titulo; ?></td>
                                                            <td><? echo $key->comment; ?></td>
                                                            <td><button type="button" style="background:gray;color:white;font-size: .7em;" class="input form-control" data-toggle="modal" name="time" id="time" data-target="#m_det_time">
                                                                    Ver
                                                                </button></td>

                                                        </tr>
                                                    <? } ?>
                                                </tbody>
                                                <!-- <?php var_dump($fs_incidentes); ?> -->

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="container-login100">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
												<label>Cursos o diplomados Comprados</label>

												<?php $a = array();
                                                $a = $fs_incidente->curso;
                                                echo $a[1];
                                                var_dump($a); ?>	
												
											</div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Certificacion CAC</label>
                                                    <input class="input form-control input-sm" type="text" name="certificado" id="certificado" placeholder="">
                                                    
                                                </div>
                                                <div class="row">
                                                    <div class="col" id="cuanto" hidden>
                                                        <p><b>Certificacion CAC ¿Cuantos?</b></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <p><b>Diplomados o curso seleccionados</b></p>
                                                        <div id="seleccionados" class="input-xs">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Observaciones</label>
                                                    <textarea class="input form-control input-sm" type="text" rows="12" name="observaciones" id="observaciones" placeholder=""><?php echo $fs_incidente->observaciones; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>