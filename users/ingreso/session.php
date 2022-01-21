<?php
session_start();
require '../../php/MySql.php';
require '../../php/class/UsuarioController.php';
if (count($_GET) > 0) {
    if (isset($_GET['cerrare'])) {
        session_destroy();
        // echo "hoooo";
        // header('Location:index.php');
    }
}

$action = $_POST['action'];

switch ($action) {
    case "cerrarr":
        session_destroy();
        // echo "hoooo";
        header("Location: index.php");
        header("Refresh:1");
        die();
        
         break;
    case "login":
        $vq = new UsuarioController();

        $fs_usuario = $vq->login($_POST['user'], $_POST['pass']);

        // var_dump($fs_usuario);

        if (count($fs_usuario) > 0) {
            $fs_usuario = $fs_usuario{
            0};

            echo json_encode(array('data' => $fs_usuario->usuario));
            
            $_SESSION['user_id'] = $fs_usuario->usuario_id;
            $_SESSION['admin'] = $fs_usuario->esadmin;
        }

        // if ($_POST['usr'] == 'kleon' && $_POST['pwd'] == '1a2b3c++') {
        //     echo json_encode(array('data' => 'Karen Leon'));
        //     $_SESSION['user_id'] = 'Karen Leon';
        // }

        // if ($_POST['usr'] == 'gcoletti' && $_POST['pwd'] == '1a2b3c++') {
        //     echo json_encode(array('data' => 'Giovani Coletti'));
        //     $_SESSION['user_id'] = 'Giovani Coletti';
        // }

        // if ($_POST['usr'] == 'greyes' && $_POST['pwd'] == '1q2w3e') {
        //     echo json_encode(array('data' => 'Gustavo Reyes'));
        //     $_SESSION['user_id'] = 'Gustavo Reyes';
        // }

        // if ($_POST['usr'] == 'mpariona' && $_POST['pwd'] == '1a2b3c++') {
        //     echo json_encode(array('data' => 'Melanie Pariona'));
        //     $_SESSION['user_id'] = 'Melanie Pariona';
        // }
        // if ($_POST['usr'] == 'ssalazar' && $_POST['pwd'] == '1a2b3c++') {
        //     echo json_encode(array('data' => 'Samantha Salazar'));
        //     $_SESSION['user_id'] = 'Samantha Salazar';
        // }
        // if ($_POST['usr'] == 'jvera' && $_POST['pwd'] == '1a2b3c++') {
        //     echo json_encode(array('data' => 'Jesus Vera'));
        //     $_SESSION['user_id'] = 'Jesus Vera';
        // }
        break;
}
