<?php

class Usuario {

    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function login($usuario, $password) {

        $stmt = $this->db->prepare(
            "SELECT *
             FROM usuarios
             WHERE usuario = ?"
        );

        $stmt->execute([$usuario]);

        $usuarioDB = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$usuarioDB){
            return false;
        }

        // Verificar contraseña hasheada con bcrypt
        if(!password_verify($password, $usuarioDB['password'])){
            return false;
        }

        return $usuarioDB;
    }

    public function obtenerTodos() {

        $stmt = $this->db->query(
            "SELECT *
             FROM usuarios
             ORDER BY id DESC"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {

        $stmt = $this->db->prepare(
            "SELECT *
             FROM usuarios
             WHERE id = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function guardar(
        $usuario,
        $password,
        $rol
    ) {

        // Encriptar contraseña con bcrypt
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare(
            "INSERT INTO usuarios
            (
                usuario,
                password,
                rol
            )
            VALUES (?, ?, ?)"
        );

        return $stmt->execute([
            $usuario,
            $hashedPassword,
            $rol
        ]);
    }

    public function actualizar(
        $id,
        $usuario,
        $password,
        $rol
    ) {

        // Encriptar contraseña con bcrypt
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare(
            "UPDATE usuarios
             SET
                usuario = ?,
                password = ?,
                rol = ?
             WHERE id = ?"
        );

        return $stmt->execute([
            $usuario,
            $hashedPassword,
            $rol,
            $id
        ]);
    }

    public function eliminar($id) {

        $stmt = $this->db->prepare(
            "DELETE FROM usuarios
             WHERE id = ?"
        );

        return $stmt->execute([$id]);
    }
}
