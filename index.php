<?php

// $connect = new PDO("mysql:host=localhost;dbname=idrapex1_time", "idrapex1_time", "1a2b3c++2022");

// $query = "SELECT * FROM timeline ORDER BY id ASC";
// $statement = $connect->prepare($query);
// $statement->execute();
// $result = $statement->fetchAll();
$webconfig = include("webconfig.php");
require_once($webconfig['path_ws']);


$fs_usuario = callFunction((object)['class' => 'TimeController', 'method' => 'lst_usuario']);

?>

<html>

<head>
    <title>Linea de Tiempo AMLEON</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/timeline.min.css" />

    <head>
        <meta charset="euc-jp">
        <!-- Required meta tags -->

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-12aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="css.css" />
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"> -->

        <!-- <link rel="icon" href="assets/app/img/logo.ico" type="image/png" /> -->
        <title>Generador de Certificados</title>
        <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="select/bootstrap-select.min.css">
        <link rel="stylesheet" href="daterangepicker/daterangepicker.css">
        <link rel="stylesheet" href="tagsinput/bootstrap-tagsinput.css" crossorigin="anonymous">
        <link rel="stylesheet" href="multiselect/multi-select.css" />
        <script type="text/javascript" src="jquery/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="bootstrap/bootstrap.min.js"></script>

        <script type="text/javascript" src="select/bootstrap-select.min.js"></script>
        <script type="text/javascript" src="moment/moment.min.js"></script>
        <script type="text/javascript" src="daterangepicker/daterangepicker.min.js"></script>
        <script type="text/javascript" src="tagsinput/bootstrap-tagsinput.min.js"></script>
        <script type="text/javascript" src="select/defaults-es_ES.min.js"></script>
        <script type="text/javascript" src="multiselect/jquery.multi-select.js"></script>
        <script type="text/javascript" src="validator/validator.js"></script>

    </head>
    <style>
        div {
            border: 0px red solid;
        }

        .nav>li>a {
            position: relative;
            display: block;
            padding: 10px 15px;
            color: #fff;
        }

        .nav>li>a:focus,
        .nav>li>a:hover {
            text-decoration: none;
            background-color: #337ab7;
        }

        .panel-primary>.panel-heading {
            color: #fff;
            background-color: #182f4d;
            border-color: #337ab7;
        }
    </style>

<body>
    <div class="container">
        <div class="row">
            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Navegación</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#" style="padding-top: 0px;">
                            <img src="images/logo.png" width="45px" height="50px" alt="">
                        </a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">

                            <li class="<?php echo $what_you_want == '/siae/users/incidentes/index.php' ? 'active' : ''; ?>">
                                <a href="index.php">Emision de Lineas de tiempo</a>
                            </li>


                            <li class="<?php echo $what_you_want == '/siae/users/incidentes/mapa.php' ? 'active' : ''; ?>">
                                <a href="mantenimiento.php">Mantenimiento</a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                    <!-- <?php echo $_SESSION['user']; ?> -->
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="disabled"><a href="#">Mis datos</a></li>
                                    <li class="disabled"><a href="#">Cambiar contraseña</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a name="cerrarsesion" href="./users/ingreso/index.php">Cerrar sesión</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-lg-11">

                <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="panel-heading">Listado Clientes</div>
                    <div class="panel-body">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Buscador </label>
                                            <input class="input form-control input-sm" type="text" name="buscador" id="buscador" placeholder="Nombres o apellidos">
                                        </div>
                                        <div class="form-group">
                                            <label>Nombres y Apellidos </label>
                                            <input class="input form-control input-sm" type="text" name="nombrer" id="nombrer" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>Listado </label>
                                            <select class="form-control input-sm" name="cnombre" id="cnombre" size="6" multiple>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>DNI </label>
                                            <input class="input form-control input-sm" type="text" name="dni" id="dni" placeholder="">
                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>Correo</label>
                                            <input class="input form-control input-sm" type="text" name="correo" id="correo" placeholder="">
                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>Celular </label>
                                            <input class="input form-control input-sm" type="text" name="celular" id="celular" placeholder="">
                                        </div>

                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <!-- <div class="panel panel-default"> -->
                                            <label>Acciones</label>

                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <button type="button" style="background:#155724;color:white;font-size: .7em;" class="input form-control" name="crear" id="crear">Crear</button>
                                                </div>
                                                <div class="col-lg-3">
                                                    <button type="button" style="background:#004085;color:white;font-size: .7em;" class="input form-control" name="actualizar" id="actualizar">Update</button>
                                                </div>
                                                <div class="col-lg-3">
                                                    <button type="button" style="background:#721c24;color:white;font-size: .7em;" class="input form-control" name="eliminar" id="eliminar">Eliminar</button>
                                                </div>
                                                <!-- <div class="col-lg-3">
                                                    <button type="button" style="background:gray;color:white;font-size: .7em;" class="input form-control" name="time" id="time"><strong>Time</strong></button>
                                                </div> -->
                                                <div class="col-lg-3">
                                                    <button type="button" style="background:gray;color:white;font-size: .7em;" class="input form-control" data-toggle="modal" name="time" id="time" data-target="#m_det_time">
                                                        Time
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- </div> -->
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombres y apellidos</th>
                                            <th>Doc. Identidad</th>
                                            <th>Correo</th>
                                            <th>Celular</th>
                                            <th>Fecha Registro</th>
                                            <th>Area</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <? $i = 0;
                                        foreach ($fs_usuario as $key) {
                                            $i++; ?>
                                            <tr data-id=<? echo $key->idpersona?> >
                                                <td><? echo $i; ?></td>
                                                <td><? echo $key->nombres_completos; ?></td>
                                                <td><? echo $key->nro_doc_identidad; ?></td>
                                                <td><? echo $key->correo; ?></td>
                                                <td><? echo $key->celular; ?></td>
                                                <td><? echo $key->fecha_registro; ?></td>
                                                <td><button type="button" style="background:gray;color:white;font-size: .7em;" class="input form-control" data-toggle="modal" name="time" id="time" data-target="#m_det_time">
                                                        Time
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
            </div>
        </div>
        <!-- Button trigger modal -->


        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Asignar un nuevo Timeline</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <!-- <button type="button" class="btn btn-primary"></button> -->
                    </div>
                </div>
            </div>
        </div>
        <div id="m_det_time" class="modal fade" role="dialog">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                </div>
            </div>
        </div>

        <div class="container">
            <br />
            <h3 align="center"><a href="">Time line - AMLEON</a></a></h3><br />
            <h3 align="center"><a href=""></a></a></h3><br />
            <!-- <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Vista General</h3>
            </div>
            <div class="panel-body"> -->
            <div class="timeline">
                <div class="timeline__wrap">
                    <div class="timeline__items">
                        <?php
                        foreach ($result as $row) {
                        ?>
                            <div class="timeline__item">
                                <div class="timeline__content">
                                    <h2><?php echo $row["titulo"]; ?></h2>
                                    <p><?php echo $row["comment"]; ?></p>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- </div>
        </div> -->
        </div>
        <div class="container">
            <br />
            <h3 align="center"><a href="">Time line</a></a></h3><br />
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Vista General</h3>
                        </div>
                        <div class="panel-body">
                            <div class="timeline">
                                <div class="timeline__wrap">
                                    <div class="timeline__items">
                                        <?php
                                        foreach ($result as $row) {
                                        ?>
                                            <div class="timeline__item">
                                                <div class="timeline__content">
                                                    <h2><?php echo $row["titulo"]; ?></h2>
                                                    <p><?php echo $row["comment"]; ?></p>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Vista General</h3>
                        </div>
                        <div class="panel-body">
                            <div class="timeline">
                                <div class="timeline__wrap">
                                    <div class="timeline__items">
                                        <?php
                                        foreach ($result as $row) {
                                        ?>
                                            <div class="timeline__item">
                                                <div class="timeline__content">
                                                    <h2><?php echo $row["titulo"]; ?></h2>
                                                    <p><?php echo $row["comment"]; ?></p>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
</body>
<script src="js/jquery.js"></script>
<script src="js/timeline.min.js"></script>
<script src="js/app.js"></script>

</html>

<script>
    $(document).ready(function() {
        /*timeline(document.querySelectorAll('.timeline'), {
        mode: 'horizontal',
	    visibleItems: 4,
	    forceVerticalWidth: 800
    });*/
        //jQuery('.timeline').timeline();
        jQuery('.timeline').timeline({
            mode: 'horizontal',
            visibleItems: 4,
            forceVerticalWidth: 0
        });
    });
</script>