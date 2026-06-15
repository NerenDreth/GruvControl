<?php
$host = 'localhost';
$db   = 'mantenimiento'; // Debe llamarse igual a la que creaste en SQLyog
$user = 'root';
$pass = ''; // Si tienes contraseña en tu MySQL de XAMPP, ponla aquí

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}