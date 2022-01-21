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
    <title>IDRA Capacitaciones - INGRESOS
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

    <!--<link rel="stylesheet" href="../../assets/tagsinput/bootstrap-tagsinput.css" crossorigin="anonymous">-->
    <!--<link rel="stylesheet" href="../../assets/multiselect/multi-select.css" />-->
    <!--<link rel="stylesheet" href="../../assets/app/css/app.css" />-->

    <!---->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="css.css" />-->
    <title>FICHA DE REGISTRO DE INGRESOS - IDRA</title>
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
        div{
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
                <h4 class="titulo"><Strong>FICHA DE REGISTRO DE INGRESOS - IDRA INTERNO</strong></h4>
                <!-- <a name="cerrarsesion" href="../login/cerrar_sesion.php">Cerrar sesión</a> -->
            </div>

        </div>
    </div><br>
    <form id="frmIndex" action="index.php" method="post">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Datos del Vendedor </div>
                        <div id="m_buscador" class="panel-body">
                            <div class="container-login100">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Fecha de registro</label>
                                                    <div class="input-group">
                                                        <input class="input form-control input-sm input-dt" type="text" name="fecha" id="fecha" placeholder="dd/mm/yyyy "><span class="input-group-addon">
                                                            <i class="glyphicon glyphicon-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Vendedor</label>
                                                    <select class="input form-control input-sm" name="vendedor" id="vendedor">
                                                        <option value="0">Seleccione un vendedor</option>
                                                        <option value="1">Karen Leon</option>
                                                        <option value="2">Alberto Maguiña</option>
                                                        <option value="3">Cesar Canales</option>
                                                        <option value="4">Billy Joel</option>
                                                        <option value="5">Jorge Marcelo</option>
                                                        <option value="6">Dr.Gustavo Reyes</option>
                                                    </select>
                                                    <!-- <input class="input form-control input-sm" type="text" name="procedencia" id="procedencia" placeholder=""> -->
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Codigo de vendedor</label>
                                                    <div class="input-group">
                                                        <input class="input form-control input-sm" type="text" value="V-123" name="codigo" id="codigo" placeholder="" readonly><span class="input-group-addon">
                                                            <i class="glyphicon glyphicon-barcode"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">Datos personales del cliente</div>
                        <div id="m_buscador" class="panel-body">
                            <div class="container-login100">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Nombre y apellidos</label>
                                                    <input class="input form-control input-sm" type="text" name="nombre" id="nombre" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>DNI </label>
                                                    <input class="input form-control input-sm" type="number" name="dni" id="dni" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Correo </label>
                                                    <div class="input-group">
                                                        <input class="input form-control input-sm" type="text" name="correo" id="correo" placeholder=""><span class="input-group-addon"> <i class="glyphicon glyphicon-envelope"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="container-login100">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <!-- <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Profesion</label>
                                                    <input class="input form-control input-sm" type="text" name="profesion" id="profesion" placeholder="" readonly>
                                                </div>
                                            </div> -->
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Fecha de pago</label>
                                                    <div class="input-group">
                                                        <input class="input form-control input-sm input-dt" type="text" name="fecha2" id="fecha2" placeholder="dd/mm/yyyy "><span class="input-group-addon">
                                                            <i class="glyphicon glyphicon-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Lugar de trabajo </label>
                                                    <input class="input form-control input-sm" type="text" name="lugar" id="lugar" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Celular</label>
                                                    <input class="input form-control input-sm" type="number" name="celular" id="celular" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container-login100">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Banco que pago</label>
                                                    <!-- <input class="input form-control input-sm" type="text" name="banco" id="banco" placeholder=""> -->
                                                    <select name="banco" id="banco" class="input form-control input-sm">
                                                        <option value="0">Seleccione una opcion</option>
                                                        <option value="1">BCP</option>
                                                        <option value="2">INTERBANCK</option>
                                                        <option value="3">BBVA-CONTINENTAL</option>
                                                        <option value="4">BANCO DE LA NACION</option>

                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>N° de voucher</label>
                                                    <input class="input form-control input-sm" type="text" name="voucher" id="voucher" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Monto</label>
                                                    <input class="input form-control input-sm" type="number" name="monto" id="monto" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container-login100">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Curso o diplomado (Presione ctrl para varios)</label>
                                                    <!-- <input class="input form-control input-sm" type="text" name="curso" id="curso" placeholder=""> -->
                                                    <select class=" form-control input-sm " name="curso[]" id="curso[]" size="15" multiple>
                                                        <optgroup label="Diplomados">
                                                            <option value="0">Seleccione un Diplomado</option>
                                                            <option value="1">Diplomado de Arbitraje en las contrataciones con el ESTADO</option>
                                                            <option value="2">Diplomado de Derecho Administrativo en Materia de Transporte</option>
                                                            <option value="3">Diplomado de Derecho Penal y Teoría del Delito</option>
                                                            <option value="4">Diplomado Gestión Gubernamental</option>
                                                            <option value="5">Diplomado derecho procesal penal en el nuevo código procesal penal</option>
                                                            <option value="6">Diplomado en violencia familiar, de género y delitos sexuales</option>
                                                            <option value="7">Diplomado de Oralidad en el Proceso Civil</option>
                                                            <option value="8">Diplomado especializado Desalojo Inmobiliario</option>
                                                            <option value="9">Diplomado de actualización en Derecho laboral y Procesal Laboral</option>
                                                            <option value="10">Diplomado de Gestión Pública</option>
                                                            <option value="11">Diplomado Derecho Administrativo en el estado de emergencia sanitaria</option>
                                                            <option value="12">Diplomado Asistente en Función Fiscal</option>
                                                            <option value="13">Diplomado de contrataciones</option>
                                                            <option value="14">Diplomado de control Gubernamental</option>

                                                        </optgroup>
                                                        <optgroup label="Cursos y Especializaciones">
                                                            <option value="15">Seminario de actualización en plenos casatorios</option>
                                                            <option value="16">Curso de oralidad en el proceso civil</option>
                                                            <option value="17">CURSO DE DERECHO DE FAMILIA: TENENCIA Y RÉGIMEN VISITA</option>
                                                            <option value="18">Curso Finanzas Para Abogados</option>
                                                            <option value="19">Curso Redacción Jurídica Civil</option>
                                                            <option value="20">Curso De Seguridad y Salud En El Trabajo</option>
                                                            <option value="21">Curso de Derecho Ambiental</option>
                                                            <option value="22">Curso de Registral Inmobiliario</option>
                                                            <option value="23">Curso de arbitraje</option>
                                                            <option value="24">Curso de Contratacion Laboral</option>
                                                            <option value="25">Curso de Contratación Publica</option>
                                                            <option value="26">Curso De Derecho Procesal Penal en el Nuevo Código Procesal Penal</option>
                                                            <option value="27">Curso de Redacción Jurídica penal</option>
                                                            <option value="28">Curso derecho penal parte especial</option>
                                                            <option value="29">Curso Mercado de valores</option>
                                                            <option value="30">Curso ofimática para abogados</option>
                                                            <option value="31">Curso Herramientas de Audiencias Virtuales</option>
                                                            <option value="32">Curso de Géstion Pública</option>
                                                            <option value="33">Curso Derechos Reales</option>
                                                            <option value="34">Curso de Derecho Civil para Sustentación de Grado</option>
                                                        </optgroup>
                                                        <optgroup label="Otros">
                                                            <option value="35">Otros ingresos</option>
                                                        </optgroup>


                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Certificacion CAC</label>
                                                    <!-- <input class="input form-control input-sm" type="text" name="certificado" id="certificado" placeholder=""> -->
                                                    <select class="input form-control input-sm" name="certificado" id="certificado">
                                                        <option value="0">Seleccione una opcion</option>
                                                        <option value="1">SI</option>
                                                        <option value="2">NO</option>
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <div class="col" id="cuanto" hidden>
                                                        <p><b>Certificacion CAC ¿Cuantos?</b></p>
                                                        <div>
                                                            <select class="input form-control input-sm" name="cuantos" id="cuantos">
                                                                <option value="0">Seleccione una opcion</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                            </select>
                                                        </div>
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
                                                    <textarea class="input form-control input-sm" type="text" rows="12" name="observaciones" id="observaciones" placeholder="">asd</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">Adjuntar documentos</div>
                        <div id="m_buscador" class="panel-body">
                            <div class="container">
                                <div class="row">
                                    <!-- <input type="text" id="adjuntopath" hidden name="adjuntopath"> -->
                                    <input type="text" name="txtAdjTmp" class="hide"/>					
                                    <input type="file" name="txtAdjunto[]" accept="application/pdf" multiple />
                                    <div class="col-md-4">
                                        <!-- <input type="file" id="adjunto" name="adjunto" required> -->
                                        <br>
                                        <div id="listo" name="listo"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <br>
        <div>
            <div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- <button type="submit" style="color:white;" class="input form-control bg-primary" id="sig-submitBtn">ENVIAR DATOS</button> -->
                            <input type="submit" name="btnBuscar" class="btn btn-primary btn-sm btn-block" value="Enviar" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
    <!-- <a target="_blank" href="https://calendar.google.com/event?action=TEMPLATE&amp;tmeid=MmwzYWxzaDAzbnQzY2htaDZjY2t0NTM3MmEgZ3VzdGF2b3JleWVzemFwYXRhQG0&amp;tmsrc=gustavoreyeszapata%40gmail.com"><img border="0" src="https://www.google.com/calendar/images/ext/gc_button1_es.gif"></a> -->
    <!--MODAL DETALLE INCIDENTE-->
    <div id="m_det_incidencia" class="modal fade" role="dialog">
        <div class="modal-dialog">
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
    <script type="text/javascript" src="../../assets/app/js/users/incidentes/index.js"></script>
    <!--<script type="text/javascript" src="../../assets/app/js/users/incidentes/edit.js"></script>-->
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