<?php

require_once 'models/Usuario.php';

class UsuarioController {

    private $modelo;

    public function __construct($pdo) {
        $this->modelo = new Usuario($pdo);
    }

    public function index() {

        $usuarios = $this->modelo->obtenerTodos();

        require_once 'views/lista_usuarios.php';
    }

    public function guardar() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->modelo->registrar(
                $_POST['usuario'],
                $_POST['password'],
                $_POST['rol']
            );
        }

        header('Location: index.php?view=usuarios');
        exit;
    }

    public function editar($id) {

        $usuario = $this->modelo->obtenerPorId($id);

        require_once 'views/editar_usuario.php';
    }

    public function actualizar() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->modelo->actualizar(
                $_POST['id'],
                $_POST['usuario'],
                $_POST['password'],
                $_POST['rol']
            );
        }

        header('Location: index.php?view=usuarios');
        exit;
    }

    public function eliminar($id) {

        $this->modelo->eliminar($id);

        header('Location: index.php?view=usuarios');
        exit;
    }
}