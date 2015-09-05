-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 10-05-2015 a las 15:50:41
-- Versión del servidor: 5.5.43-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/* Creación de un usuario para que use Herremex */
GRANT ALL ON `herremex`.* to 'PersonalHerremex'@'localhost' identified by '1234';

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `herremex`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calidad`
--

CREATE TABLE IF NOT EXISTS `calidad` (
  `Abreviatura` varchar(1) NOT NULL,
  `Nombre` varchar(15) NOT NULL,
  PRIMARY KEY (`Abreviatura`),
  KEY `Abreviatura` (`Abreviatura`),
  KEY `Abreviatura_2` (`Abreviatura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `calidad`
--

INSERT INTO `calidad` (`Abreviatura`, `Nombre`) VALUES
('B', 'Buena'),
('E', 'Excelente'),
('M', 'Mala'),
('P', 'Pesima'),
('R', 'Regular');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE IF NOT EXISTS `ciudad` (
  `Abreviatura` varchar(3) NOT NULL,
  `Nombre` varchar(20) NOT NULL,
  PRIMARY KEY (`Abreviatura`),
  KEY `Abreviatura` (`Abreviatura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`Abreviatura`, `Nombre`) VALUES
('GDL', 'Guadalajara'),
('TLP', 'Tlaquepaque'),
('TON', 'Tonala'),
('ZAP', 'Zapopan');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `RFC` varchar(13) NOT NULL UNIQUE,
  `Nombre` varchar(100) NOT NULL,
  `Sexo` enum('M','F') DEFAULT NULL,
  `Regimen` enum('Moral','Fisica') NOT NULL,
  `Calle` varchar(30) NOT NULL,
  `NoEdificio` int(11) NOT NULL,
  `Ciudad` varchar(3) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`),
  KEY `Ciudad` (`Ciudad`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraVenta`
--

CREATE TABLE IF NOT EXISTS `compraVenta` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Cliente` int(11) NOT NULL,
  `ID_Sucursal` int(11) NOT NULL,
  `ID_Herramienta_Comprada` int(11) NOT NULL,
  `EnvioDocimilio` enum('S','N') NOT NULL,
  `Facturar` enum('S','N') NOT NULL,
  `Fecha` date NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_Cliente` (`ID_Cliente`,`ID_Sucursal`,`ID_Herramienta_Comprada`),
  KEY `ID_Sucursal` (`ID_Sucursal`),
  KEY `ID_Herramienta_Comprada` (`ID_Herramienta_Comprada`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distribuidores`
--

CREATE TABLE IF NOT EXISTS `distribuidores` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Direccion` varchar(100) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE IF NOT EXISTS `empleados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CURP` varchar(18) NOT NULL UNIQUE,
  `Nombre` varchar(50) NOT NULL,
  `Segundo_Nombre` varchar(50) NOT NULL,
  `Apellido_Paterno` varchar(15) NOT NULL,
  `Apellido_Materno` varchar(15) NOT NULL,
  `Turno` varchar(1) NOT NULL,
  `Tipo_Empleado` varchar(1) NOT NULL,
  `Calle` varchar(30) NOT NULL,
  `Colonia` varchar(30) NOT NULL,
  `NoCasa_Ext` int(11) NOT NULL,
  `NoCasa_Int` int(11) DEFAULT '0',
  `Ciudad` varchar(3) NOT NULL,
  `Password` varchar(40) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`),
  KEY `Tipo_Empleado` (`Tipo_Empleado`),
  KEY `Turno` (`Turno`),
  KEY `Ciudad` (`Ciudad`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `empleados` VALUES
(1, '123456789012345678', 'John', '', 'Due', ' ', 'M', 'J', '123', '123', 123, 123, 'GDL', SHA1('123'));

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramientas`
--

CREATE TABLE IF NOT EXISTS `herramientas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Tipo` int(11) NOT NULL,
  `Precio` float NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`),
  KEY `ID_Tipo` (`ID_Tipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramientascompradas`
--

CREATE TABLE IF NOT EXISTS `herramientascompradas` (
  `Identificador` int(11) NOT NULL,
  `ID_Herramienta` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  PRIMARY KEY (`Identificador`,`ID_Herramienta`),
  KEY `Identificador` (`Identificador`),
  KEY `ID_Herramienta` (`ID_Herramienta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE IF NOT EXISTS `marca` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Abreviatura` varchar(5) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_distribuidor_herramienta`
--

CREATE TABLE IF NOT EXISTS `rel_distribuidor_herramienta` (
  `ID_Distribuidor` int(11) NOT NULL,
  `ID_Herramienta` int(11) NOT NULL,
  `PrecioCompra` float NOT NULL,
  `Calidad` varchar(1) NOT NULL,
  PRIMARY KEY (`ID_Distribuidor`,`ID_Herramienta`),
  KEY `ID_Herramienta` (`ID_Herramienta`),
  KEY `Calidad` (`Calidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_empleado_sucursal`
--

CREATE TABLE IF NOT EXISTS `rel_empleado_sucursal` (
  `ID_Empleado` int(11) NOT NULL,
  `ID_Sucursal` int(11) NOT NULL,
  PRIMARY KEY (`ID_Empleado`,`ID_Sucursal`),
  KEY `ID_Empleado` (`ID_Empleado`,`ID_Sucursal`),
  KEY `ID_Sucursal` (`ID_Sucursal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_herramienta_marca`
--

CREATE TABLE IF NOT EXISTS `rel_herramienta_marca` (
  `ID_Herramienta` int(11) NOT NULL,
  `ID_Marca` int(11) NOT NULL,
  `CantidadExistente` int(11) NOT NULL,
  PRIMARY KEY (`ID_Herramienta`,`ID_Marca`),
  KEY `ID_Herramienta` (`ID_Herramienta`),
  KEY `ID_Marca` (`ID_Marca`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal`
--

CREATE TABLE IF NOT EXISTS `sucursal` (
  `Ciudad` varchar(3) NOT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Calle` varchar(30) NOT NULL,
  `Colonia` varchar(30) NOT NULL,
  `NoEdificio` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`),
  KEY `Ciudad` (`Ciudad`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoempleado`
--

CREATE TABLE IF NOT EXISTS `tipoempleado` (
  `Abreviatura` varchar(1) NOT NULL,
  `Nombre` varchar(10) NOT NULL,
  `Comision` int(11) NOT NULL,
  PRIMARY KEY (`Abreviatura`),
  KEY `Abreviatura` (`Abreviatura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipoempleado`
--

INSERT INTO `tipoempleado` (`Abreviatura`, `Nombre`, `Comision`) VALUES
('A', 'Anonimo', 5),
('C', 'Caja', 5),
('G', 'Gerente', 10),
('J', 'Jefe', 0),
('V', 'Ventas', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoherramienta`
--

CREATE TABLE IF NOT EXISTS `tipoherramienta` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(30) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `tipoherramienta`
--

INSERT INTO `tipoherramienta` (`ID`, `Nombre`) VALUES
(1, 'Martillo'),
(2, 'Tornillo'),
(3, 'Taladro'),
(4, 'Lija'),
(5, 'Desarmador'),
(6, 'Clavo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turno`
--

CREATE TABLE IF NOT EXISTS `turno` (
  `Abreviatura` varchar(1) NOT NULL,
  `Nombre` varchar(15) NOT NULL,
  `Horas` int(11) NOT NULL,
  `Inicio` int(11) NOT NULL,
  PRIMARY KEY (`Abreviatura`),
  KEY `Abreviatura` (`Abreviatura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `turno`
--

INSERT INTO `turno` (`Abreviatura`, `Nombre`, `Horas`, `Inicio`) VALUES
('M', 'Matutino', 8, 7),
('N', 'Nocturno', 8, 22),
('V', 'Vespertino', 8, 15);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`Ciudad`) REFERENCES `ciudad` (`Abreviatura`);

--
-- Filtros para la tabla `compraVenta`
--
ALTER TABLE `compraVenta`
  ADD CONSTRAINT `compraVenta_ibfk_1` FOREIGN KEY (`ID_Cliente`) REFERENCES `clientes` (`ID`),
  ADD CONSTRAINT `compraVenta_ibfk_2` FOREIGN KEY (`ID_Sucursal`) REFERENCES `sucursal` (`ID`),
  ADD CONSTRAINT `compraVenta_ibfk_3` FOREIGN KEY (`ID_Herramienta_Comprada`) REFERENCES `herramientascompradas` (`Identificador`);

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`Turno`) REFERENCES `turno` (`Abreviatura`),
  ADD CONSTRAINT `empleados_ibfk_2` FOREIGN KEY (`Tipo_Empleado`) REFERENCES `tipoempleado` (`Abreviatura`),
  ADD CONSTRAINT `empleados_ibfk_3` FOREIGN KEY (`Ciudad`) REFERENCES `ciudad` (`Abreviatura`);

--
-- Filtros para la tabla `herramientas`
--
ALTER TABLE `herramientas`
  ADD CONSTRAINT `herramientas_ibfk_1` FOREIGN KEY (`ID_Tipo`) REFERENCES `tipoherramienta` (`ID`);

--
-- Filtros para la tabla `herramientascompradas`
--
ALTER TABLE `herramientascompradas`
  ADD CONSTRAINT `herramientascompradas_ibfk_1` FOREIGN KEY (`ID_Herramienta`) REFERENCES `herramientas` (`ID`);

--
-- Filtros para la tabla `rel_distribuidor_herramienta`
--
ALTER TABLE `rel_distribuidor_herramienta`
  ADD CONSTRAINT `rel_distribuidor_herramienta_ibfk_1` FOREIGN KEY (`ID_Distribuidor`) REFERENCES `distribuidores` (`ID`),
  ADD CONSTRAINT `rel_distribuidor_herramienta_ibfk_2` FOREIGN KEY (`ID_Herramienta`) REFERENCES `herramientas` (`ID`),
  ADD CONSTRAINT `rel_distribuidor_herramienta_ibfk_3` FOREIGN KEY (`Calidad`) REFERENCES `calidad` (`Abreviatura`);

--
-- Filtros para la tabla `rel_empleado_sucursal`
--
ALTER TABLE `rel_empleado_sucursal`
  ADD CONSTRAINT `rel_empleado_sucursal_ibfk_1` FOREIGN KEY (`ID_Empleado`) REFERENCES `empleados` (`ID`),
  ADD CONSTRAINT `rel_empleado_sucursal_ibfk_2` FOREIGN KEY (`ID_Sucursal`) REFERENCES `sucursal` (`ID`);

--
-- Filtros para la tabla `rel_herramienta_marca`
--
ALTER TABLE `rel_herramienta_marca`
  ADD CONSTRAINT `rel_herramienta_marca_ibfk_1` FOREIGN KEY (`ID_Herramienta`) REFERENCES `herramientas` (`ID`),
  ADD CONSTRAINT `rel_herramienta_marca_ibfk_2` FOREIGN KEY (`ID_Marca`) REFERENCES `marca` (`ID`);

--
-- Filtros para la tabla `sucursal`
--
ALTER TABLE `sucursal`
  ADD CONSTRAINT `sucursal_ibfk_1` FOREIGN KEY (`Ciudad`) REFERENCES `ciudad` (`Abreviatura`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
