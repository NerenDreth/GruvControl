<?php

session_start();

require_once 'vendor/autoload.php';
require_once 'config/db.php';

require_once 'controllers/EquipoController.php';
require_once 'models/Usuario.php';

$controller = new EquipoController($pdo);

$usuarioModel = new Usuario($pdo);

$view = $_GET['view'] ?? 'listar';
$id = $_GET['id'] ?? null;


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

if ($view == 'login') {

    require_once 'views/login.php';
    exit;
}

if ($view == 'validarLogin') {

    $usuario = $usuarioModel->login(
        $_POST['usuario'],
        $_POST['password']
    );

    if ($usuario) {

        $_SESSION['usuario'] = $usuario['usuario'];
        $_SESSION['rol'] = $usuario['rol'];

        header('Location: index.php');
        exit;
    }

    header('Location: index.php?view=login&error=1');
    exit;
}

if ($view == 'logout') {

    session_destroy();

    header('Location: index.php?view=login');
    exit;
}


/*
|--------------------------------------------------------------------------
| PROTEGER SISTEMA
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['usuario'])) {

    header('Location: index.php?view=login');
    exit;
}


/*
|--------------------------------------------------------------------------
| RUTAS
|--------------------------------------------------------------------------
*/

switch ($view) {

    case 'guardar':
        $controller->guardar();
        break;

    case 'editar':

        if ($_SESSION['rol'] != 'Administrador') {
            die('Acceso denegado');
        }

        $controller->editar($id);
        break;

    case 'actualizar':

        if ($_SESSION['rol'] != 'Administrador') {
            die('Acceso denegado');
        }

        $controller->actualizar();
        break;

    case 'eliminar':

        if ($_SESSION['rol'] != 'Administrador') {
            die('Acceso denegado');
        }

        $controller->eliminar($id);
        break;

    case 'historial':
        $controller->historial($id);
        break;

    case 'guardarMantenimiento':
        $controller->guardarMantenimiento();
        break;

        case 'bitacora':

    if ($_SESSION['rol'] != 'Administrador') {
        die('Acceso denegado');
    }

    $controller->bitacora();
    break;
    
    case 'excel':
        $controller->exportarExcel();
        break;

    case 'agregar':

    if (
        $_SESSION['rol'] != 'Administrador' &&
        $_SESSION['rol'] != 'Tecnico'
    ) {
        die('Acceso denegado');
    }

    require_once 'views/agregar_equipo.php';
    break;

case 'usuarios':

    if ($_SESSION['rol'] != 'Administrador') {
        die('Acceso denegado');
    }

    $usuarios = $usuarioModel->obtenerTodos();

    require_once 'views/lista_usuarios.php';
    break;
    case 'nuevoUsuario':

        if ($_SESSION['rol'] != 'Administrador') {
            die('Acceso denegado');
        }

        require_once 'views/agregar_usuario.php';
        break;

    case 'guardarUsuario':

        if ($_SESSION['rol'] != 'Administrador') {
            die('Acceso denegado');
        }

        $usuarioModel->guardar(
            $_POST['usuario'],
            $_POST['password'],
            $_POST['rol']
        );

        header('Location: index.php?view=usuarios');
        exit;

    case 'editarUsuario':

        if ($_SESSION['rol'] != 'Administrador') {
            die('Acceso denegado');
        }

        $usuario = $usuarioModel->obtenerPorId($id);

        require_once 'views/editar_usuario.php';
        break;

    case 'actualizarUsuario':

        if ($_SESSION['rol'] != 'Administrador') {
            die('Acceso denegado');
        }

        $usuarioModel->actualizar(
            $_POST['id'],
            $_POST['usuario'],
            $_POST['password'],
            $_POST['rol']
        );

        header('Location: index.php?view=usuarios');
        exit;

    case 'eliminarUsuario':

        if ($_SESSION['rol'] != 'Administrador') {
            die('Acceso denegado');
        }

        $usuarioModel->eliminar($id);

        header('Location: index.php?view=usuarios');
        exit;
    case 'listar':
    default:
        $controller->index();
        break;
}   