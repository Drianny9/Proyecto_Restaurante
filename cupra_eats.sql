-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-01-2026 a las 16:24:57
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cupra_eats`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre`) VALUES
(1, 'Entrantes'),
(2, 'Platos Principales'),
(3, 'Bebidas'),
(4, 'Postres');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `linea_pedido`
--

CREATE TABLE `linea_pedido` (
  `id_linea` int(10) UNSIGNED NOT NULL,
  `id_pedido` int(10) UNSIGNED NOT NULL,
  `id_producto` int(10) UNSIGNED NOT NULL,
  `id_oferta` int(10) UNSIGNED DEFAULT NULL,
  `precio_unidad` decimal(10,2) NOT NULL,
  `cantidad` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `linea_pedido`
--

INSERT INTO `linea_pedido` (`id_linea`, `id_pedido`, `id_producto`, `id_oferta`, `precio_unidad`, `cantidad`) VALUES
(1, 1, 2, NULL, 12.00, 1),
(2, 1, 1, NULL, 16.50, 1),
(39, 16, 1, NULL, 16.50, 1),
(40, 16, 3, NULL, 15.00, 1),
(41, 16, 5, NULL, 6.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE `log` (
  `id_log` int(10) UNSIGNED NOT NULL,
  `accion` varchar(100) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta`
--

CREATE TABLE `oferta` (
  `id_oferta` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `descuento_porcentaje` decimal(5,2) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `activa` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `oferta`
--

INSERT INTO `oferta` (`id_oferta`, `nombre`, `descripcion`, `descuento_porcentaje`, `fecha_inicio`, `fecha_fin`, `activa`) VALUES
(2, 'SWEET WEEKEND', '20% OFF en todos nuestros postres gourmet', 20.00, '2026-01-05', '2026-01-31', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta_producto`
--

CREATE TABLE `oferta_producto` (
  `id_oferta` int(10) UNSIGNED NOT NULL,
  `id_producto` int(10) UNSIGNED NOT NULL,
  `precio_especial` decimal(10,2) DEFAULT NULL,
  `cantidad` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `oferta_producto`
--

INSERT INTO `oferta_producto` (`id_oferta`, `id_producto`, `precio_especial`, `cantidad`) VALUES
(2, 11, NULL, NULL),
(2, 12, NULL, NULL),
(2, 13, NULL, NULL),
(2, 14, NULL, NULL),
(2, 15, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(10) UNSIGNED NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` varchar(40) NOT NULL,
  `importe_total` decimal(12,2) NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `fecha`, `estado`, `importe_total`, `id_usuario`) VALUES
(1, '2026-01-05 12:41:29', 'pendiente', 31.35, 1),
(16, '2026-01-05 13:22:39', 'pendiente', 41.25, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `id_categoria` int(10) UNSIGNED NOT NULL,
  `precio_base` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT 'placeholder.webp'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre`, `descripcion`, `id_categoria`, `precio_base`, `imagen`) VALUES
(1, 'Tartar Black Angus', 'Carne Black Angus cortada a cuchillo, aliñada con emulsión ahumada', 1, 16.50, 'Tartar.webp'),
(2, 'Crema de Coliflor Trufada', 'Crema suave de coliflor con aceite de trufa negra', 1, 12.00, 'Crema_coliflor.webp'),
(3, 'Carpaccio de Pulpo', 'Pulpo laminado con aceite cítrico y sal negra', 1, 15.00, 'Carpaccio_pulpo.webp'),
(4, 'Croquetas Negras de Calamar', 'Croquetas cremosas con tinta de calamar', 1, 11.50, 'Croquetas_negras.webp'),
(5, 'Pan Artesano CUPRA', 'Selección de panes artesanos con mantequilla ahumada', 1, 6.00, 'Pan_rustico.webp'),
(6, 'Pulpo Braseado sobre Puré Negro', 'Pulpo braseado con puré de patata y tinta de calamar', 2, 24.00, 'Pulpo.webp'),
(7, 'Solomillo de Ternera Premium', 'Solomillo a baja temperatura con jugo reducido', 2, 28.50, 'Solomillo_ternera.webp'),
(8, 'Arroz Negro de Sepia', 'Arroz meloso con sepia y alioli suave', 2, 22.00, 'Arroz_negro.webp'),
(9, 'Lubina Asada al Carbón', 'Lubina asada con verduras de temporada', 2, 25.00, 'Lubina.webp'),
(10, 'Risotto de Setas y Parmesano', 'Risotto cremoso con setas y parmesano curado', 2, 21.00, 'Rissoto_setas.webp'),
(11, 'Postre CUPRA Signature', 'Mousse de chocolate negro con crumble de cacao', 4, 9.50, 'Postre_CUPRA.webp'),
(12, 'Esfera de Chocolate Ahumado', 'Chocolate relleno con corazón líquido', 4, 10.00, 'Esfera_chocolate.webp'),
(13, 'Tarta de Queso Artesana', 'Tarta de queso cremosa horneada', 4, 8.50, 'Tarta_queso.webp'),
(14, 'Brownie Dark Chocolate', 'Brownie intenso con toque de sal marina', 4, 8.00, 'Brownie.webp'),
(15, 'Helado de Vainilla Bourbon', 'Helado artesanal de vainilla bourbon', 4, 7.00, 'Helado_vainilla.webp'),
(16, 'Old Fashioned CUPRA', 'Bourbon, azúcar ahumado y bitter', 3, 12.00, 'Old_Fashioned_CUPRA.webp'),
(17, 'Cóctel Dark Negroni', 'Negroni reinterpretado con notas ahumadas', 3, 13.00, 'Coctel.webp'),
(18, 'Vino Tinto Reserva', 'Selección de vino tinto reserva nacional', 3, 5.50, 'Vino_tinto.webp'),
(19, 'Agua Mineral Premium', 'Agua mineral natural', 3, 3.00, 'Agua_mineral.webp'),
(20, 'Café Espresso Intenso', 'Café espresso de tueste oscuro', 3, 2.50, 'Espresso.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(120) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `rol` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `email`, `contraseña`, `direccion`, `telefono`, `rol`) VALUES
(1, 'Usuario Prueba', 'prueba@gmail.com', '$2y$10$iEs9FcwjNpnLFlQJkdwvWeNs7IuT58TZXY.z6uz.Dm7JSZB5Um3xa', 'Dirección ejemplo', '600000000', 'admin'),
(2, 'Drianny Batalla Ulises', 'drianny@gmail.com', '$2y$10$TlzGSmhW9NZBizamUjO5FeU3n7fAQa7ouYQ7n3wmLpcdc3oRl/Xam', '', '', 'user');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `linea_pedido`
--
ALTER TABLE `linea_pedido`
  ADD PRIMARY KEY (`id_linea`),
  ADD KEY `fk_linea_pedido_pedido` (`id_pedido`),
  ADD KEY `fk_linea_pedido_producto` (`id_producto`),
  ADD KEY `fk_linea_pedido_oferta` (`id_oferta`);

--
-- Indices de la tabla `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `fk_log_usuario` (`id_usuario`);

--
-- Indices de la tabla `oferta`
--
ALTER TABLE `oferta`
  ADD PRIMARY KEY (`id_oferta`);

--
-- Indices de la tabla `oferta_producto`
--
ALTER TABLE `oferta_producto`
  ADD PRIMARY KEY (`id_oferta`,`id_producto`),
  ADD KEY `fk_oferta_producto_producto` (`id_producto`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `fk_pedido_usuario` (`id_usuario`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_producto_categoria` (`id_categoria`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `linea_pedido`
--
ALTER TABLE `linea_pedido`
  MODIFY `id_linea` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `oferta`
--
ALTER TABLE `oferta`
  MODIFY `id_oferta` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `linea_pedido`
--
ALTER TABLE `linea_pedido`
  ADD CONSTRAINT `fk_linea_pedido_oferta` FOREIGN KEY (`id_oferta`) REFERENCES `oferta` (`id_oferta`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_linea_pedido_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_linea_pedido_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `fk_log_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `oferta_producto`
--
ALTER TABLE `oferta_producto`
  ADD CONSTRAINT `fk_oferta_producto_oferta` FOREIGN KEY (`id_oferta`) REFERENCES `oferta` (`id_oferta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_oferta_producto_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_pedido_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
