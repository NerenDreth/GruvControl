-- ============================================
-- GRUV CONTROL - SISTEMA DE GESTIÓN DE MANTENIMIENTO
-- Script de instalación de base de datos
-- ============================================
-- Fecha: Junio 2026
-- Versión: 1.0
-- ============================================

-- 1. CREAR BASE DE DATOS (si no existe)
-- ============================================
CREATE DATABASE IF NOT EXISTS mantenimiento;
USE mantenimiento;

-- 2. TABLA: usuarios
-- ============================================
CREATE TABLE IF NOT EXISTS usuarios (
    id INT NOT NULL AUTO_INCREMENT,
    usuario VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('Administrador','Tecnico') NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY usuario (usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. TABLA: equipos
-- ============================================
CREATE TABLE IF NOT EXISTS equipos (
    id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    estado VARCHAR(50) NOT NULL,
    codigo_inventario VARCHAR(50) NOT NULL,
    ubicacion VARCHAR(100) NOT NULL,
    responsable VARCHAR(100) NOT NULL,
    fecha_mantenimiento DATETIME DEFAULT NULL,
    fecha_proximo_mantenimiento DATE DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. TABLA: historial_mantenimiento
-- ============================================
CREATE TABLE IF NOT EXISTS historial_mantenimiento (
    id INT NOT NULL AUTO_INCREMENT,
    equipo_id INT NOT NULL,
    descripcion TEXT NOT NULL,
    tecnico VARCHAR(100) NOT NULL,
    observaciones TEXT NULL,
    estado VARCHAR(30) NOT NULL DEFAULT 'Operativo',
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (equipo_id) REFERENCES equipos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. TABLA: bitacora
-- ============================================
CREATE TABLE IF NOT EXISTS bitacora (
    id INT NOT NULL AUTO_INCREMENT,
    usuario VARCHAR(100) NOT NULL,
    accion TEXT NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. USUARIOS PREDETERMINADOS
INSERT INTO usuarios (usuario, password, rol) VALUES
('admin', '$2y$12$1DQO737GP9TPWkmZz.YQ2eZ7NG42k6a9NqNlmxpsmjt3hxHL4QUYu', 'Administrador'),
('tecnico', '$2y$12$g6UEkkRXQWUtw0d1sgH5QuCCrBN6RRIDPWM1tY2FpbClO6.iMSglW', 'Tecnico');

-- 7. DATOS DE EJEMPLO (opcional, para pruebas)
-- ============================================
INSERT INTO equipos (nombre, estado, codigo_inventario, ubicacion, responsable, fecha_mantenimiento, fecha_proximo_mantenimiento) VALUES
('Servidor Dell PowerEdge', 'Operativo', 'SRV-001', 'Data Center', 'admin', NOW(), DATE_ADD(NOW(), INTERVAL 90 DAY)),
('Impresora HP LaserJet', 'Operativo', 'IMP-002', 'Recepción', 'admin', NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY)),
('PC Escritorio Lenovo', 'Mantenimiento', 'PC-003', 'Ventas', 'admin', NOW(), DATE_ADD(NOW(), INTERVAL 15 DAY)),
('Laptop MacBook Pro', 'Operativo', 'LAP-004', 'Gerencia', 'admin', NOW(), DATE_ADD(NOW(), INTERVAL 60 DAY)),
('Switch Cisco', 'Dañado', 'SW-005', 'Sala de Servidores', 'admin', '2026-05-01 10:30:00', '2026-06-01');

-- ============================================
-- FIN DEL SCRIPT
-- ============================================
