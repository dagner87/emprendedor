-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-09-2018 a las 15:11:59
-- Versión del servidor: 10.1.32-MariaDB
-- Versión de PHP: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `emprendedor_dvgi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capacitacion`
--

CREATE TABLE `capacitacion` (
  `id_cap` int(11) NOT NULL,
  `titulo_video` text NOT NULL,
  `descripcion` text NOT NULL,
  `imag_portada` text NOT NULL,
  `url_video` text NOT NULL,
  `evaluacion` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `capacitacion`
--

INSERT INTO `capacitacion` (`id_cap`, `titulo_video`, `descripcion`, `imag_portada`, `url_video`, `evaluacion`) VALUES
(1, 'Introduccion', 'muestra todos los tipos de productos que vende dvigi', 'combo2.jpg', 'https://www.youtube.com/watch?v=JRSpWkHU0Pc', '8'),
(2, 'Introduccion', 'muestra todos los tipos de productos que vende dvigi', 'combo2.jpg', 'https://www.youtube.com/watch?v=JRSpWkHU0Pc', '8'),
(3, 'Introduccion', 'muestra todos los tipos de productos que vende dvigi', 'combo2.jpg', 'https://www.youtube.com/watch?v=JRSpWkHU0Pc', '8'),
(4, 'Introduccion', 'muestra todos los tipos de productos que vende dvigi', 'combo2.jpg', 'https://www.youtube.com/watch?v=JRSpWkHU0Pc', '8');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_car` int(11) NOT NULL,
  `id_emp` int(11) NOT NULL,
  `no_orden` varchar(250) NOT NULL,
  `fecha_car` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `precio_car` varchar(250) NOT NULL,
  `cantidad` int(250) NOT NULL,
  `importe` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id_car`, `id_emp`, `no_orden`, `fecha_car`, `id_producto`, `precio_car`, `cantidad`, `importe`) VALUES
(24, 56, '1', 2018, 2, '50', 258, '12900'),
(45, 51, '1', 2018, 4, '3', 45, '135');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cartera_comisiones`
--

CREATE TABLE `cartera_comisiones` (
  `id_cart_com` int(11) NOT NULL,
  `id_emp` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `no_compra` varchar(250) NOT NULL,
  `gasto_cartera` varchar(250) NOT NULL,
  `saldo` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id_compra` int(11) NOT NULL,
  `id_emp` int(11) NOT NULL,
  `no_compra` int(11) NOT NULL,
  `fecha_comp` datetime NOT NULL,
  `total_comp` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id_compra`, `id_emp`, `no_compra`, `fecha_comp`, `total_comp`) VALUES
(9, 56, 1, '2018-04-18 04:10:19', '186337.50'),
(11, 56, 2, '2018-09-18 04:29:49', '365.00'),
(12, 50, 3, '2018-09-18 20:41:39', '0.00'),
(13, 50, 4, '2018-09-18 20:58:05', '9250.00'),
(14, 50, 5, '2018-09-18 21:23:05', '15500.00'),
(15, 50, 6, '2018-09-18 21:23:31', '500000.00'),
(16, 50, 7, '2018-09-18 21:25:27', '12700.00'),
(17, 50, 8, '2018-09-18 22:37:23', '104050.00'),
(18, 50, 9, '2018-09-18 22:45:17', '2500000.00'),
(19, 50, 10, '2018-09-18 22:46:51', '12006.00'),
(20, 50, 11, '2018-09-18 22:47:30', '12006.00'),
(21, 50, 12, '2018-09-18 22:48:37', '93000.00'),
(22, 50, 13, '2018-09-18 22:50:17', '93000.00'),
(23, 50, 14, '2018-09-18 22:54:51', '93000.00'),
(24, 50, 15, '2018-09-18 22:56:52', '93000.00'),
(25, 50, 16, '2018-09-18 22:57:17', '93000.00'),
(26, 50, 17, '2018-09-18 22:58:13', '1500.00'),
(27, 50, 18, '2018-09-18 22:58:32', '1500.00'),
(28, 50, 19, '2018-09-18 23:01:17', '1500.00'),
(29, 50, 20, '2018-09-18 23:04:20', '1500.00'),
(30, 50, 21, '2018-09-18 23:09:05', '1500.00'),
(31, 50, 22, '2018-09-18 23:09:37', '1500.00'),
(32, 50, 23, '2018-09-18 23:10:08', '1500.00'),
(33, 50, 24, '2018-09-18 23:12:34', '1500.00'),
(34, 50, 25, '2018-09-18 23:12:59', '1500.00'),
(35, 51, 26, '2018-09-18 23:19:56', '377000.00'),
(36, 50, 27, '2018-09-19 01:00:00', '1500.00'),
(37, 50, 28, '2018-09-19 05:53:25', '5653000.00'),
(38, 50, 29, '2018-09-19 06:15:05', '56500.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `id_detalle_comp` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `precio_comp` varchar(250) NOT NULL,
  `cantidad_comp` int(11) NOT NULL,
  `importe` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`id_detalle_comp`, `id_compra`, `id_producto`, `precio_comp`, `cantidad_comp`, `importe`) VALUES
(1, 1, 2, '50', 22, '1100'),
(2, 1, 3, '10', 2, '20'),
(3, 2, 2, '50', 56, '2800'),
(4, 3, 2, '50', 21, '1050.00'),
(5, 3, 5, '8100', 100, '810000'),
(6, 4, 1, '200', 56, '11200'),
(7, 5, 2, '50', 26, '1300'),
(8, 5, 3, '10', 10, '100'),
(9, 5, 2, '50', 23, '1150'),
(10, 6, 4, '3', 5, '15'),
(11, 6, 5, '8100', 2, '16200'),
(12, 7, 5, '8100', 46, '372600'),
(13, 7, 2, '50', 250, '12500'),
(14, 7, 6, '5100', 3, '15300'),
(15, 8, 3, '10', 45, '450'),
(16, 8, 6, '5100', 26, '132600'),
(17, 9, 4, '3', 25, '75'),
(18, 9, 5, '8100', 46, '372600'),
(19, 10, 4, '3', 2, '6'),
(20, 10, 3, '10', 56, '560'),
(21, 11, 2, '50', 10, '500'),
(22, 11, 3, '10', 23, '230'),
(23, 12, 1, '200', 0, '0.00'),
(24, 12, 2, '50', 0, '0.00'),
(25, 12, 3, '10', 0, '0.00'),
(26, 13, 2, '50', 25, '1250'),
(27, 13, 1, '200', 40, '8000'),
(28, 14, 3, '10', 300, '3000'),
(29, 14, 2, '50', 250, '12500'),
(30, 15, 1, '200', 2500, '500000'),
(31, 15, 4, '3', 0, '0'),
(32, 16, 5, '8100', 2, '16200.00'),
(33, 17, 2, '50', 25, '1250'),
(34, 17, 1, '200', 450, '90000'),
(35, 17, 2, '50', 256, '12800'),
(36, 18, 10, '1000', 2500, '2500000'),
(37, 19, 10, '1000', 12, '12000'),
(38, 19, 4, '3', 2, '6'),
(39, 20, 10, '1000', 12, '12000'),
(40, 20, 4, '3', 2, '6'),
(41, 21, 10, '1000', 93, '93000'),
(42, 22, 10, '1000', 93, '93000'),
(43, 23, 10, '1000', 93, '93000'),
(44, 24, 10, '1000', 93, '93000'),
(45, 25, 10, '1000', 93, '93000'),
(46, 26, 3, '10', 150, '1500.00'),
(47, 27, 3, '10', 150, '1500.00'),
(48, 28, 3, '10', 150, '1500.00'),
(49, 29, 3, '10', 150, '1500.00'),
(50, 30, 3, '10', 150, '1500.00'),
(51, 31, 3, '10', 150, '1500.00'),
(52, 32, 3, '10', 150, '1500.00'),
(53, 33, 3, '10', 150, '1500.00'),
(54, 34, 3, '10', 150, '1500.00'),
(55, 35, 2, '50', 250, '12500'),
(56, 35, 5, '8100', 45, '364500'),
(57, 36, 2, '50', 10, '500'),
(58, 36, 3, '10', 100, '1000'),
(59, 37, 10, '1000', 5656, '5656000'),
(60, 38, 2, '50', 1200, '60000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emprendedor`
--

CREATE TABLE `emprendedor` (
  `id_emp` int(11) NOT NULL,
  `identificador_emp` varchar(250) NOT NULL,
  `nombre_emp` varchar(250) NOT NULL,
  `foto_emp` text NOT NULL,
  `email` text NOT NULL,
  `password` varchar(250) NOT NULL,
  `dni_emp` int(8) NOT NULL,
  `telefono_emp` int(12) NOT NULL,
  `categoria` varchar(250) NOT NULL,
  `comision_acumulada` varchar(250) NOT NULL DEFAULT '0',
  `estado_pago` char(1) NOT NULL DEFAULT '0',
  `fecha_insc` date NOT NULL,
  `id_cap` int(11) NOT NULL DEFAULT '1',
  `perfil` varchar(250) NOT NULL DEFAULT 'emprendedor',
  `estado` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `emprendedor`
--

INSERT INTO `emprendedor` (`id_emp`, `identificador_emp`, `nombre_emp`, `foto_emp`, `email`, `password`, `dni_emp`, `telefono_emp`, `categoria`, `comision_acumulada`, `estado_pago`, `fecha_insc`, `id_cap`, `perfil`, `estado`) VALUES
(1, '00115', 'DAGNER ALENA GUERRA', 'b9b7c-dagner.jpg', 'dalena@key.com', 'e10adc3949ba59abbe56e057f20f883e', 4151515, 73103638, '1', '0', '0', '2018-09-01', 0, 'administrador', 0),
(50, '', 'Rodolfo Vazquez Guzman', 'no_img.jpg', 'rodol@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 10157272, 73103638, '0', '0', '0', '2018-09-18', 4, 'emprendedor', 1),
(57, '', 'Dagner Alena Guerra', 'no_img.jpg', 'dalenag87@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 10157272, 78022146, '', '0', '0', '2018-09-19', 1, 'emprendedor', 1),
(58, '', '', 'no_img.jpg', 'berd@gmail.com', '', 0, 0, '', '0', '0', '2018-09-19', 1, 'emprendedor', 0),
(59, '', '', 'no_img.jpg', 'berd@gmail.com', '', 0, 0, '', '0', '0', '2018-09-19', 1, 'emprendedor', 0),
(60, '', '', 'no_img.jpg', 'berd@gmail.com', '', 0, 0, '', '0', '0', '2018-09-19', 1, 'emprendedor', 0);

--
-- Disparadores `emprendedor`
--
DELIMITER $$
CREATE TRIGGER `ELIMINAR_AD` AFTER DELETE ON `emprendedor` FOR EACH ROW DELETE FROM `emp_asoc` WHERE `emp_asoc`.`id_padre` = OLD.id_emp
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `INSERTA_AI` AFTER INSERT ON `emprendedor` FOR EACH ROW INSERT INTO  emp_cap (id_emp,id_cap,evaluacion_video) VALUES (NEW.id_emp,1,0)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emp_asoc`
--

CREATE TABLE `emp_asoc` (
  `id_emp_asoc` int(11) NOT NULL,
  `id_padre` int(11) NOT NULL,
  `id_hijo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `emp_asoc`
--

INSERT INTO `emp_asoc` (`id_emp_asoc`, `id_padre`, `id_hijo`) VALUES
(56, 1, 50),
(58, 1, 57),
(59, 50, 58),
(60, 50, 59),
(61, 50, 60);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emp_cap`
--

CREATE TABLE `emp_cap` (
  `id_emp_cap` int(11) NOT NULL,
  `id_emp` int(11) NOT NULL,
  `id_cap` int(11) NOT NULL,
  `evaluacion_video` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `emp_cap`
--

INSERT INTO `emp_cap` (`id_emp_cap`, `id_emp`, `id_cap`, `evaluacion_video`) VALUES
(19, 50, 1, 10),
(20, 50, 2, 10),
(21, 50, 3, 10),
(22, 51, 1, 10),
(23, 51, 2, 10),
(24, 51, 3, 10),
(25, 52, 1, 0),
(26, 53, 1, 0),
(27, 54, 1, 0),
(28, 55, 1, 0),
(29, 56, 1, 0),
(30, 57, 1, 0),
(31, 58, 1, 0),
(32, 59, 1, 0),
(33, 60, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacion`
--

CREATE TABLE `evaluacion` (
  `id_eval` int(11) NOT NULL,
  `pregunta` text NOT NULL,
  `respuesta` tinyint(1) NOT NULL,
  `id_cap` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `evaluacion`
--

INSERT INTO `evaluacion` (`id_eval`, `pregunta`, `respuesta`, `id_cap`) VALUES
(1, 'Seleccione las gamas de colores de purificadores dvigi:', 1, 1),
(2, 'El cambio de respuesto se debe hacer cada:', 1, 1),
(3, 'Pregunta video 2|1', 1, 2),
(4, 'Pregunta video 2|2', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_compra`
--

CREATE TABLE `orden_compra` (
  `id_orden` int(11) NOT NULL,
  `no_orden` varchar(250) NOT NULL,
  `year` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `orden_compra`
--

INSERT INTO `orden_compra` (`id_orden`, `no_orden`, `year`) VALUES
(1, '30', '2018');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre_prod` text NOT NULL,
  `stock` int(11) NOT NULL,
  `precio_original` varchar(20) NOT NULL,
  `precio_unitario` varchar(25) NOT NULL,
  `url_imagen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre_prod`, `stock`, `precio_original`, `precio_unitario`, `url_imagen`) VALUES
(1, 'Purificador De Agua Sobre Mesada Dvigi – Plata', 49, '73.50', '200', '1.jpg'),
(2, 'Purificador De Agua Sobre Mesada Plata + 2 Repuesto Dvigi', 30, '45', '50', '2.jpg'),
(3, 'Purificador De Agua Sobre Mesada Blanco + 2 Repuesto Dvigi', 45, '67.50', '10', '3.jpg'),
(4, 'Purificador De Agua Sobre Mesada  Dvigi- Blanco ', 20, '30', '3', '4.jpg'),
(5, 'Purificador De Agua Sobre Mesada Blanco + 2 Repuesto Dvigi', 10, '15', '8100', '2.jpg'),
(6, 'SODA BOT – Gasificador de Agua', 20, '30', '5100', '6.jpg'),
(10, 'Botella Purificadora De Agua Portátil + Mochila Gris DVIGI', 1200, '1614', '1000', 'botella-purificadora-de-agua-portatil-mochila-gris-dvigi.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_comisiones`
--

CREATE TABLE `tbl_comisiones` (
  `id_tbl_comisiones` int(11) NOT NULL,
  `rango_inicial` int(10) NOT NULL,
  `rango_final` int(10) NOT NULL,
  `valor_comision` varchar(10) NOT NULL,
  `categoria` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_comisiones`
--

INSERT INTO `tbl_comisiones` (`id_tbl_comisiones`, `rango_inicial`, `rango_final`, `valor_comision`, `categoria`) VALUES
(1, 1, 5, '1', 'JUNIOR'),
(2, 5, 10, '1.5', 'BRONCE'),
(3, 10, 15, '2', 'PLATA'),
(4, 15, 20, '3', 'ORO'),
(5, 0, 25, '4', 'BLACK'),
(6, 25, 30, '5', 'PROFESIONAL');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `capacitacion`
--
ALTER TABLE `capacitacion`
  ADD PRIMARY KEY (`id_cap`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_car`);

--
-- Indices de la tabla `cartera_comisiones`
--
ALTER TABLE `cartera_comisiones`
  ADD PRIMARY KEY (`id_cart_com`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id_compra`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id_detalle_comp`);

--
-- Indices de la tabla `emprendedor`
--
ALTER TABLE `emprendedor`
  ADD PRIMARY KEY (`id_emp`);

--
-- Indices de la tabla `emp_asoc`
--
ALTER TABLE `emp_asoc`
  ADD PRIMARY KEY (`id_emp_asoc`);

--
-- Indices de la tabla `emp_cap`
--
ALTER TABLE `emp_cap`
  ADD PRIMARY KEY (`id_emp_cap`);

--
-- Indices de la tabla `evaluacion`
--
ALTER TABLE `evaluacion`
  ADD PRIMARY KEY (`id_eval`);

--
-- Indices de la tabla `orden_compra`
--
ALTER TABLE `orden_compra`
  ADD PRIMARY KEY (`id_orden`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `tbl_comisiones`
--
ALTER TABLE `tbl_comisiones`
  ADD PRIMARY KEY (`id_tbl_comisiones`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `capacitacion`
--
ALTER TABLE `capacitacion`
  MODIFY `id_cap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_car` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `cartera_comisiones`
--
ALTER TABLE `cartera_comisiones`
  MODIFY `id_cart_com` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id_detalle_comp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `emprendedor`
--
ALTER TABLE `emprendedor`
  MODIFY `id_emp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `emp_asoc`
--
ALTER TABLE `emp_asoc`
  MODIFY `id_emp_asoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `emp_cap`
--
ALTER TABLE `emp_cap`
  MODIFY `id_emp_cap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `evaluacion`
--
ALTER TABLE `evaluacion`
  MODIFY `id_eval` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `orden_compra`
--
ALTER TABLE `orden_compra`
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tbl_comisiones`
--
ALTER TABLE `tbl_comisiones`
  MODIFY `id_tbl_comisiones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
