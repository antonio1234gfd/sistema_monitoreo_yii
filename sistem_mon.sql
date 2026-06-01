-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 29-05-2026 a las 21:17:43
-- Versión del servidor: 8.4.7
-- Versión de PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistem_mon`
--

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `RegistrarLecturaESP32`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarLecturaESP32` (IN `p_id_dispositivo` INT, IN `p_valor_mq135` DECIMAL(8,2), IN `p_dht22_temp` DECIMAL(5,2), IN `p_dht22_humedad` DECIMAL(5,2))   BEGIN

  INSERT INTO lecturas_sensores
  (
    id_dispositivo,
    mq135_valor,
    dht22_temperatura,
    dht22_humedad,
    fecha_hora
  )
  VALUES
  (
    p_id_dispositivo,
    p_valor_mq135,
    p_dht22_temp,
    p_dht22_humedad,
    NOW()
  );

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alertas_historial`
--

DROP TABLE IF EXISTS `alertas_historial`;
CREATE TABLE IF NOT EXISTS `alertas_historial` (
  `id_alerta` int NOT NULL AUTO_INCREMENT,
  `id_dispositivo` int DEFAULT NULL,
  `nivel_peligro` enum('ADVERTENCIA','CRITICO') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mensaje_alerta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fecha_hora` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `leida_por_usuario` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_alerta`),
  KEY `fk_alertas_disp` (`id_dispositivo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dispositivos`
--

DROP TABLE IF EXISTS `dispositivos`;
CREATE TABLE IF NOT EXISTS `dispositivos` (
  `id_dispositivo` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ubicacion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado_red` tinyint(1) DEFAULT '1',
  `ultima_conexion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_dispositivo`),
  KEY `fk_disp_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dispositivos`
--

INSERT INTO `dispositivos` (`id_dispositivo`, `user_id`, `nombre`, `ubicacion`, `estado_red`, `ultima_conexion`) VALUES
(1, 6, 'ESP32_Sala', 'Sala principal', 1, '2026-05-15 17:12:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

DROP TABLE IF EXISTS `estado`;
CREATE TABLE IF NOT EXISTS `estado` (
  `id` int NOT NULL AUTO_INCREMENT,
  `estado_nombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `estado_valor` smallint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id`, `estado_nombre`, `estado_valor`) VALUES
(1, 'Activo', 10),
(2, 'Pendiente', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_actuadores`
--

DROP TABLE IF EXISTS `estado_actuadores`;
CREATE TABLE IF NOT EXISTS `estado_actuadores` (
  `id_dispositivo` int NOT NULL,
  `color_led` enum('VERDE','AMARILLO','ROJO') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'VERDE',
  `buzzer_activo` tinyint(1) DEFAULT '0',
  `modo_operacion` enum('AUTOMATICO','MANUAL') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'AUTOMATICO',
  `ultima_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_dispositivo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

DROP TABLE IF EXISTS `genero`;
CREATE TABLE IF NOT EXISTS `genero` (
  `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `genero_nombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`id`, `genero_nombre`) VALUES
(1, 'masculino'),
(2, 'femenino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lecturas_sensores`
--

DROP TABLE IF EXISTS `lecturas_sensores`;
CREATE TABLE IF NOT EXISTS `lecturas_sensores` (
  `id_lectura` int NOT NULL AUTO_INCREMENT,
  `id_dispositivo` int DEFAULT NULL,
  `mq135_valor` decimal(8,2) DEFAULT NULL,
  `dht22_temperatura` decimal(5,2) DEFAULT NULL,
  `dht22_humedad` decimal(5,2) DEFAULT NULL,
  `fecha_hora` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_lectura`),
  KEY `fk_lecturas_disp` (`id_dispositivo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `lecturas_sensores`
--
DROP TRIGGER IF EXISTS `AlertaCalidadAire_MQ135`;
DELIMITER $$
CREATE TRIGGER `AlertaCalidadAire_MQ135` AFTER INSERT ON `lecturas_sensores` FOR EACH ROW BEGIN

  DECLARE lim_amarillo DECIMAL(10,2);
  DECLARE lim_rojo DECIMAL(10,2);

  SELECT valor_limite
    INTO lim_amarillo
  FROM umbrales_configuracion
  WHERE parametro='mq135_amarillo_max';

  SELECT valor_limite
    INTO lim_rojo
  FROM umbrales_configuracion
  WHERE parametro='mq135_rojo_min';

  IF NEW.mq135_valor >= lim_rojo THEN

    INSERT INTO alertas_historial
    (
      id_dispositivo,
      nivel_peligro,
      mensaje_alerta
    )
    VALUES
    (
      NEW.id_dispositivo,
      'CRITICO',
      CONCAT(
        'Aire contaminado MQ135: ',
        NEW.mq135_valor,
        ' ppm'
      )
    );

    UPDATE estado_actuadores
    SET color_led='ROJO',
        buzzer_activo=1
    WHERE id_dispositivo=NEW.id_dispositivo;

  ELSEIF NEW.mq135_valor > lim_amarillo THEN

    UPDATE estado_actuadores
    SET color_led='AMARILLO',
        buzzer_activo=0
    WHERE id_dispositivo=NEW.id_dispositivo;

  ELSE

    UPDATE estado_actuadores
    SET color_led='VERDE',
        buzzer_activo=0
    WHERE id_dispositivo=NEW.id_dispositivo;

  END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `apply_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

DROP TABLE IF EXISTS `perfil`;
CREATE TABLE IF NOT EXISTS `perfil` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `nombre` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `apellido` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `fecha_nacimiento` datetime DEFAULT NULL,
  `genero_id` smallint UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_perfil_genero` (`genero_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id`, `user_id`, `nombre`, `apellido`, `fecha_nacimiento`, `genero_id`, `created_at`, `updated_at`) VALUES
(1, 6, 'Admin', 'System', '2004-06-05 00:00:00', 1, '2026-05-15 12:43:24', '2026-05-15 12:58:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `id` int NOT NULL,
  `rol_nombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rol_valor` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `rol_nombre`, `rol_valor`) VALUES
(1, 'User', 10),
(2, 'Admin', 20),
(3, 'SuperUsuario', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
CREATE TABLE IF NOT EXISTS `tipo_usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo_usuario_nombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tipo_usuario_valor` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id`, `tipo_usuario_nombre`, `tipo_usuario_valor`) VALUES
(1, 'Free', 10),
(2, 'Paid', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `umbrales_configuracion`
--

DROP TABLE IF EXISTS `umbrales_configuracion`;
CREATE TABLE IF NOT EXISTS `umbrales_configuracion` (
  `id_configuracion` int NOT NULL AUTO_INCREMENT,
  `parametro` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `valor_limite` decimal(10,2) DEFAULT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_configuracion`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `umbrales_configuracion`
--

INSERT INTO `umbrales_configuracion` (`id_configuracion`, `parametro`, `valor_limite`, `descripcion`) VALUES
(1, 'mq135_verde_max', 700.00, 'LED VERDE'),
(2, 'mq135_amarillo_max', 1000.00, 'LED AMARILLO'),
(3, 'mq135_rojo_min', 1000.01, 'LED ROJO + BUZZER');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rol_id` int DEFAULT NULL,
  `estado_id` int NOT NULL,
  `tipo_usuario_id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `verification_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipo_usuario` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_user_rol` (`rol_id`),
  KEY `fk_users_estado` (`estado_id`),
  KEY `fk_users_tipo_usuario` (`tipo_usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `rol_id`, `estado_id`, `tipo_usuario_id`, `created_at`, `updated_at`, `verification_token`, `role`, `tipo_usuario`) VALUES
(6, 'Admin', 'BpY6MkkexxQGpV_pWcIeseozVHf8niy4', '$2y$13$JDfYbjgiHYr3q0ibkjCoIePCRioRCqL.BO7.SsRrWfSEt0TsKBwP.', NULL, 'admin@example.com', 2, 1, 1, '2026-02-27 15:18:46', '2026-05-15 12:56:23', NULL, NULL, NULL);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alertas_historial`
--
ALTER TABLE `alertas_historial`
  ADD CONSTRAINT `fk_alertas_disp` FOREIGN KEY (`id_dispositivo`) REFERENCES `dispositivos` (`id_dispositivo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `dispositivos`
--
ALTER TABLE `dispositivos`
  ADD CONSTRAINT `fk_disp_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `estado_actuadores`
--
ALTER TABLE `estado_actuadores`
  ADD CONSTRAINT `fk_actuadores_disp` FOREIGN KEY (`id_dispositivo`) REFERENCES `dispositivos` (`id_dispositivo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `lecturas_sensores`
--
ALTER TABLE `lecturas_sensores`
  ADD CONSTRAINT `fk_lecturas_disp` FOREIGN KEY (`id_dispositivo`) REFERENCES `dispositivos` (`id_dispositivo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD CONSTRAINT `fk_perfil_genero` FOREIGN KEY (`genero_id`) REFERENCES `genero` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_rol` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`),
  ADD CONSTRAINT `fk_users_estado` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`),
  ADD CONSTRAINT `fk_users_tipo_usuario` FOREIGN KEY (`tipo_usuario_id`) REFERENCES `tipo_usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
