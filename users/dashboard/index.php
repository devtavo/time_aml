<?php
$webconfig = include("../../webconfig.php");
//echo $webconfig['path_ws'];
require_once($webconfig['path_ws']);

$_SESSION['chkSel'] = array();

//$fs_clasf_inc  = callFunction((object) ['class' => 'MultitablaController', 'method' => 'index', 'tabla' => 'ssc_clasificacion_inc']);
//$fs_origen_inc = callFunction((object) ['class' => 'MultitablaController', 'method' => 'index', 'tabla' => 'ssc_origen_inc']);

/*var_dump($fs_clasf_inc);
*/
// $fs_estado_inc = array(
// 	(object) array('id' => 'P', 'etiqueta' => 'Pendiente'),
// 	(object) array('id' => 'T', 'etiqueta' => 'En proceso'),
// 	(object) array('id' => 'C', 'etiqueta' => 'Concluido')
// );

?>
<!DOCTYPE html>
<html>

<head>
    <title>IDRA Capacitaciones - envios
    </title>
    <!--<link rel="stylesheet" href="../../assets/bootstrap/bootstrap.min.css">-->
    <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->
    <!--<link rel="stylesheet" href="../../assets/leaflet/leaflet.css">-->
    <!--<link rel="stylesheet" href="../../assets/geocoder/esri-leaflet-geocoder.css">-->
    <!--<link rel="stylesheet" href="../../assets/extramarkers/css/leaflet.extra-markers.min.css">-->
    <link rel="stylesheet" href="../../assets/select/bootstrap-select.min.css">
    <!--<link rel="stylesheet" href="../../assets/fontawesome/font-awesome.css">-->
    <!--<link rel="stylesheet" href="../../assets/daterangepicker/daterangepicker.css">-->
    <link rel="stylesheet" href="../../assets/toast/jquery.toast.css">
    <link  rel="icon"   href="../../assets/app/img/logo.ico" type="image/png" />
    <!--<link rel="stylesheet" href="../../assets/tagsinput/bootstrap-tagsinput.css" crossorigin="anonymous">-->
    <!--<link rel="stylesheet" href="../../assets/multiselect/multi-select.css" />-->
    <!--<link rel="stylesheet" href="../../assets/app/css/app.css" />-->

    <!---->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="css.css" />-->
    <title>ENVIOS - IDRA</title>
    <link rel="stylesheet" href="../../assets/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="../../assets/select/bootstrap-select.min.css">
    <link rel="stylesheet" href="../../assets/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="../../assets/tagsinput/bootstrap-tagsinput.css" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/multiselect/multi-select.css" />

    <!---->

    <style>
        body {
            padding-top: 0px;
        }

        #tblIncidencias tr * {
            font-size: 12px !important;
        }

        .bootstrap-tagsinput {
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            display: block;
            padding: 4px 6px;
            color: #555;
            vertical-align: middle;
            border-radius: 4px;
            max-width: 100%;
            line-height: 22px;
            cursor: text;
        }

        .bootstrap-tagsinput input {
            border: none;
            box-shadow: none;
            outline: none;
            background-color: transparent;
            padding: 0 6px;
            margin: 0;
            width: auto;
            max-width: inherit;
        }

        .brand img {
            margin-top: 5px
        }

        div {
            border: solid 1px red;
        }

        @media (max-width:768px) {
            .brand img {
                margin-bottom: 5px
            }

            .navbar .btn-navbar {
                /*margin-right: -15px;*/
            }

            .navbar .nav>li>a {
                padding: 10px 15px;
            }
        }

        .pagination {
            margin: 0px 0px;
        }

        .highlight {
            background-color: #b8ff6a21 !important;
        }

        .highlight-sos {
            background-color: #721c2430 !important;
        }

        .panel {
            margin-bottom: 0px;
        }

        .btn-group-xs>.btn .badge,
        .btn-xs .badge {
            top: -1px;
        }

        .header {
            font-size: 20px;
            color: #1C5487;
            padding-left: 15px;
            font-weight: 600;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .contenedor {
            position: relative;
            /* display: inline-block; */
            text-align: left;
            border: #000 0.2px solid;
        }

        .texto-encima {
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .centrado {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .cabecera {
            font-size: 25px;
            color: #16837D;
        }

        .nombre {
            font-size: 60px;
            color: #16837D;
            padding-top: 10px;
        }

        .curso {
            font-size: 15px;
            color: #16837D;
            text-align: justify;
            font-weight: 500;
        }

        .footer {
            font-size: 13px;
            color: #16837D;
            text-align: justify;
            border: #16837D 0.5px solid;
        }

        .fecha {
            font-size: 15px;
            color: #16837D;
        }

        div {
            border: 0px solid red;
        }
    </style>
</head>

<body>

    <div class="logo2 container">
        <div class="row">
            <img src="../../assets/app/img/logo.png" width="200px" height="75px" />

            <div class="col-lg-12"><br>
                <!-- <h4 class="titulo"><Strong>DASHBOARD- IDRA INTERNO</strong></h4> -->
                <!-- <a name="cerrarsesion" href="../login/cerrar_sesion.php">Cerrar sesión</a> -->
            </div>

        </div>
    </div><br>
    <div>

    </div>


    <form id="frmIndex" action="index.php" method="post">
        <div class="container" style="margin-top: 20px	;">
            <div class="row">
                <div class="col-lg-12">
                    <!-- <div class="panel panel-default">
					<div class="header"> Verificación y validación de documentos oficiales emitidos por IDRA Capacitaciones
					</div>
					<div class="panel-body"> -->
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-11">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Registro de envios IDRA
                                    </div>
                                    <div id="m_buscador" class="panel-body">
                                        <!-- <div class="row">
												<div class="col-lg-12">
													<div class="alert alert-warning alert-dismissible fade in">
														<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
														<strong>! </strong>Para verificar la autenticidad de una certificación digital, ingrese los datos que se solicitan a continuación:
													</div>

												</div>
											</div> -->
                                        <!-- <div class="row">
                                            <div class="col-lg-7">

                                                <div class="panel panel-default">
                                                    <div class="panel-body">

                                                        <form id="frmIndex" action="index.php" method="post">
                                                            <div class="row">

                                                             
                                                                <div class="col-lg-5">
                                                                    <div class="form-group">
                                                                        <label>Rango de fecha</label>
                                                                        <?php
                                                                        $dt = isset($_POST['txtFecRegistro']) ? $_POST['txtFecRegistro'] : '';
                                                                        $fi = date('01-m-Y');
                                                                        $ff = date('d-m-Y');

                                                                        if (strlen($dt) == 23) {
                                                                            $tmp = explode("-", $dt);
                                                                            $fi  = $tmp{
                                                                            0};
                                                                            $ff  = $tmp{
                                                                            1};
                                                                        }
                                                                        ?>
                                                                        <input type="text" name="txtFecRegistro" class="form-control input-sm" placeholder="dd/mm/yyyy - dd/mm/yyyy" value="<?php echo $fi; ?> - <?php echo $ff; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label>Estado</label>
                                                                        <select name="ddlvendedor[]" class="form-control input-sm selectpicker" data-actions-box="true" multiple>
                                                                            <option value="1">Karen Leon</option>
                                                                            <option value="2">Alberto Maguiña</option>
                                                                            <option value="7">Jesus Vera</option>
                                                                            <option value="5">DRA - Capacitaciones</option>

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-8">
                                                                    <div class="form-group">
                                                                        <label>&nbsp;</label>
                                                                        <div class="row">
                                                                            <div class="col-lg-6">
                                                                                <input type="submit" name="btnBuscar" class="btn btn-primary btn-sm btn-block" value="Validar" />
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <input type="button" name="btnLimpiar" class="btn btn-sm btn-block" value="Limpiar" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="row" style="margin-top: 5px;">
                                            <div class="col-lg-12 text-right">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div id="paginator"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <!-- <div id="TblIncMsg">
                                                            Mostrando <b id="txtIni">0</b> de <b id="txtFin">0</b> de un total de <b id="txtCantidad">0</b> registros
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table id="tblIncidencias" class="table table-striped table-responsive">
                                                    <thead>
                                                        <tr>
                                                          
                                                            <th width="4%">Nro ingreso</th>
                                                            <th width="15%">Enviado por</th>
                                                            <th width="15%">Enviado a</th>
                                                            <th width="15%">Fecha Envio</th>
                                                            <th width="15%">Estado</th>
                                                            <th width="5%">Detalle</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- </div>
				</div> -->
                </div>

            </div>
        </div>
    </form>
    <!-- <a target="_blank" href="https://calendar.google.com/event?action=TEMPLATE&amp;tmeid=MmwzYWxzaDAzbnQzY2htaDZjY2t0NTM3MmEgZ3VzdGF2b3JleWVzemFwYXRhQG0&amp;tmsrc=gustavoreyeszapata%40gmail.com"><img border="0" src="https://www.google.com/calendar/images/ext/gc_button1_es.gif"></a> -->
    <!--MODAL DETALLE INCIDENTE-->
    <div id="m_det_incidencia" class="modal fade" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            </div>
        </div>
    </div>


    <!--MODAL DETALLE INCIDENTE-->
    <div id="m_crear_incidencia" class="modal fade" role="dialog">
        <div class="modal-dialog" style="width: 600px;">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <!--END MODAL DETALLE INCIDENTE-->

    <!--MODAL CERRAR INCIDENTE-->
    <div id="m_cerrar_incidencia" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <!--END MODAL CERRAR INCIDENTE-->

    <!--MODAL VER ADJUNTOS-->
    <div id="m_adj_incidencia" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <!--END MODAL VER ADJUNTOS-->

    <!--MODAL VER UNIDAD-->
    <div id="m_adj_unidad" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <!--END MODAL VER UNIDAD-->

    <!--MODAL AGRUPAR INCIDENTE-->
    <div id="m_agr_incidencia" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <!--END MODAL AGRUPAR INCIDENTE-->
    <script type="text/javascript" src="../../assets/jquery/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="../../assets/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../assets/select/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="../../assets/moment/moment.min.js"></script>
    <script type="text/javascript" src="../../assets/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="../../assets/tagsinput/bootstrap-tagsinput.min.js"></script>
    <script type="text/javascript" src="../../assets/select/defaults-es_ES.min.js"></script>
    <script type="text/javascript" src="../../assets/multiselect/jquery.multi-select.js"></script>
    <script type="text/javascript" src="../../assets/validator/validator.js"></script>
    <!--<script type="text/javascript" src="../../assets/jquery/jquery.min.js"></script>-->
    <!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
    <!--<script type="text/javascript" src="../../assets/leaflet/leaflet.js"></script>-->
    <!--<script type="text/javascript" src="../../assets/geocoder/esri-leaflet.js"></script>-->
    <!--<script type="text/javascript" src="../../assets/geocoder/esri-leaflet-geocoder.js"></script>-->
    <!--<script type="text/javascript" src="../../assets/extramarkers/js/leaflet.extra-markers.min.js"></script>-->
    <!--<script type="text/javascript" src="../../assets/bootstrap/bootstrap.min.js"></script>-->
    <!--<script type="text/javascript" src="../../assets/select/bootstrap-select.min.js"></script>-->
    <!--<script type="text/javascript" src="../../assets/bootpag/jquery.bootpag.js"></script>-->
    <!--<script type="text/javascript" src="../../assets/moment/moment.min.js"></script>-->
    <!--<script type="text/javascript" src="../../assets/daterangepicker/daterangepicker.min.js"></script>-->
    <script type="text/javascript" src="../../assets/toast/jquery.toast.min.js"></script>
    <!--<script type="text/javascript" src="../../assets/tagsinput/bootstrap-tagsinput.min.js"></script>-->
    <!--<script type="text/javascript" src="../../assets/select/defaults-es_ES.min.js"></script>-->
    <!--<script type="text/javascript" src="../../assets/multiselect/jquery.multi-select.js"></script>-->
    <!--<script type="text/javascript" src="../../assets/validator/validator.js"></script>-->
    <!--<script type="text/javascript" src="../../assets/socket/socket.io.min.js"></script>-->
    <script type="text/javascript" src="../../assets/app/js/app.js"></script>
    <script type="text/javascript" src="../../assets/app/js/users/dashboard/index.js"></script>
    <script type="text/javascript" src="../../assets/app/js/users/dashboard/edit.js"></script>
    <!--<script type="text/javascript" src="../../assets/app/js/users/incidentes/create.js"></script>-->
    <!--<script type="text/javascript" src="../../assets/app/js/users/incidentes/cerrar.js"></script>-->
    <!--<script type="text/javascript" src="../../assets/app/js/users/incidentes/agrupar.js"></script>-->
    <!--<script type="text/javascript" src="../../assets/app/js/users/incidentes/unidad_movil.js"></script>-->

    <script>
        $(document).ready(function() {
            App.init();
            AppIndexIncidente.init();
        });
    </script>

    <script>
        $(function() {
            $('input[name="fecha"]').daterangepicker({
                "locale": {
                    "format": "DD-MM-YYYY",
                    "separator": " - ",
                    "applyLabel": "Guardar",
                    "cancelLabel": "Cancelar",
                    "fromLabel": "Desde",
                    "toLabel": "Hasta",
                    "daysOfWeek": [
                        "Do",
                        "Lu",
                        "Ma",
                        "Mi",
                        "Ju",
                        "Vi",
                        "Sa"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Setiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                    "firstDay": 1
                },
                showWeekNumbers: true,
                singleDatePicker: true,
                showISOWeekNumbers: true,
                //startDate: moment(),
                minDate: moment()
                //endDate: fecha_final,

            });
        });
        $(function() {
            $('input[name="fecha2"]').daterangepicker({
                "locale": {
                    "format": "DD-MM-YYYY",
                    "separator": " - ",
                    "applyLabel": "Guardar",
                    "cancelLabel": "Cancelar",
                    "fromLabel": "Desde",
                    "toLabel": "Hasta",
                    "daysOfWeek": [
                        "Do",
                        "Lu",
                        "Ma",
                        "Mi",
                        "Ju",
                        "Vi",
                        "Sa"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Setiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                    "firstDay": 1
                },
                showWeekNumbers: true,
                singleDatePicker: true,
                showISOWeekNumbers: true,
                //startDate: moment(),
                minDate: moment()
                //endDate: fecha_final,

            });
        });
    </script>
</body>

</html>