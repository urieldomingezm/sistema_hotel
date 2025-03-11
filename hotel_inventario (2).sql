-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-03-2025 a las 01:46:39
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hotel_inventario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Laptop', 'Computadoras portátiles'),
(2, 'Monitor', 'Pantallas para computadoras'),
(3, 'Teclado', 'Dispositivos de entrada'),
(4, 'Mouse', 'Dispositivos de entrada'),
(5, 'Impresora', 'Equipos de impresión');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `numero_serie` varchar(100) NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `ubicacion_id` int(11) DEFAULT NULL,
  `fecha_adquisicion` date DEFAULT NULL,
  `fecha_garantia` date DEFAULT NULL,
  `fecha_expericion` date DEFAULT NULL,
  `estado` enum('Operativo','En mantenimiento','Fuera de servicio','Descontinuado') DEFAULT 'Operativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id`, `nombre`, `descripcion`, `numero_serie`, `marca`, `modelo`, `categoria_id`, `ubicacion_id`, `fecha_adquisicion`, `fecha_garantia`, `fecha_expericion`, `estado`) VALUES
(3, 'Prueba 23', 'Teclado inalámbrico', 'SN98765', 'Logitech', 'K380', 3, 3, '2021-09-20', '2025-02-03', '2025-02-20', 'Operativo'),
(4, 'Mouse Microsoft', 'Mouse ergonómico inalámbrico', 'SN56789', 'Microsoft', 'Ergo 360', 4, 4, '2020-05-18', '0000-00-00', '0000-00-00', 'En mantenimiento'),
(26, 'Laptop HP', 'Laptop de 15 pulgadas para oficina', 'SN12345', 'HP', 'Pavilion 15', 1, 1, '2023-06-10', '2025-02-19', '2025-02-28', 'Operativo'),
(27, 'Monitor Dell', 'Monitor de 24 pulgadas Full HD', 'SN54321', 'Dell', 'P2419H', 2, 2, '2022-11-15', NULL, NULL, 'Operativo'),
(29, 'Mouse Microsoft', 'Mouse ergonómico inalámbrico', 'SNS56789', 'Microsoft', 'Ergo 360', 4, 4, '2020-05-18', NULL, NULL, 'Operativo'),
(30, 'Impresora Epson', 'Impresora multifuncional a color', 'SN534567', 'Epson', 'L3150', 5, 5, '2023-02-25', NULL, NULL, 'En mantenimiento'),
(31, 'Laptop Lenovo', 'Laptop de 14 pulgadas para diseño gráfico', 'SDN67890', 'Lenovo', 'ThinkPad X1', 1, 2, '2023-01-12', NULL, NULL, 'Operativo'),
(32, 'Monitor LG', 'Monitor de 27 pulgadas 4K', 'SN09A876', 'LG', '27UK850', 2, 3, '2022-08-22', NULL, NULL, 'Operativo'),
(33, 'Teclado Microsoft', 'Teclado ergonómico con reposamuñecas', 'SNS11223', 'Microsoft', 'Sculpt Ergonomic', 3, 4, '2021-07-30', NULL, NULL, 'Operativo'),
(34, 'Mouse Logitech', 'Mouse inalámbrico con sensor óptico', 'SN3F3445', 'Logitech', 'M720 Triathlon', 4, 5, '2020-12-05', NULL, NULL, 'Operativo'),
(35, 'Impresora HP', 'Impresora láser monocromática', 'SN55667', 'HP', 'LaserJet Pro', 5, 1, '2023-03-15', NULL, NULL, 'En mantenimiento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_usuarios`
--

CREATE TABLE `login_usuarios` (
  `id_usuario` int(11) NOT NULL,
  `usuario_nombre` varchar(50) NOT NULL,
  `usuario_apellido` varchar(200) NOT NULL,
  `usuario_password` varchar(20) DEFAULT NULL,
  `usuario_email` varchar(200) NOT NULL,
  `usuario_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `login_usuarios`
--

INSERT INTO `login_usuarios` (`id_usuario`, `usuario_nombre`, `usuario_apellido`, `usuario_password`, `usuario_email`, `usuario_registro`) VALUES
(13, 'ANGEL URIEL', 'DOMINGUEZ MEDINA', '123456', 'w2alter@gmail.com', '2025-02-08 06:07:21'),
(14, 'ANGEL URIEL', 'DOMINGUEZ MEDINA', '123456', 'waltersds@gmail.com', '2025-02-09 04:15:33'),
(15, 'ANGEL URIEL', 'dominguez medina', '123456', 'waltersdssdsds@gmail.com', '2025-03-11 00:21:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id` int(11) NOT NULL,
  `equipo_id` int(11) NOT NULL,
  `tipo` enum('Asignación','Cambio de ubicación','Mantenimiento','Baja') NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_movimiento` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_responsable` varchar(150) DEFAULT NULL,
  `nueva_ubicacion_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id`, `equipo_id`, `tipo`, `descripcion`, `fecha_movimiento`, `usuario_responsable`, `nueva_ubicacion_id`) VALUES
(3, 3, 'Mantenimiento', 'Revisión de conectividad', '2025-02-06 18:49:37', 'Carlos López', 3),
(4, 4, 'Cambio de ubicación', 'Reubicado en la sala de servidores', '2025-02-06 18:49:37', 'Ana Torres', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicaciones`
--

CREATE TABLE `ubicaciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ubicaciones`
--

INSERT INTO `ubicaciones` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Oficina de computo', 'Ubicacion principal para todo el proceso'),
(2, 'Oficina B', 'Departamento de Contabilidad'),
(3, 'Bodega', 'Almacenamiento de equipos'),
(4, 'Sala de Servidores', 'Ubicación de los servidores principales'),
(5, 'Recepción', 'Área de atención al público'),
(8, 'heol2', 'Ubicación de los servidores principalesdsds'),
(9, 'oficina de agustin', 'prueba');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_serie` (`numero_serie`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `ubicacion_id` (`ubicacion_id`);

--
-- Indices de la tabla `login_usuarios`
--
ALTER TABLE `login_usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipo_id` (`equipo_id`),
  ADD KEY `nueva_ubicacion_id` (`nueva_ubicacion_id`);

--
-- Indices de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `login_usuarios`
--
ALTER TABLE `login_usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD CONSTRAINT `equipos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `equipos_ibfk_2` FOREIGN KEY (`ubicacion_id`) REFERENCES `ubicaciones` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movimientos_ibfk_2` FOREIGN KEY (`nueva_ubicacion_id`) REFERENCES `ubicaciones` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
