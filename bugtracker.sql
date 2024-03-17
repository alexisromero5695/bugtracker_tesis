/*
 Navicat Premium Data Transfer

 Source Server         : LOCAL
 Source Server Type    : MySQL
 Source Server Version : 50733
 Source Host           : localhost:3306
 Source Schema         : bugtracker

 Target Server Type    : MySQL
 Target Server Version : 50733
 File Encoding         : 65001

 Date: 07/12/2023 19:14:25
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for avatar
-- ----------------------------
DROP TABLE IF EXISTS `avatar`;
CREATE TABLE `avatar`  (
  `id_avatar` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `imagen_avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_avatar`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of avatar
-- ----------------------------
INSERT INTO `avatar` VALUES (2, '1650233805.png');
INSERT INTO `avatar` VALUES (3, '1650233901.png');
INSERT INTO `avatar` VALUES (4, '1650233935.png');
INSERT INTO `avatar` VALUES (5, '1650234002.png');
INSERT INTO `avatar` VALUES (6, '1650234132.png');
INSERT INTO `avatar` VALUES (7, '1650234199.png');
INSERT INTO `avatar` VALUES (9, '1650236036.png');
INSERT INTO `avatar` VALUES (10, '1650236056.png');
INSERT INTO `avatar` VALUES (11, '1650236110.png');
INSERT INTO `avatar` VALUES (14, '1650246962.png');
INSERT INTO `avatar` VALUES (15, '1651421500.png');
INSERT INTO `avatar` VALUES (16, NULL);
INSERT INTO `avatar` VALUES (17, NULL);
INSERT INTO `avatar` VALUES (18, '1653117134.png');
INSERT INTO `avatar` VALUES (19, '1674606688.png');

-- ----------------------------
-- Table structure for color
-- ----------------------------
DROP TABLE IF EXISTS `color`;
CREATE TABLE `color`  (
  `id_color` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_color` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_color`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of color
-- ----------------------------
INSERT INTO `color` VALUES (1, 'primary');
INSERT INTO `color` VALUES (2, 'secondary');
INSERT INTO `color` VALUES (3, 'dark');
INSERT INTO `color` VALUES (4, 'gray');
INSERT INTO `color` VALUES (5, 'success');
INSERT INTO `color` VALUES (6, 'danger');
INSERT INTO `color` VALUES (7, 'warning');
INSERT INTO `color` VALUES (8, 'info');
INSERT INTO `color` VALUES (9, 'blue');
INSERT INTO `color` VALUES (10, 'azure');
INSERT INTO `color` VALUES (11, 'indigo');
INSERT INTO `color` VALUES (12, 'purple');
INSERT INTO `color` VALUES (13, 'pink');
INSERT INTO `color` VALUES (14, 'orange');
INSERT INTO `color` VALUES (15, 'teal');

-- ----------------------------
-- Table structure for estado
-- ----------------------------
DROP TABLE IF EXISTS `estado`;
CREATE TABLE `estado`  (
  `id_estado` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `orden_estado` int(11) NULL DEFAULT NULL,
  `color_estado` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `descripcion_estado` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `color_texto_estado` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_estado`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of estado
-- ----------------------------
INSERT INTO `estado` VALUES (1, 'Nuevo', 1, '#42526e', NULL, '#fff');
INSERT INTO `estado` VALUES (2, 'En desarrollo', 2, '#0052cc', NULL, '#fff');
INSERT INTO `estado` VALUES (3, 'En consulta', 3, '#0052cc', NULL, '#fff');
INSERT INTO `estado` VALUES (4, 'QA', 4, '#0052cc', NULL, '#fff');
INSERT INTO `estado` VALUES (5, 'Cerrado', 5, '#00875a', NULL, '#fff');
INSERT INTO `estado` VALUES (6, 'Suspendido', 6, '#dfe1e6', NULL, '#485873');

-- ----------------------------
-- Table structure for estado_incidencia
-- ----------------------------
DROP TABLE IF EXISTS `estado_incidencia`;
CREATE TABLE `estado_incidencia`  (
  `id_estado_incidencia` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_estado_incidencia` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `color_estado_incidencia` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_estado_incidencia`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of estado_incidencia
-- ----------------------------
INSERT INTO `estado_incidencia` VALUES (1, 'Nuevo', '#F6BF26');
INSERT INTO `estado_incidencia` VALUES (2, 'En consulta', '#F4511E');
INSERT INTO `estado_incidencia` VALUES (3, 'En desarrollo', '#33B679');
INSERT INTO `estado_incidencia` VALUES (4, 'QA', '#039BE5');
INSERT INTO `estado_incidencia` VALUES (5, 'Cerrado', '#D50000');
INSERT INTO `estado_incidencia` VALUES (6, 'Suspendido', '#7986CB');

-- ----------------------------
-- Table structure for incidencia
-- ----------------------------
DROP TABLE IF EXISTS `incidencia`;
CREATE TABLE `incidencia`  (
  `id_incidencia` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_proyecto` int(11) UNSIGNED NULL DEFAULT NULL,
  `id_informante` int(11) UNSIGNED NULL DEFAULT NULL,
  `id_responsable` int(11) UNSIGNED NULL DEFAULT NULL,
  `id_estado_incidencia` int(11) NULL DEFAULT NULL,
  `id_prioridad` int(11) UNSIGNED NULL DEFAULT NULL,
  `id_resolucion` int(11) UNSIGNED NULL DEFAULT NULL,
  `nombre_incidencia` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `descripcion_incidencia` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `fecha_creacion_incidencia` datetime(0) NULL DEFAULT NULL,
  `fecha_actualizacion_incidencia` datetime(0) NULL DEFAULT NULL,
  `fecha_vencimiento_incidencia` date NULL DEFAULT NULL,
  `id_tipo_incidencia` int(11) UNSIGNED NULL DEFAULT NULL,
  `numero_incidencia` int(11) NULL DEFAULT NULL,
  `id_sistema` int(11) NULL DEFAULT NULL,
  `id_cliente` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_incidencia`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of incidencia
-- ----------------------------
INSERT INTO `incidencia` VALUES (1, 2, 2, NULL, 1, 3, NULL, 'HOSPITAL -ACCIONES/EDITAR DATOS', NULL, '2022-04-01 16:07:01', '2022-04-20 16:07:09', NULL, 2, 1, NULL, NULL);
INSERT INTO `incidencia` VALUES (2, 3, 4, 2, 2, 1, NULL, '	LIMPIAR FORMULARIO al presionar volver, cancelar y guardar.', NULL, '2022-04-01 16:07:01', '2022-04-20 16:07:09', NULL, 2, 1, NULL, NULL);
INSERT INTO `incidencia` VALUES (3, 2, 3, 4, 3, 4, NULL, '	EVENTO ASISTENCIA/AUSENCIA - No limpia formulario al presionar volver y crear nuevamente', NULL, '2022-04-01 16:07:01', '2022-04-20 16:07:09', NULL, 2, 2, NULL, NULL);
INSERT INTO `incidencia` VALUES (4, 2, 3, 4, 4, 4, NULL, '	HOSPITAL - Ingreso a Hospital - Tipo Vínculo: Propietario', NULL, '2022-04-01 16:07:01', '2022-04-20 16:07:09', NULL, 2, 3, NULL, NULL);
INSERT INTO `incidencia` VALUES (5, 3, 4, 2, 5, 1, NULL, '	LISTA PRECIO - Msje visual de carga al actualizar lista precios', NULL, '2022-04-01 16:07:01', '2022-04-20 16:07:09', NULL, 2, 2, NULL, NULL);
INSERT INTO `incidencia` VALUES (6, 3, 4, 2, 6, 1, NULL, 'HOSPITAL - Ingreso a Hospital - Segundo apellido NULL', NULL, '2022-04-01 16:07:01', '2022-04-20 16:07:09', NULL, 2, 3, NULL, NULL);
INSERT INTO `incidencia` VALUES (7, 2, 3, 4, 1, 2, NULL, 'ingreso formulario', '<p>No guarda</p>', '2022-05-21 16:39:44', NULL, '2022-05-27', 2, 4, NULL, NULL);

-- ----------------------------
-- Table structure for prioridad
-- ----------------------------
DROP TABLE IF EXISTS `prioridad`;
CREATE TABLE `prioridad`  (
  `id_prioridad` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_prioridad` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `orden_prioridad` int(11) NULL DEFAULT NULL,
  `imagen_prioridad` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_prioridad`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of prioridad
-- ----------------------------
INSERT INTO `prioridad` VALUES (1, 'Inmediata', 1, 'critical.svg');
INSERT INTO `prioridad` VALUES (2, 'Alta', 2, 'high-2.svg');
INSERT INTO `prioridad` VALUES (3, 'Media', 3, 'normal.svg');
INSERT INTO `prioridad` VALUES (4, 'Baja', 4, 'low-2.svg');
INSERT INTO `prioridad` VALUES (5, 'Ninguna', 5, 'trivial.svg');

-- ----------------------------
-- Table structure for proyecto
-- ----------------------------
DROP TABLE IF EXISTS `proyecto`;
CREATE TABLE `proyecto`  (
  `id_proyecto` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_staff` int(11) UNSIGNED NULL DEFAULT NULL,
  `id_avatar` int(11) UNSIGNED NULL DEFAULT NULL,
  `nombre_proyecto` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `codigo_proyecto` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `descripcion_proyecto` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `fecha_inicio_proyecto` date NULL DEFAULT NULL,
  `fecha_fin_proyecto` date NULL DEFAULT NULL,
  `vigente_proyecto` int(11) NULL DEFAULT 1,
  PRIMARY KEY (`id_proyecto`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of proyecto
-- ----------------------------
INSERT INTO `proyecto` VALUES (2, 3, 5, 'CRMVETERINARIO', 'CRMVET', '<p><br></p>', NULL, NULL, 1);
INSERT INTO `proyecto` VALUES (3, 2, 9, 'OKA REPUESTOS', 'OKA', '<p><br></p>', '2022-04-18', '2022-04-18', 1);
INSERT INTO `proyecto` VALUES (4, 4, 6, 'BUG TRACKER', 'BTK', '<p>Descripcion<br></p>', '2022-04-01', '2022-04-18', 1);
INSERT INTO `proyecto` VALUES (5, NULL, 4, 'VUE PROJECT', 'VPJ', '<p><br></p>', '2022-04-01', '2022-05-31', 1);
INSERT INTO `proyecto` VALUES (6, NULL, 5, 'NOMBRE PROYECTO', 'PY2', '<p><br></p>', '2022-05-01', '2022-05-01', 1);
INSERT INTO `proyecto` VALUES (7, 3, 12, 'PROYECTO PRUEBAS', 'PY1', NULL, '2022-06-22', '2022-06-22', 1);
INSERT INTO `proyecto` VALUES (8, 2, 18, 'BUINZOO', 'BNZ', NULL, '2023-01-22', '2023-01-22', 1);

-- ----------------------------
-- Table structure for resolucion
-- ----------------------------
DROP TABLE IF EXISTS `resolucion`;
CREATE TABLE `resolucion`  (
  `id_resolucion` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_resolucion` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `orden_resolucion` int(11) NULL DEFAULT NULL,
  `descripcion_resolucion` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id_resolucion`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of resolucion
-- ----------------------------
INSERT INTO `resolucion` VALUES (1, 'Sin resolver', 1, NULL);
INSERT INTO `resolucion` VALUES (2, 'Terminado', 2, NULL);
INSERT INTO `resolucion` VALUES (3, 'No se hará', 3, NULL);
INSERT INTO `resolucion` VALUES (4, 'Duplicado', 4, NULL);
INSERT INTO `resolucion` VALUES (5, 'No reproducible', 5, NULL);
INSERT INTO `resolucion` VALUES (6, 'Rechazado', 6, NULL);

-- ----------------------------
-- Table structure for staff
-- ----------------------------
DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff`  (
  `id_staff` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_color` int(11) NULL DEFAULT NULL,
  `nombre_staff` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido_paterno_staff` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido_materno_staff` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `puesto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `departamento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `empresa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `direccion_staff` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `vigente_staff` int(11) NULL DEFAULT 1,
  PRIMARY KEY (`id_staff`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of staff
-- ----------------------------
INSERT INTO `staff` VALUES (2, 1, 'Alexis', 'Romero', 'Correa', NULL, NULL, NULL, NULL, 1);
INSERT INTO `staff` VALUES (3, 5, 'Victor', 'Romero', 'Correa', NULL, NULL, NULL, NULL, 1);
INSERT INTO `staff` VALUES (4, 3, 'Stefany', 'Zorrilla', 'Pantoja', NULL, NULL, NULL, NULL, 1);
INSERT INTO `staff` VALUES (5, NULL, 'Alexis', 'Romero', 'Correa', NULL, NULL, NULL, NULL, 1);

-- ----------------------------
-- Table structure for tipo_incidencia
-- ----------------------------
DROP TABLE IF EXISTS `tipo_incidencia`;
CREATE TABLE `tipo_incidencia`  (
  `id_tipo_incidencia` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_tipo_incidencia` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `imagen_tipo_incidencia` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `orden_tipo_incidencia` int(11) NULL DEFAULT NULL,
  `tiposubtarea_tipo_incidencia` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_tipo_incidencia`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tipo_incidencia
-- ----------------------------
INSERT INTO `tipo_incidencia` VALUES (1, 'Epica', 'epica.svg', NULL, NULL);
INSERT INTO `tipo_incidencia` VALUES (2, 'Error', 'error.svg', NULL, NULL);
INSERT INTO `tipo_incidencia` VALUES (3, 'Mejora', 'mejora.svg', NULL, NULL);
INSERT INTO `tipo_incidencia` VALUES (4, 'Nueva función', 'nueva_funcionalidad.svg', NULL, NULL);
INSERT INTO `tipo_incidencia` VALUES (5, 'Solicitud', 'solicitud.svg', NULL, NULL);
INSERT INTO `tipo_incidencia` VALUES (6, 'Tarea', 'tarea.svg', NULL, NULL);
INSERT INTO `tipo_incidencia` VALUES (7, 'Subtarea', 'subtarea.svg', NULL, 1);
INSERT INTO `tipo_incidencia` VALUES (8, 'Error desarrollo', 'error_desarrollo.svg', NULL, 1);
INSERT INTO `tipo_incidencia` VALUES (9, 'Soporte', 'soporte.svg', NULL, NULL);
INSERT INTO `tipo_incidencia` VALUES (10, 'Necesidad', 'necesidad.svg', NULL, NULL);
INSERT INTO `tipo_incidencia` VALUES (11, 'Idea/Iniciativa', 'idea_iniciativa.svg', NULL, NULL);
INSERT INTO `tipo_incidencia` VALUES (12, 'Historia', 'historia.svg', NULL, NULL);

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario`  (
  `id_usuario` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_staff` int(11) UNSIGNED NULL DEFAULT NULL,
  `id_tipo_usuario` int(11) NULL DEFAULT NULL,
  `correo_usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contrasenia_usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vigente_usuario` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_usuario`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES (1, 2, NULL, 'info.alexisromero@gmail.com', '$2y$10$QkjfMa.3yfIU.fohYkv3COg7Go61Untw57673CKaMeNtCO3gFkL8i', 1);
INSERT INTO `usuario` VALUES (2, 3, NULL, 'viromero@gmail.com', '$2y$10$QkjfMa.3yfIU.fohYkv3COg7Go61Untw57673CKaMeNtCO3gFkL8i', 1);
INSERT INTO `usuario` VALUES (3, 4, NULL, 'stefanyzpemsi@gmail.com', '$2y$10$QkjfMa.3yfIU.fohYkv3COg7Go61Untw57673CKaMeNtCO3gFkL8i', 1);
INSERT INTO `usuario` VALUES (4, 5, 1, 'aromero@gmail.com', '$2y$10$QkjfMa.3yfIU.fohYkv3COg7Go61Untw57673CKaMeNtCO3gFkL8i', 1);

SET FOREIGN_KEY_CHECKS = 1;
