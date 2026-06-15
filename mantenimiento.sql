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
  `usuario` varchar(100) NOT NULL,
  `accion` text NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bitacora`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `bitacora` WRITE;
/*!40000 ALTER TABLE `bitacora` DISABLE KEYS */;
INSERT INTO `bitacora` VALUES
(1,'admin','creó equipo Lenovo IdeaPad Slim 3','2026-06-14 09:08:03'),
(2,'admin','creó equipo Dell','2026-06-14 09:08:36'),
(3,'admin','creó equipo HP','2026-06-14 09:10:13'),
(4,'admin','creó equipo MacBook','2026-06-14 09:11:10'),
(5,'admin','creó equipo Mac Mini','2026-06-14 09:12:48'),
(6,'admin','creó equipo Tla','2026-06-14 09:13:29'),
(7,'admin','creó equipo arsiten','2026-06-14 09:13:56'),
(8,'admin','creó equipo aietsn','2026-06-14 09:14:21'),
(9,'admin','creó equipo arietsai','2026-06-14 09:14:48'),
(10,'admin','creó equipo hzkd','2026-06-14 09:15:04'),
(11,'admin','creó equipo vker','2026-06-14 09:15:23'),
(12,'admin','registró mantenimiento del equipo 1','2026-06-14 10:59:10');
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
  `responsable` varchar(100) NOT NULL,
  `fecha_mantenimiento` datetime DEFAULT NULL,
  `fecha_proximo_mantenimiento` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipos`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `equipos` WRITE;
/*!40000 ALTER TABLE `equipos` DISABLE KEYS */;
INSERT INTO `equipos` VALUES
(1,'Lenovo IdeaPad Slim 3','Operativo','69','Mi Casa','admin','2026-06-14 10:59:10','2026-12-14'),
(2,'Dell','Mantenimiento','123','De el','admin','2026-06-14 09:08:36','2026-07-04'),
(3,'HP','Dañado','654','Calle','admin','2026-06-14 09:10:13','2026-12-14'),
(4,'MacBook','Operativo','999','My house','admin','2026-06-14 09:11:10','2026-12-06'),
(5,'Mac Mini','Operativo','432','Tururu','admin','2026-06-14 09:12:48','2027-01-02'),
(6,'Tla','Dañado','533','adi','admin','2026-06-14 09:13:29','2026-06-07'),
(7,'arsiten','Mantenimiento','75','ariestag','admin','2026-06-14 09:13:56','2026-07-07'),
(8,'aietsn','Operativo','859','arshvvv','admin','2026-06-14 09:14:21','2026-01-08'),
(9,'arietsai','Dañado','969','vhv','admin','2026-06-14 09:14:48','2026-07-07'),
(10,'hzkd','Operativo','9604','imi','admin','2026-06-14 09:15:04','2026-08-08'),
(11,'vker','Mantenimiento','7503','oteg','admin','2026-06-14 09:15:23','2026-09-09');
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
  `tecnico` varchar(100) NOT NULL,
  `observaciones` text DEFAULT NULL,
  `estado` varchar(30) NOT NULL DEFAULT 'Operativo',
  `fecha` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `equipo_id` (`equipo_id`),
  CONSTRAINT `1` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_mantenimiento`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `historial_mantenimiento` WRITE;
/*!40000 ALTER TABLE `historial_mantenimiento` DISABLE KEYS */;
INSERT INTO `historial_mantenimiento` VALUES
(1,1,'Se le realizo limpieza interna y externa, se le aplico nueva pasta termica','admin','Verificar estado cada 6 meses','Operativo','2026-06-14 10:59:10');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES
(1,'admin','$2y$12$UIC3nKpD/K1kFdCNruxyquPTX7E8LZoX1w94GyBcvjVaBCrZB8VQi','Administrador','2026-06-14 03:08:01'),
(2,'tecnico','tecnico123','Tecnico','2026-06-14 03:08:01');
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

-- Dump completed on 2026-06-14 12:37:00
