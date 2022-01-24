<?php

$connect = new PDO("mysql:host=localhost;dbname=idrapex1_time", "idrapex1_time", "1a2b3c++2022");

$query = "SELECT * FROM timeline ORDER BY id ASC";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
?>

<html>

<head>
    <title>Linea de Tiempo AMLEON</title>
    <script src="js/jquery.js"></script>
    <script src="js/timeline.min.js"></script>
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
                        <a class="navbar-brand" href="#">
                            <img src="images/logo.png" width="100px" alt="">
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
    <div class="container">
        <br />
        <h3 align="center"><a href="">Time line</a></a></h3><br />
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
                                        <h2><?php echo $row["year"]; ?></h2>
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
                                                <h2><?php echo $row["year"]; ?></h2>
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
        </div><div class="row">
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
                                                <h2><?php echo $row["year"]; ?></h2>
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