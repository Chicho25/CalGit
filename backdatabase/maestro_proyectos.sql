-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-03-2019 a las 05:28:40
-- Versión del servidor: 10.1.28-MariaDB
-- Versión de PHP: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `admin_1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maestro_proyectos`
--

CREATE TABLE `maestro_proyectos` (
  `id_proyecto` int(11) NOT NULL,
  `proy_nombre_proyecto` varchar(80) NOT NULL,
  `proy_tipo_proyecto` varchar(15) NOT NULL,
  `proy_promotor` varchar(80) NOT NULL,
  `proy_area` decimal(6,2) NOT NULL,
  `proy_estado` tinyint(1) NOT NULL,
  `proy_resolucion_ambiental` varchar(80) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `proy_monto_inicial` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `maestro_proyectos`
--

INSERT INTO `maestro_proyectos` (`id_proyecto`, `proy_nombre_proyecto`, `proy_tipo_proyecto`, `proy_promotor`, `proy_area`, `proy_estado`, `proy_resolucion_ambiental`, `id_empresa`, `proy_monto_inicial`) VALUES
(8, 'CALPE PROPERTIES', 'ADMINISTRACION ', 'CALPE PROPERTIES', '0.00', 1, '00000', 41, '1000000.00'),
(11, 'MARINA GOLF', 'ADMINISTRACION', 'CALPE PROPERTIES', '0.00', 1, '00000', 44, '53.00'),
(13, 'VISTA MAR MARINA ', 'ADMINISTRATIVO', 'VISTA MAR MARINA, S.A.', '0.00', 1, '0000', 45, '1000000.00'),
(14, 'ALTAMIRA GARDENS', 'RESIDENCIAL', 'PANAMA-DESARROLLO LA COLINA, S.A.', '0.00', 1, '00000', 46, '77580646.60'),
(17, 'VISTA MAR MARINA PROMOTORA', 'NAUTICO', 'MARINA VISTA MAR GROUP, S.A.', '9999.99', 1, 'RESOLUCIÃ“N J.D. NO. 022-201 3', 49, '23865814.00'),
(22, 'PH PARQUE CENTENARIO GLOBO 1', 'PH', 'DESARROLLOS PARQUE CENTENARIO, S.A.', '9999.99', 1, '123456', 50, '83000.00'),
(23, 'PH PARQUE CENTENARIO GLOBO 2', 'PH', 'DESARROLLOS PARQUE CENTENARIO, S.A.', '9999.99', 1, '123456', 51, '62000.00'),
(24, 'PH PARQUE INDUSTRIAL CANAIMA', 'PH', 'CALPE PROPERTI', '0.00', 1, 'XXXXX', 52, '76000.00'),
(27, 'P.H. CENTRO PLAZA', 'P.H.', 'CALPE PROPERTIES', '0.00', 1, '0.00', 54, '80000.00'),
(28, 'P.H. MARINA GOLF ', 'P.H.', 'CALPE PROPERTIES', '0.00', 1, '0.00', 53, '80000.00'),
(29, 'P.H. PLAZA COMERCIAL CANAIMA', 'P.H.', 'CALPE POPERTIES', '0.00', 1, '0.00', 56, '100000.00'),
(30, 'PH ALTAMIRA GARDENS', 'PH', 'PANAMA DESARROLLO LA COLINA', '9999.99', 0, '0', 57, '767.00'),
(31, 'PH CRYSTAL PLAZA MALL', 'P.H.', 'DESARROLLOS PLAZA MAYOR', '9999.99', 1, '0.00', 55, '488000.00'),
(32, 'GRUPO CALPE INC', 'ADMINISTRADORA', 'GRUPO CALPE INC.', '151.00', 1, '0000', 58, '410000.00'),
(33, 'THE PROJECT TEST ', 'A DRY RUN', 'TESTFUL', '0.00', 1, '123', 59, '1.00'),
(34, 'INVERSIONES 1969', 'PLAZA COMERCIAL', 'INVERSIONES 1969', '0.00', 0, 'D', 58, '7.00'),
(35, 'GALERIAS PANAMERICANA', 'COMERCIAL', 'INVERSIONES 1969', '9999.99', 1, '123', 39, '7500000.00'),
(36, 'VISTA MAR MARINA 2019', 'ADMINISTRATIVO', 'VISTA MAR MARINA, S.A.', '9999.99', 1, '222222', 45, '772490.00'),
(37, 'PH GALERIAS PANAMERICANA', 'PH', 'PH GALERIAS PANAMERICANA', '9999.99', 1, 'REEEE', 60, '150000.00'),
(38, 'PH CENTRO PLAZA', 'LOCALES COMERCI', 'CENTRO PLAZA', '1905.70', 1, '190570 PLAZA', 61, '180000.00'),
(39, 'CALPE PROPERTIES 2019', 'ADMINISTRACION ', 'CALPE PROPERTIES, S.A.', '9999.99', 1, '56678', 41, '500000.00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `maestro_proyectos`
--
ALTER TABLE `maestro_proyectos`
  ADD PRIMARY KEY (`id_proyecto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `maestro_proyectos`
--
ALTER TABLE `maestro_proyectos`
  MODIFY `id_proyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
