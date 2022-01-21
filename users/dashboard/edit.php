<?php
$webconfig = include("../../webconfig.php");
require_once($webconfig['path_ws']);

if (count($_GET) > 0) {
    $params = (object)$_GET;

    $fs_incidente = callFunction((object) ['class' => 'EnviosController', 'method' => 'findById', 'id_envios' => $params->id_envios]);
    // $fs_ciudadano = callFunction((object) ['class' => 'CiudadanoController', 'method' => 'findById', 'nro_telefono' => $fs_incidente->telefono]);
    // $fs_clasf_inc = callFunction((object) ['class' => 'MultitablaController', 'method' => 'index', 'tabla' => 'ssc_clasificacion_inc']);
    // $fs_tipo_inc  = callFunction((object) ['class' => 'MultitablaController', 'method' => 'index', 'tabla' => 'ssc_tipo_inc', 'padre_id' => $fs_incidente->clasificacion_inc_id]);
    // $fs_subtipo_inc  = callFunction((object) ['class' => 'MultitablaController', 'method' => 'index', 'tabla' => 'ssc_subtipo_inc', 'padre_id' => $fs_incidente->tipo_incidente_id]); 
?>
    <div class="modal-header">
        <h4 class="modal-title">Detalle Nro° <?php echo $fs_incidente->id_envios; ?> </h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary ">
                        <div class="panel-heading">Datos personales del cliente</div>
                        <div id="m_buscador" class="panel-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                <input class="input form-control input-sm" type="text" name="id_envios" id="id_envios" placeholder="" value="<?php echo $fs_incidente->id_envios; ?>" disabled hidden>

                                                    <label>Nombre y apellidos</label>
                                                    <input class="input form-control input-sm" type="text" name="nombre" id="nombre" placeholder="" value="<?php echo $fs_incidente->nombres; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>DNI </label>
                                                    <input class="input form-control input-sm" type="number" name="dni" id="dni" placeholder="" value="<?php echo $fs_incidente->dni; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Telefono Celular </label>
                                                    <div class="input-group">
                                                        <input class="input form-control input-sm" type="text" name="telefono" id="telefono" placeholder="" value="<?php echo $fs_incidente->telefono; ?>" disabled>
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
                                        <div class="row">
                                            <!-- <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Profesion</label>
                                                    <input class="input form-control input-sm" type="text" name="profesion" id="profesion" placeholder="" readonly>
                                                </div>
                                            </div> -->
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Direccion</label>
                                                    <div class="input-group">
                                                        <input class="input form-control input-sm input-dt" type="text" name="direccion" id="direccion" placeholder="dd/mm/yyyy" value="<?php echo $fs_incidente->direccion; ?>" disabled><span class="input-group-addon">
                                                            <i class="glyphicon glyphicon-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Correo</label>
                                                    <div class="input-group">
                                                        <input class="input form-control input-sm" type="text" name="correo" id="correo" placeholder="" value="<?php echo $fs_incidente->correo; ?>" disabled><span class="input-group-addon"> <i class="glyphicon glyphicon-envelope"></i></span>
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
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Distrito</label>
                                                    <input class="input form-control input-sm" type="text" name="distrito" id="distrito" placeholder="" value="<?php echo $fs_incidente->distrito; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Provincia</label>
                                                    <input class="input form-control input-sm" type="text" name="provincia" id="provincia" placeholder="" value="<?php echo $fs_incidente->provincia; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Departamento</label>
                                                    <input class="input form-control input-sm" type="text" name="departamento" id="departamento" placeholder="" value="<?php echo $fs_incidente->departamento; ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Referencia</label>
                                                    <input class="input form-control input-sm" size="38" type="text" name="referencia" id="referencia" placeholder="" value="<?php echo $fs_incidente->referencia; ?>" disabled>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Realizaron el pago del envio</label>
                                                    <input class="input form-control input-sm" type="text" name="pagorealizado" id="pagorealizado" placeholder="" value="<?php echo $fs_incidente->pagorealizado; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Fecha de registro</label>
                                                    <input class="input form-control input-sm" type="text" name="fecharegistro" id="fecharegistro" placeholder="" value="<?php echo $fs_incidente->fechapago; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label>Monto del pago</label>
                                                    <input class="input form-control input-sm" type="text" name="montopagado" id="montopagado" placeholder="" value="<?php echo $fs_incidente->montopagado; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label>N° Tracking</label>
                                                    <input class="input form-control input-sm" type="text" name="numerotrack" id="numerotrack" placeholder="" value="<?php echo $fs_incidente->nrotrack; ?>" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label>Detalle y/o observaciones</label>
                                                    <textarea class="input form-control input-sm" type="text" rows="5" name="observaciones" id="observaciones" placeholder="" value="" disabled><?php echo $fs_incidente->observaciones; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Cambiar Estado</label>
                                                    <select name="ddlestado" id="ddlestado" class="form-control input-sm" data-actions-box="true">

                                                        <option value="0">Pendiente</option>
                                                        <option value="1">Enviado</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <button type="button" name="guardaenvio" id="guardarenvio" class="btn btn-primary">Guardar</button>
                                        <button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>