-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.36 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.7.0.6850
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para abmventas
CREATE DATABASE IF NOT EXISTS `abmventas` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `abmventas`;

-- Volcando estructura para tabla abmventas.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `idcliente` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `cuit` varchar(11) COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `correo` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `fecha_nac` date DEFAULT NULL,
  `fk_idprovincia` int unsigned DEFAULT NULL,
  `fk_idlocalidad` int unsigned DEFAULT NULL,
  `domicilio` varchar(150) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idcliente`),
  KEY `fk_idprovincia` (`fk_idprovincia`),
  KEY `fk_idlocalidad` (`fk_idlocalidad`),
  CONSTRAINT `FK_clientes_localidades` FOREIGN KEY (`fk_idlocalidad`) REFERENCES `localidades` (`idlocalidad`),
  CONSTRAINT `FK_clientes_provincias` FOREIGN KEY (`fk_idprovincia`) REFERENCES `provincias` (`idprovincia`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla abmventas.clientes: ~3 rows (aproximadamente)
INSERT INTO `clientes` (`idcliente`, `nombre`, `cuit`, `telefono`, `correo`, `fecha_nac`, `fk_idprovincia`, `fk_idlocalidad`, `domicilio`) VALUES
	(1, 'Yeison Garcia', '1193300865', '3104277843', 'yeison.gar074@gmail.com', '2002-09-11', 1, 1, NULL),
	(2, 'Jose Zuluaga', '678565', '678554547', 'josez@gmail.com', '2004-03-22', 1, 1, NULL),
	(4, 'Felipe Agudelo', '676855', '3242114', 'pipe@gmail.com', '2003-08-11', 1, 1, '');

-- Volcando estructura para tabla abmventas.localidades
CREATE TABLE IF NOT EXISTS `localidades` (
  `idlocalidad` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `cod_postal` varchar(10) COLLATE utf8mb4_spanish_ci NOT NULL,
  `fk_idprovincia` int unsigned NOT NULL,
  PRIMARY KEY (`idlocalidad`),
  KEY `fk_idprovincia` (`fk_idprovincia`),
  CONSTRAINT `FK_localidades_provincias` FOREIGN KEY (`fk_idprovincia`) REFERENCES `provincias` (`idprovincia`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla abmventas.localidades: ~4 rows (aproximadamente)
INSERT INTO `localidades` (`idlocalidad`, `nombre`, `cod_postal`, `fk_idprovincia`) VALUES
	(1, 'medellin', '123456', 1),
	(2, 'monteria', '2513451', 2),
	(3, 'bogota', '231231', 3),
	(4, 'villavicencio', '345224', 4);

-- Volcando estructura para tabla abmventas.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `idproducto` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `cantidad` int unsigned NOT NULL DEFAULT '0',
  `precio` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `descripcion` text COLLATE utf8mb4_spanish_ci,
  `imagen` varchar(255) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `fk_idtipoproducto` int unsigned DEFAULT NULL,
  PRIMARY KEY (`idproducto`),
  KEY `fk_idtipoproducto` (`fk_idtipoproducto`),
  CONSTRAINT `FK_productos_tipo_producto` FOREIGN KEY (`fk_idtipoproducto`) REFERENCES `tipo_productos` (`idtipoproducto`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla abmventas.productos: ~6 rows (aproximadamente)
INSERT INTO `productos` (`idproducto`, `nombre`, `cantidad`, `precio`, `descripcion`, `imagen`, `fk_idtipoproducto`) VALUES
	(1, 'Televisor fullHD', 10, 1000000.00, 'SmartTV fullHD', NULL, 3),
	(2, 'Nevera', 5, 3000000.00, NULL, NULL, 1),
	(3, 'Cien anios de soledad', 18, 100000.00, 'Libro de Gabriel Garcia Marquez', '', 2),
	(4, 'Poder sin limites', 15, 60000.00, 'Libro de superacion personal y psicologia', NULL, 2),
	(5, 'Computador', 3, 2000000.00, NULL, NULL, 3),
	(6, 'Celular', 0, 4000000.00, 'Iphone 14 pro max', '', 3);

-- Volcando estructura para tabla abmventas.provincias
CREATE TABLE IF NOT EXISTS `provincias` (
  `idprovincia` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`idprovincia`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla abmventas.provincias: ~4 rows (aproximadamente)
INSERT INTO `provincias` (`idprovincia`, `nombre`) VALUES
	(1, 'antioquia'),
	(2, 'cordoba'),
	(3, 'cundinamarca'),
	(4, 'meta');

-- Volcando estructura para tabla abmventas.tipo_productos
CREATE TABLE IF NOT EXISTS `tipo_productos` (
  `idtipoproducto` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`idtipoproducto`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla abmventas.tipo_productos: ~2 rows (aproximadamente)
INSERT INTO `tipo_productos` (`idtipoproducto`, `nombre`) VALUES
	(1, 'Electrodomestico'),
	(2, 'Libreria'),
	(3, 'Informatica');

-- Volcando estructura para tabla abmventas.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `idusuario` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `clave` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `correo` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `usuario` (`usuario`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla abmventas.usuarios: ~2 rows (aproximadamente)
INSERT INTO `usuarios` (`idusuario`, `usuario`, `clave`, `nombre`, `apellido`, `correo`) VALUES
	(5, 'admin', '$2y$10$IAWknUwtjuzIERsA234jvuDDt7Jl./dlUhap3c4l47m6oVPJHxyga', 'Yeison', 'Garcia', 'yeison.gar074@gmail.com'),
	(6, 'yeison', '$2y$10$WAhDs2SgiQ0BC91rvncPqelsPX3l/nyODJSO2JTm7ni1VjkzMZtnG', 'David', 'Arismendy', 'davisg@gmail.com');

-- Volcando estructura para tabla abmventas.ventas
CREATE TABLE IF NOT EXISTS `ventas` (
  `idventa` int unsigned NOT NULL AUTO_INCREMENT,
  `fk_idcliente` int unsigned NOT NULL,
  `fk_idproducto` int unsigned NOT NULL,
  `fecha` datetime NOT NULL,
  `cantidad` int NOT NULL,
  `preciounitario` decimal(10,0) NOT NULL,
  `total` decimal(10,0) NOT NULL,
  PRIMARY KEY (`idventa`),
  KEY `fk_idcliente` (`fk_idcliente`),
  KEY `fk_idproducto` (`fk_idproducto`),
  CONSTRAINT `FK_ventas_clientes` FOREIGN KEY (`fk_idcliente`) REFERENCES `clientes` (`idcliente`),
  CONSTRAINT `FK_ventas_productos` FOREIGN KEY (`fk_idproducto`) REFERENCES `productos` (`idproducto`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla abmventas.ventas: ~2 rows (aproximadamente)
INSERT INTO `ventas` (`idventa`, `fk_idcliente`, `fk_idproducto`, `fecha`, `cantidad`, `preciounitario`, `total`) VALUES
	(2, 1, 1, '2024-04-23 13:29:00', 1, 1000000, 1000000),
	(3, 2, 6, '2024-04-23 11:37:00', 2, 4000000, 8000000);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
