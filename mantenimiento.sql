/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-12.3.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: mantenimiento
-- ------------------------------------------------------
-- Server version	12.3.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `bitacora`
--

DROP TABLE IF EXISTS `bitacora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `bitacora` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `accion` text NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bitacora`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `bitacora` WRITE;
/*!40000 ALTER TABLE `bitacora` DISABLE KEYS */;
INSERT INTO `bitacora` VALUES
(1,3,'creó equipo Lenovo Ideapad Slim 3','2026-06-15 23:05:58'),
(2,3,'registró mantenimiento del equipo 6','2026-06-15 23:07:00'),
(3,4,'registró mantenimiento del equipo 4','2026-06-15 23:18:42'),
(4,3,'creó equipo Debian-SRV','2026-06-16 07:46:31'),
(5,3,'creó equipo MacBook Neo','2026-06-16 07:47:41'),
(6,3,'registró mantenimiento del equipo 3','2026-06-16 07:49:08'),
(7,4,'registró mantenimiento del equipo 2','2026-06-16 07:50:46'),
(8,4,'registró mantenimiento del equipo 1','2026-06-16 07:53:25'),
(9,4,'registró mantenimiento del equipo 1','2026-06-16 07:55:43'),
(10,4,'creó equipo HP-Lptp','2026-06-16 07:57:17'),
(11,4,'creó equipo Lenovo Thinkpad','2026-06-16 08:01:00'),
(12,4,'registró mantenimiento del equipo 8','2026-06-16 08:04:56'),
(13,4,'registró mantenimiento del equipo 3','2026-06-16 08:06:37'),
(14,3,'registró mantenimiento del equipo 8','2026-06-16 08:12:03'),
(15,3,'creó equipo DELL-D11','2026-06-16 08:14:16');
/*!40000 ALTER TABLE `bitacora` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `equipos`
--

DROP TABLE IF EXISTS `equipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `codigo_inventario` varchar(50) NOT NULL,
  `ubicacion` varchar(100) NOT NULL,
  `responsable_id` int(11) DEFAULT NULL,
  `fecha_mantenimiento` datetime DEFAULT NULL,
  `fecha_proximo_mantenimiento` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `responsable_id` (`responsable_id`),
  CONSTRAINT `1` FOREIGN KEY (`responsable_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipos`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `equipos` WRITE;
/*!40000 ALTER TABLE `equipos` DISABLE KEYS */;
INSERT INTO `equipos` VALUES
(1,'Servidor Dell PowerEdge','Operativo','SRV-001','Data Center',3,'2026-06-16 07:55:43','2026-12-07'),
(2,'Impresora HP LaserJet','Operativo','IMP-002','Recepción',3,'2026-06-16 07:50:46','2026-08-08'),
(3,'PC Escritorio Lenovo','Mantenimiento','PC-003','Ventas',3,'2026-06-16 08:06:37','2026-02-01'),
(4,'Laptop MacBook Pro','Operativo','LAP-004','Gerencia',3,'2026-06-15 23:18:42','2026-08-08'),
(5,'Switch Cisco','Dañado','SW-005','Sala de Servidores',3,'2026-05-01 10:30:00','2026-06-01'),
(6,'Lenovo Ideapad Slim 3','Operativo','LNX-69','Servidores',3,'2026-06-15 23:07:00','2027-01-01'),
(7,'Debian-SRV','Operativo','DEB-SRV','Servidores',3,'2026-06-16 07:46:31','2026-09-09'),
(8,'MacBook Neo','Mantenimiento','MBN-001','Ventas',3,'2026-06-16 08:12:03','2026-12-07'),
(9,'HP-Lptp','Dañado','002','Contaduria',4,'2026-06-16 07:57:17','2026-12-07'),
(10,'Lenovo Thinkpad','Mantenimiento','003','Recuros Humanos',4,'2026-06-16 08:01:00','2026-12-08'),
(11,'DELL-D11','Dañado','004','Ventas',3,'2026-06-16 08:14:16','2026-12-07');
/*!40000 ALTER TABLE `equipos` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `historial_mantenimiento`
--

DROP TABLE IF EXISTS `historial_mantenimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `historial_mantenimiento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equipo_id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `estado` varchar(30) NOT NULL DEFAULT 'Operativo',
  `fecha` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `equipo_id` (`equipo_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `1` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_mantenimiento`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `historial_mantenimiento` WRITE;
/*!40000 ALTER TABLE `historial_mantenimiento` DISABLE KEYS */;
INSERT INTO `historial_mantenimiento` VALUES
(1,6,'Se realizo actualizacion de paquetes de linux',3,'realizar periodicamente limpieza externa','Operativo','2026-06-15 23:07:00'),
(2,4,'Se realizo instalacion de nueva version de Macos',4,'','Operativo','2026-06-15 23:18:42'),
(3,3,'Se realizo mantenimiento preventivo en software',3,'Verificar redimiento en pruebas futuras','Mantenimiento','2026-06-16 07:49:08'),
(4,2,'Se estara realizando pruebas y mantenimiento correctivo en sus componentes',4,'','Mantenimiento','2026-06-16 07:50:46'),
(5,1,'Se realizo diagnostico de operacion y se determino mover a estado de mantenimiento hasta una proxima fecha',4,'','Mantenimiento','2026-06-16 07:53:25'),
(6,1,'Se diagnostico completa falla',4,'Reemplazar componentes','Mantenimiento','2026-06-16 07:55:43'),
(7,8,'Se realizo limpieza de pantalla',4,'','Mantenimiento','2026-06-16 08:04:56'),
(8,3,'Instalacion de drivers',4,'','Operativo','2026-06-16 08:06:37'),
(9,8,' Se realizo diagnostico y se determino realizar limpieza de teclado',3,'','Mantenimiento','2026-06-16 08:12:03');
/*!40000 ALTER TABLE `historial_mantenimiento` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('Administrador','Tecnico') NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES
(3,'admin','$2y$12$OrsqkPPlhtQPdCnhLpFNu.zCw4ek0KlIhdtJziTW7WtgdRAliGx/i','Administrador','2026-06-16 04:52:27'),
(4,'tecnico','$2y$12$VABbhnogYvqsAXXDf6bhFewyVhsjc4/SMDWdyUV.2FlwZtoaFF7g.','Tecnico','2026-06-16 04:52:27');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-06-16  8:28:43
