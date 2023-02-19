/*
 Navicat Premium Data Transfer

 Source Server         : LOCALHOST
 Source Server Type    : MySQL
 Source Server Version : 100420
 Source Host           : localhost:3306
 Source Schema         : crece

 Target Server Type    : MySQL
 Target Server Version : 100420
 File Encoding         : 65001

 Date: 07/02/2023 22:23:05
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for administradores
-- ----------------------------
DROP TABLE IF EXISTS `administradores`;
CREATE TABLE `administradores`  (
  `IdAdmin` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `AdminPassword` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nivel` int(1) NOT NULL,
  `Nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `Sucursal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`IdAdmin`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of administradores
-- ----------------------------
INSERT INTO `administradores` VALUES ('admin', 'admin', 1, 'Ing. Juan Jose Pedraza', '');
INSERT INTO `administradores` VALUES ('edgar', 'admin', 0, 'Edgar Treviño Sosa', '');

-- ----------------------------
-- Table structure for basicos
-- ----------------------------
DROP TABLE IF EXISTS `basicos`;
CREATE TABLE `basicos`  (
  `nombre` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `foto` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fecha` date NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cargos
-- ----------------------------
DROP TABLE IF EXISTS `cargos`;
CREATE TABLE `cargos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `curp` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `concepto` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `cantidad` decimal(10, 2) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `usuario` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cat_estatus
-- ----------------------------
DROP TABLE IF EXISTS `cat_estatus`;
CREATE TABLE `cat_estatus`  (
  `IdEstatus` int(1) NOT NULL,
  `Estatus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`IdEstatus`) USING BTREE,
  INDEX `IdEstatus`(`IdEstatus`, `Estatus`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cat_estatus
-- ----------------------------
INSERT INTO `cat_estatus` VALUES (0, 'Activa');
INSERT INTO `cat_estatus` VALUES (1, 'Cancelada');
INSERT INTO `cat_estatus` VALUES (2, 'Saldada');

-- ----------------------------
-- Table structure for cat_formadepago
-- ----------------------------
DROP TABLE IF EXISTS `cat_formadepago`;
CREATE TABLE `cat_formadepago`  (
  `Dias` int(3) NOT NULL,
  `Nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`Dias`) USING BTREE,
  INDEX `Dias`(`Dias`, `Nombre`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cat_formadepago
-- ----------------------------
INSERT INTO `cat_formadepago` VALUES (0, 'SIN DEFINIR');
INSERT INTO `cat_formadepago` VALUES (7, 'SEMANAL');
INSERT INTO `cat_formadepago` VALUES (15, 'QUINCENAL');
INSERT INTO `cat_formadepago` VALUES (30, 'MENSUAL');

-- ----------------------------
-- Table structure for cat_historia
-- ----------------------------
DROP TABLE IF EXISTS `cat_historia`;
CREATE TABLE `cat_historia`  (
  `IdAccion` int(100) NOT NULL COMMENT 'Id de la Accion de Historia',
  `Nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL COMMENT 'Descripcion de la historia',
  PRIMARY KEY (`IdAccion`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cat_historia
-- ----------------------------
INSERT INTO `cat_historia` VALUES (0, 'General');
INSERT INTO `cat_historia` VALUES (1, 'Login');
INSERT INTO `cat_historia` VALUES (2, 'Solicitud');

-- ----------------------------
-- Table structure for cat_tipodescuento
-- ----------------------------
DROP TABLE IF EXISTS `cat_tipodescuento`;
CREATE TABLE `cat_tipodescuento`  (
  `IdTipoDescuento` int(1) NOT NULL,
  `TipoDescuento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`IdTipoDescuento`) USING BTREE,
  INDEX `IdTipoDescuento`(`IdTipoDescuento`, `TipoDescuento`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cat_tipodescuento
-- ----------------------------
INSERT INTO `cat_tipodescuento` VALUES (0, 'Total');
INSERT INTO `cat_tipodescuento` VALUES (1, 'Moratorios');
INSERT INTO `cat_tipodescuento` VALUES (2, 'Financiamiento');
INSERT INTO `cat_tipodescuento` VALUES (3, 'Cargos ExtraOrdinarios');
INSERT INTO `cat_tipodescuento` VALUES (4, 'Cargos Semanales');
INSERT INTO `cat_tipodescuento` VALUES (5, 'Capital');

-- ----------------------------
-- Table structure for catestatuscuenta
-- ----------------------------
DROP TABLE IF EXISTS `catestatuscuenta`;
CREATE TABLE `catestatuscuenta`  (
  `IdEstatusCuenta` int(3) NULL DEFAULT NULL,
  `EstatusCuenta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of catestatuscuenta
-- ----------------------------
INSERT INTO `catestatuscuenta` VALUES (0, 'ACTIVO');
INSERT INTO `catestatuscuenta` VALUES (1, 'CANCELADO');
INSERT INTO `catestatuscuenta` VALUES (2, 'PAGADO');

-- ----------------------------
-- Table structure for clientes
-- ----------------------------
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes`  (
  `curp` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `IFE` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `domicilio` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `municipio` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `sexo` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `estudios` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `correo` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `redsocial` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fechadenacimiento` date NOT NULL,
  `domicilio_referencia` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `estadocivil` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ref1_nombre` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ref1_tel` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ref1_domicilio` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ref2_nombre` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ref2_domicilio` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ref2_tel` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `profesion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `trabajo_nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `trabajo_domicilio` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `trabajo_telefono` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `trabajo_giro` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `trabajo_puesto` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `trabajo_salario` decimal(10, 0) NOT NULL,
  `fiscal_rfc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fiscal_domicilio` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `socio_dependen` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `socio_hijos` int(11) NOT NULL,
  `socio_casapropia` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `minegocio_nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `minegocio_propio` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `minegocio_ingresos` decimal(10, 0) NOT NULL,
  `minegocio_giro` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `minegocio_telefono` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `minegocio_empleados` int(11) NOT NULL,
  `grupo_cargo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `distri` decimal(10, 2) NOT NULL,
  `ref1_antiguedad` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ref2_antiguedad` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ref3_nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ref3_domicilio` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ref3_tel` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ref3_antiguedad` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `minegocio_domicilio` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `trabajo_antiguedad` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `minegocio_sueldos` decimal(10, 2) NOT NULL,
  `minegocio_antiguedad` int(11) NOT NULL,
  `refc1_nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `refc1_tel` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `refc1_domicilio` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `refc1_antiguedad` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `refc2_nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `refc2_tel` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `refc2_domicilio` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `refc2_antiguedad` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `refc3_nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `refc3_tel` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `refc3_domicilio` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `refc3_antiguedad` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `socio_hogar` decimal(10, 2) NOT NULL,
  `socio_renta` decimal(10, 2) NOT NULL,
  `socio_drenaje` decimal(10, 2) NOT NULL,
  `socio_agualuz` decimal(10, 2) NOT NULL,
  `socio_pisos` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `socio_cuartos` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `socio_wc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `socio_material` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `socio_buro` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fiscal_edo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `SOCIO` int(11) NOT NULL,
  `socio_cocina` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `act_fecha` date NOT NULL,
  `act_user` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `act_hora` time(6) NOT NULL,
  `IdSucursal` int(2) NOT NULL,
  `IdGrupo` int(10) NOT NULL,
  PRIMARY KEY (`curp`) USING BTREE,
  INDEX `curp`(`curp`, `nombre`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of clientes
-- ----------------------------
INSERT INTO `clientes` VALUES ('curp-aldama', 'cliente apellido apellido2', 'xxxifexxx', 'el domicilio', 'aldama', '8343088602', 'hombre', '', 'correo@electronico.com', '', '2022-03-09', '', 'SOLTERO', '', '', '', '', '', '', 'tamaulipas', '', 'ingeniero', '', '', '', '', '', 0, '', '', '', 0, 'NO', '', 'NO', 0, '', '', 0, 'PRESIDENTE', 0.00, '', '', '', '', '', '', '', '', 0.00, 0, '', '', '', '', '', '', '', '', '', '', '', '', 0.00, 0.00, 0.00, 0.00, '', '', '', '', '', '', 0, '', '2022-03-20', 'admin', '16:05:41.000000', 0, 281);
INSERT INTO `clientes` VALUES ('xxx', 'juan perez hernandez', '89383847|', 'domicilio', 'aldama', '88757564', 'hombre', '', 'printepolis@gmail.com', '', '2022-03-24', '', 'SOLTERO', '', '', '', '', '', '', 'tamaulipas', '', 'profesorx', '', '', '', '', '', 0, '', '', '', 0, 'NO', '', 'NO', 0, '', '', 0, 'TESORERO', 0.00, '', '', '', '', '', '', '', '', 0.00, 0, '', '', '', '', '', '', '', '', '', '', '', '', 0.00, 0.00, 0.00, 0.00, '', '', '', '', '', '', 0, '', '2011-05-11', 'admin', '09:18:33.000000', 0, 281);

-- ----------------------------
-- Table structure for colorines
-- ----------------------------
DROP TABLE IF EXISTS `colorines`;
CREATE TABLE `colorines`  (
  `IdColor` int(11) NOT NULL,
  `ColorName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `WebName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `hex` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL COMMENT 'Valor Hexadecimal',
  `rgb` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL COMMENT 'Valor RGB',
  PRIMARY KEY (`IdColor`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of colorines
-- ----------------------------
INSERT INTO `colorines` VALUES (1, 'Rojo Indio', 'IndianRed', '#CD5C5C', '205, 92, 205');
INSERT INTO `colorines` VALUES (2, 'Coral Suave', 'LightCoral', '#F08080', '240, 128, 128');
INSERT INTO `colorines` VALUES (3, 'Salmón', 'Salmon', '#FA8072', '250, 128, 114');
INSERT INTO `colorines` VALUES (4, 'Salmón oscuro', 'DarkSalmon', '#E9967A', '233, 150, 122');
INSERT INTO `colorines` VALUES (5, 'Salmón Suave', 'LightSalmon', '#FFA07A', '255, 160, 122');
INSERT INTO `colorines` VALUES (6, 'Carmesí', 'Crimson', '#DC143C', '220, 20, 60');
INSERT INTO `colorines` VALUES (7, 'Rojo Puro', 'Red', '#FF0000', '255, 0, 0');
INSERT INTO `colorines` VALUES (8, 'Rojo Fuego', 'FireBrick', '#B22222', '178, 34, 34');
INSERT INTO `colorines` VALUES (9, 'Rojo Oscuro', 'DarkRed', '#8B0000', '139, 0, 0');
INSERT INTO `colorines` VALUES (10, 'Rosa', 'Pink', '#FFC0CB', '255, 192, 203');
INSERT INTO `colorines` VALUES (11, 'Rosa Suave', 'LightPink', '#FFB6C1', '255, 182, 193');
INSERT INTO `colorines` VALUES (12, 'Rosa Cálido', 'HotPink', '#FF69B4', '255, 105, 180');
INSERT INTO `colorines` VALUES (13, 'Rosa Profundo', 'DeepPink', '#FF1493', '255, 20, 147');
INSERT INTO `colorines` VALUES (14, 'Medio Violeta Rojo', 'MediumVioletRed', '#C71585', '199, 21, 133');
INSERT INTO `colorines` VALUES (15, 'Rosa Pastel', 'PaleVioletRed', '#DB7093', '219, 112, 147');
INSERT INTO `colorines` VALUES (16, 'Salmón Suave', 'LightSalmon', '#FFA07A', '255, 160, 122');
INSERT INTO `colorines` VALUES (17, 'Naranja Coral', 'Coral', '#FF7F50', '255, 127, 80');
INSERT INTO `colorines` VALUES (18, 'Tomate', 'Tomato', '#FF6347', '255, 99, 71');
INSERT INTO `colorines` VALUES (19, 'Naranja Rojizo', 'OrangeRed', '#FF4500', '255, 69, 0');
INSERT INTO `colorines` VALUES (20, 'Naranja Oscuro', 'DarkOrange', '#FF8C00', '255, 140, 0');
INSERT INTO `colorines` VALUES (21, 'Naranja Puro', 'Orange', '#FFA500', '255, 165, 0');
INSERT INTO `colorines` VALUES (22, 'Amarillo Oro', 'Gold', '#FFD700', '255, 215, 0');
INSERT INTO `colorines` VALUES (23, 'Amarillo Puro', 'Yellow', '#FFFF00', '255, 255, 0');
INSERT INTO `colorines` VALUES (24, 'Amarillo Suave', 'LightYellow', '#FFFFE0', '255, 255, 224');
INSERT INTO `colorines` VALUES (25, 'Amarillo Limón', 'LemonChiffon', '#FFFACD', '255, 250, 205');
INSERT INTO `colorines` VALUES (26, 'Amarillo Manzana Suave', 'LightGoldenrodYellow', '#FAFAD2', '250, 250, 210');
INSERT INTO `colorines` VALUES (27, 'Amarillo Papaya', 'PapayaWhip', '#FFEFD5', '255, 239, 213');
INSERT INTO `colorines` VALUES (28, 'Amarillo Mocasín', 'Moccasin', '#FFE4B5', '255, 228, 181');
INSERT INTO `colorines` VALUES (29, 'Amarillo Melocotón', 'PeachPuff', '#FFDAB9', '255, 218, 185');
INSERT INTO `colorines` VALUES (30, 'Amarillo Oro Pálido', 'PaleGoldenrod', '#EEE8AA', '238, 232, 170');
INSERT INTO `colorines` VALUES (31, 'Amarillo Caqui', 'Khaki', '#F0E68C', '240, 230, 140');
INSERT INTO `colorines` VALUES (32, 'Amarillo Caqui Oscuro', 'DarkKhaki', '#BDB76B', '189, 183, 107');
INSERT INTO `colorines` VALUES (33, 'Espliego', 'Lavender', '#E6E6FA', '230, 230, 250');
INSERT INTO `colorines` VALUES (34, 'Cardo', 'Thistle', '#D8BFD8', '216, 191, 216');
INSERT INTO `colorines` VALUES (35, 'Ciruela', 'Plum', '#DDA0DD', '221, 160, 221');
INSERT INTO `colorines` VALUES (36, 'Violeta', 'Violet', '#EE82EE', '238, 130, 238');
INSERT INTO `colorines` VALUES (37, 'Orquídea', 'Orchid', '#DA70D6', '218, 112, 214');
INSERT INTO `colorines` VALUES (38, 'Fucsia', 'Fuchsia', '#FF00FF', '255, 0, 255');
INSERT INTO `colorines` VALUES (39, 'Magenta', 'Magenta', '#FF00FF', '255, 0, 255');
INSERT INTO `colorines` VALUES (40, 'Orquídea Medio', 'MediumOrchid', '#BA55D3', '186, 85, 211');
INSERT INTO `colorines` VALUES (41, 'Púrpura Medio', 'MediumPurple', '#9370DB', '147, 112, 219');
INSERT INTO `colorines` VALUES (42, 'Amatista', 'Amethyst', '#9966CC', '153, 102, 204');
INSERT INTO `colorines` VALUES (43, 'Azul Violeta', 'BlueViolet', '#8A2BE2', '138, 43, 226');
INSERT INTO `colorines` VALUES (44, 'Violeta Oscuro', 'DarkViolet', '#9400D3', '148, 0, 211');
INSERT INTO `colorines` VALUES (45, 'Orquídea Oscuro', 'DarkOrchid', '#9932CC', '153, 50, 204');
INSERT INTO `colorines` VALUES (46, 'Magenta Oscuro', 'DarkMagenta', '#8B008B', '139, 0, 139');
INSERT INTO `colorines` VALUES (47, 'Púrpura', 'Purple', '#800080', '128, 0, 128');
INSERT INTO `colorines` VALUES (48, 'Índigo', 'Indigo', '#4B0082', '75, 0, 130');
INSERT INTO `colorines` VALUES (49, 'Azul Pizarra', 'SlateBlue', '#6A5ACD', '106, 90, 205');
INSERT INTO `colorines` VALUES (50, 'Azul Pizarra Medio', 'MediumSlateBlue', '#7B68EE', '123, 104, 238');
INSERT INTO `colorines` VALUES (51, 'Azul Pizarra Oscuro', 'DarkSlateBlue', '#483D8B', '72, 61, 139');
INSERT INTO `colorines` VALUES (52, 'Verde Amarillento', 'GreenYellow', '#ADFF2F', '173, 255, 47');
INSERT INTO `colorines` VALUES (53, 'Verde Cartujano', 'Chartreuse', '#7FFF00', '127, 255, 0');
INSERT INTO `colorines` VALUES (54, 'Verde Césped', 'LawnGreen', '#7CFC00', '124, 253, 0');
INSERT INTO `colorines` VALUES (55, 'Lima', 'Lime', '#00FF00', '0, 255, 0');
INSERT INTO `colorines` VALUES (56, 'Verde Lima', 'LimeGreen', '#32CD32', '50, 205, 50');
INSERT INTO `colorines` VALUES (57, 'Verde Pálido', 'PaleGreen', '#98FB98', '152, 251, 152');
INSERT INTO `colorines` VALUES (58, 'Verde Claro', 'LightGreen', '#90EE90', '144, 238, 144');
INSERT INTO `colorines` VALUES (59, 'Verde Primavera Medio', 'MediumSpringGreen', '#00FA9A', '0, 250, 154');
INSERT INTO `colorines` VALUES (60, 'Verde Primavera', 'SpringGreen', '#00FF7F', '0, 255, 127');
INSERT INTO `colorines` VALUES (61, 'Verde Mar Medio', 'MediumSeaGreen', '#3CB371', '60, 179, 113');
INSERT INTO `colorines` VALUES (62, 'Verde Mar', 'SeaGreen', '#2E8B57', '46, 139, 87');
INSERT INTO `colorines` VALUES (63, 'Verde Bosque', 'ForestGreen', '#228B22', '34, 139, 34');
INSERT INTO `colorines` VALUES (64, 'Verde', 'Green', '#008000', '0, 128, 0');
INSERT INTO `colorines` VALUES (65, 'Verde Oscuro', 'DarkGreen', '#006400', '0, 100, 0');
INSERT INTO `colorines` VALUES (66, 'Amarillo Verdoso', 'YellowGreen', '#9ACD32', '154, 205, 50');
INSERT INTO `colorines` VALUES (67, 'Verde Oliva', 'OliveDrab', '#6B8E23', '107, 142, 35');
INSERT INTO `colorines` VALUES (68, 'Oliva', 'Olive', '#808000', '128, 128, 0');
INSERT INTO `colorines` VALUES (69, 'Verde Oliva Oscuro', 'DarkOliveGreen', '#556B2F', '85, 107, 47');
INSERT INTO `colorines` VALUES (70, 'Aguamarina Medio', 'MediumAquamarine', '#66CDAA', '102, 205, 170');
INSERT INTO `colorines` VALUES (71, 'Verde Mar Oscuro', 'DarkSeaGreen', '#8FBC8F', '143, 188, 143');
INSERT INTO `colorines` VALUES (72, 'Verde Mar Claro', 'LightSeaGreen', '#20B2AA', '32, 178, 170');
INSERT INTO `colorines` VALUES (73, 'Cyan Oscuro', 'DarkCyan', '#008B8B', '0, 139, 139');
INSERT INTO `colorines` VALUES (74, 'Carcel', 'Teal', '#008080', '0, 128, 128');
INSERT INTO `colorines` VALUES (75, 'Agua', 'Aqua', '#00FFFF', '0, 255, 255');
INSERT INTO `colorines` VALUES (76, 'Cyan', 'Cyan', '#00FFFF', '0, 255, 255');
INSERT INTO `colorines` VALUES (77, 'Cyan Suave', 'LightCyan', '#E0FFFF', '224, 255, 255');
INSERT INTO `colorines` VALUES (78, 'Turquesa Pastel', 'PaleTurquoise', '#AFEEEE', '175, 238, 238');
INSERT INTO `colorines` VALUES (79, 'Aguamarina', 'Aquamarine', '#7FFFD4', '127, 255, 212');
INSERT INTO `colorines` VALUES (80, 'Turquesa', 'Turquoise', '#40E0D0', '64, 224, 208');
INSERT INTO `colorines` VALUES (81, 'Turquesa Medio', 'MediumTurquoise', '#48D1CC', '72, 209, 204');
INSERT INTO `colorines` VALUES (82, 'Turquesa Oscuro', 'DarkTurquoise', '#00CED1', '0, 206, 209');
INSERT INTO `colorines` VALUES (83, 'Azul Cadete', 'CadetBlue', '#5F9EA0', '95, 158, 160');
INSERT INTO `colorines` VALUES (84, 'Azul Acero', 'SteelBlue', '#4682B4', '70, 130, 180');
INSERT INTO `colorines` VALUES (85, 'Azul Acero Claro', 'LightSteelBlue', '#B0C4DE', '176, 196, 222');
INSERT INTO `colorines` VALUES (86, 'Azul Pálido', 'PowderBlue', '#B0E0E6', '176, 224, 230');
INSERT INTO `colorines` VALUES (87, 'Azul Claro', 'LightBlue', '#ADD8E6', '173, 216, 230');
INSERT INTO `colorines` VALUES (88, 'Azul Cielo', 'SkyBlue', '#87CEEB', '135, 206, 235');
INSERT INTO `colorines` VALUES (89, 'Azul Cielo Claro', 'LightSkyBlue', '#87CEFA', '135, 206, 250');
INSERT INTO `colorines` VALUES (90, 'Azul Cielo Profundo', 'DeepSkyBlue', '#00BFFF', '0, 191, 255');
INSERT INTO `colorines` VALUES (91, 'Azul Capota', 'DodgerBlue', '#1E90FF', '30, 144, 255');
INSERT INTO `colorines` VALUES (92, 'Azul Añil', 'CornflowerBlue', '#6495ED', '100, 149, 237');
INSERT INTO `colorines` VALUES (93, 'Azul Pizarra Medio', 'MediumSlateBlue', '#7B68EE', '123, 104, 238');
INSERT INTO `colorines` VALUES (94, 'Azul Real', 'RoyalBlue', '#4169E1', '65, 105, 255');
INSERT INTO `colorines` VALUES (95, 'Azul', 'Blue', '#0000FF', '0, 0, 255');
INSERT INTO `colorines` VALUES (96, 'Azul Medio', 'MediumBlue', '#0000CD', '0, 0, 205');
INSERT INTO `colorines` VALUES (97, 'Azul Oscuro', 'DarkBlue', '#00008B', '0, 0, 139');
INSERT INTO `colorines` VALUES (98, 'Azul Naval', 'Navy', '#000080', '0, 0, 128');
INSERT INTO `colorines` VALUES (99, 'Azul Media Noche', 'MidnightBlue', '#191970', '25, 25, 112');
INSERT INTO `colorines` VALUES (100, 'Seda de Maiz', 'Cornsilk', '#FFF8DC', '255, 248, 220');
INSERT INTO `colorines` VALUES (101, 'Almendra', 'BlanchedAlmond', '#FFEBCD', '255, 235, 205');
INSERT INTO `colorines` VALUES (102, 'Bizcocho', 'Bisque', '#FFE4C4', '255, 228, 196');
INSERT INTO `colorines` VALUES (103, 'Marrón Navaja', 'NavajoWhite', '#FFDEAD', '255, 222, 173');
INSERT INTO `colorines` VALUES (104, 'Marrón Trigo', 'Wheat', '#F5DEB3', '245, 222, 179');
INSERT INTO `colorines` VALUES (105, 'Madera Fuerte', 'BurlyWood', '#DEB887', '222, 184, 135');
INSERT INTO `colorines` VALUES (106, 'Marrón bronceado', 'Tan', '#D2B48C', '210, 180, 140');
INSERT INTO `colorines` VALUES (107, 'Marrón Atractivo', 'RosyBrown', '#BC8F8F', '188, 143, 143');
INSERT INTO `colorines` VALUES (108, 'Marrón Arenoso', 'SandyBrown', '#F4A460', '224, 164, 96');
INSERT INTO `colorines` VALUES (109, 'Vara de Oro', 'Goldenrod', '#DAA520', '218, 165, 32');
INSERT INTO `colorines` VALUES (110, 'Vara de Oro Oscura', 'DarkGoldenrod', '#B8860B', '184, 134, 11');
INSERT INTO `colorines` VALUES (111, 'Marrón Perú', 'Peru', '#CD853F', '205, 133, 63');
INSERT INTO `colorines` VALUES (112, 'Marrón Chocolate', 'Chocolate', '#D2691E', '210, 105, 30');
INSERT INTO `colorines` VALUES (113, 'Marrón Silla', 'SaddleBrown', '#8B4513', '139, 69, 19');
INSERT INTO `colorines` VALUES (114, 'Marrón Siena', 'Sienna', '#A0522D', '160, 82, 45');
INSERT INTO `colorines` VALUES (115, 'Marrón', 'Brown', '#A52A2A', '165, 42, 42');
INSERT INTO `colorines` VALUES (116, 'Castaño', 'Maroon', '#800000', '128, 0, 0');
INSERT INTO `colorines` VALUES (117, 'Miel Crema', 'Honeydew', '#F0FFF0', '240, 255, 240');
INSERT INTO `colorines` VALUES (118, 'Menta Crema', 'MintCream', '#F5FFFA', '245, 255, 250');
INSERT INTO `colorines` VALUES (119, 'Azul Celeste', 'Azure', '#F0FFFF', '240, 255, 255');
INSERT INTO `colorines` VALUES (120, 'Azul Alicia', 'AliceBlue', '#F0F8FF', '240, 248, 255');
INSERT INTO `colorines` VALUES (121, 'Blanco Fantasma', 'GhostWhite', '#F8F8FF', '248, 248, 255');
INSERT INTO `colorines` VALUES (122, 'Blanco Humo', 'WhiteSmoke', '#F5F5F5', '245, 245, 245');
INSERT INTO `colorines` VALUES (123, 'Concha de Mar', 'Seashell', '#FFF5EE', '255, 245, 238');
INSERT INTO `colorines` VALUES (124, 'Beige', 'Beige', '#F5F5DC', '245, 245, 220');
INSERT INTO `colorines` VALUES (125, 'Blanco Cordón Viejo', 'OldLace', '#FDF5E6', '253, 245, 230');
INSERT INTO `colorines` VALUES (126, 'Blanco Floral', 'FloralWhite', '#FFFAF0', '255, 250, 240');
INSERT INTO `colorines` VALUES (127, 'Blanco Marfil', 'Ivory', '#FFFFF0', '255, 255, 240');
INSERT INTO `colorines` VALUES (128, 'Blanco Antigüo', 'AntiqueWhite', '#FAEBD7', '250, 235, 215');
INSERT INTO `colorines` VALUES (129, 'Blanco Lino', 'Linen', '#FAF0E6', '250, 240, 230');
INSERT INTO `colorines` VALUES (130, 'Lavanda', 'LavenderBlush', '#FFF0F5', '255, 240, 245');
INSERT INTO `colorines` VALUES (131, 'Rosa Palo', 'MistyRose', '#FFE4E1', '255, 228, 225');
INSERT INTO `colorines` VALUES (132, 'Gainsboro', 'Gainsboro', '#DCDCDC', '220, 220, 220');
INSERT INTO `colorines` VALUES (133, 'Gris Claro', 'LightGrey', '#D3D3D3', '211, 211, 211');
INSERT INTO `colorines` VALUES (134, 'Gris Plata', 'Silver', '#C0C0C0', '192, 192, 192');
INSERT INTO `colorines` VALUES (135, 'Gris Oscuro', 'DarkGray', '#A9A9A9', '169, 169, 169');
INSERT INTO `colorines` VALUES (136, 'Gris', 'Gray', '#808080', '128, 128, 128');
INSERT INTO `colorines` VALUES (137, 'Gris Ténue', 'DimGray', '#696969', '105, 105, 105');
INSERT INTO `colorines` VALUES (138, 'Gris Pizarra Claro', 'LightSlateGray', '#778899', '119, 136, 153');
INSERT INTO `colorines` VALUES (139, 'Gris Pizarra', 'SlateGray', '#708090', '112, 128, 144');
INSERT INTO `colorines` VALUES (140, 'Gris Pizarra Oscuro', 'DarkSlateGray', '#2F4F4F', '47, 79, 79');

-- ----------------------------
-- Table structure for corte
-- ----------------------------
DROP TABLE IF EXISTS `corte`;
CREATE TABLE `corte`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `comentario` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `valor` decimal(10, 2) NOT NULL,
  `usuario` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nosol` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ahorro` decimal(10, 2) NOT NULL,
  `capital` decimal(10, 2) NOT NULL,
  `interes` decimal(10, 2) NOT NULL,
  `impuesto` decimal(10, 2) NOT NULL,
  `moratorio` decimal(10, 2) NOT NULL,
  `extras` decimal(10, 2) NOT NULL,
  `cargosemanal` decimal(10, 2) NOT NULL,
  `ahorro_retiro` decimal(10, 2) NOT NULL,
  `IdSucursal` int(2) NOT NULL,
  `cargoseguro` decimal(10, 2) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `nosol`(`nosol`, `no`) USING BTREE,
  INDEX `id`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 37005 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for croquis
-- ----------------------------
DROP TABLE IF EXISTS `croquis`;
CREATE TABLE `croquis`  (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `anchura` smallint(6) NOT NULL,
  `altura` smallint(6) NOT NULL,
  `tipo` char(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `imagen` mediumblob NOT NULL,
  `curp` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cuentas
-- ----------------------------
DROP TABLE IF EXISTS `cuentas`;
CREATE TABLE `cuentas`  (
  `nosol` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `IdSucursal` int(2) NOT NULL,
  `n` int(5) NOT NULL,
  `elector` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `curp` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `cantidad` decimal(10, 0) NOT NULL,
  `destino` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `plazo` int(11) NOT NULL,
  `formadepago` decimal(10, 0) NOT NULL,
  `garantia` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `valoracion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fechasol` date NOT NULL,
  `tipo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `aval_curp` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `aval_nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `aval_curp2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `aval_nombre2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `iva_tipo` decimal(10, 0) NOT NULL,
  `cuenta_interna` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `tasa_interes` decimal(10, 2) NOT NULL,
  `tasa_moratorio` decimal(10, 2) NOT NULL,
  `grupo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `grupo_cargo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `integrantes` int(11) NOT NULL,
  `cargo` decimal(10, 2) NOT NULL,
  `vencimientofinal` date NOT NULL,
  `fechacontrato` date NOT NULL,
  `cargoporsemana` decimal(10, 2) NOT NULL,
  `comentario` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `IdEstatus` int(1) NOT NULL,
  `fechainicio` date NOT NULL,
  `IdGrupo` int(6) NOT NULL,
  `IdSeguro` int(10) NOT NULL,
  `CargoSeguro` decimal(10, 2) NOT NULL,
  PRIMARY KEY (`nosol`) USING BTREE,
  INDEX `curp`(`curp`) USING BTREE,
  INDEX `no`(`nosol`) USING BTREE,
  INDEX `curp_2`(`curp`, `nosol`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cuentas
-- ----------------------------
INSERT INTO `cuentas` VALUES ('20110511000001', 0, 0, '', 'curp-aldama', 0, '', 0, 0, '', '', '2011-05-11', 'GRUPAL', '', '', '', '', 0, '', 0.00, 0.00, '', '', 0, 0.00, '0000-00-00', '0000-00-00', 0.00, '', 0, '0000-00-00', 281, 0, 0.00);

-- ----------------------------
-- Table structure for descuetos
-- ----------------------------
DROP TABLE IF EXISTS `descuetos`;
CREATE TABLE `descuetos`  (
  `nosol` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `no` int(11) NOT NULL,
  `concepto` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `cantidad` decimal(10, 2) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `act_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `act_fecha` date NOT NULL,
  `act_hora` time(6) NOT NULL,
  `IdTipoDescuento` int(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `nosol`(`nosol`, `no`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3459 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for distribuciones
-- ----------------------------
DROP TABLE IF EXISTS `distribuciones`;
CREATE TABLE `distribuciones`  (
  `nosol` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `cantidad` decimal(10, 2) NOT NULL,
  `curp` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for empleados
-- ----------------------------
DROP TABLE IF EXISTS `empleados`;
CREATE TABLE `empleados`  (
  `secc` int(3) NULL DEFAULT NULL,
  `nuc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `sap` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NULL DEFAULT NULL,
  `nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NULL DEFAULT NULL,
  `direccion` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NULL DEFAULT NULL,
  `departamento` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NULL DEFAULT NULL,
  `puesto` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NULL DEFAULT NULL,
  `nivel` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NULL DEFAULT NULL,
  `ciudad` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NULL DEFAULT NULL,
  `nip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NULL DEFAULT NULL,
  `fecha_nacimiento` date NULL DEFAULT NULL,
  `correoelectronico` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono_movil` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `historia` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `prefijo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono_extension` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono2` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `profesion_abr` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `profesion` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `control_asistencia` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `domicilio_calle` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `domicilio_num_ext` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NULL DEFAULT NULL,
  `domicilio_num_int` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NULL DEFAULT NULL,
  `domicilio_entrecalles` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `domicilio_ciudad` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NULL DEFAULT NULL,
  `domicilio_colonia` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NULL DEFAULT NULL,
  `domicilio_cp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NULL DEFAULT NULL,
  `estadocivil` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NULL DEFAULT NULL,
  `dpto` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `sexo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `comida` time(0) NOT NULL,
  `horario_entrada` time(0) NOT NULL,
  `horario_salida` time(0) NOT NULL,
  PRIMARY KEY (`nuc`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of empleados
-- ----------------------------
INSERT INTO `empleados` VALUES (NULL, '119460', NULL, 'JUAN JOSE PEDRAZA PERALES', NULL, NULL, NULL, NULL, NULL, '119460', NULL, '', '', '', '', '', '', '', '', '', '', '', NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', '00:00:00', '00:00:00', '00:00:00');
INSERT INTO `empleados` VALUES (NULL, 'admin', NULL, 'Edgar Treviño Sosa', NULL, 'Gerecia', 'Gerente', NULL, NULL, 'admin', NULL, '', '', '', '', '', '', '', '', '', '', '', NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', '00:00:00', '00:00:00', '00:00:00');
INSERT INTO `empleados` VALUES (NULL, 'cajero', NULL, 'Nombre de Caja', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '', NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', '00:00:00', '00:00:00', '00:00:00');

-- ----------------------------
-- Table structure for empresas
-- ----------------------------
DROP TABLE IF EXISTS `empresas`;
CREATE TABLE `empresas`  (
  `rfc` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `propietario` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `domicilio` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `municipio` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for extraordinarios
-- ----------------------------
DROP TABLE IF EXISTS `extraordinarios`;
CREATE TABLE `extraordinarios`  (
  `nosol` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `no` int(11) NOT NULL,
  `concepto` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `cantidad` decimal(10, 2) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `a` int(11) NOT NULL AUTO_INCREMENT,
  `act_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`a`) USING BTREE,
  INDEX `nosol`(`nosol`, `no`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1826 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fotos
-- ----------------------------
DROP TABLE IF EXISTS `fotos`;
CREATE TABLE `fotos`  (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `anchura` smallint(6) NOT NULL,
  `altura` smallint(6) NOT NULL,
  `tipo` char(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `imagen` mediumblob NOT NULL,
  `curp` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 44 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for garantia
-- ----------------------------
DROP TABLE IF EXISTS `garantia`;
CREATE TABLE `garantia`  (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `anchura` smallint(6) NOT NULL,
  `altura` smallint(6) NOT NULL,
  `tipo` char(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `imagen` mediumblob NOT NULL,
  `curp` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nosol` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for garantia2
-- ----------------------------
DROP TABLE IF EXISTS `garantia2`;
CREATE TABLE `garantia2`  (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `anchura` smallint(6) NOT NULL,
  `altura` smallint(6) NOT NULL,
  `tipo` char(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `imagen` mediumblob NOT NULL,
  `curp` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nosol` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for garantia3
-- ----------------------------
DROP TABLE IF EXISTS `garantia3`;
CREATE TABLE `garantia3`  (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `anchura` smallint(6) NOT NULL,
  `altura` smallint(6) NOT NULL,
  `tipo` char(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `imagen` mediumblob NOT NULL,
  `curp` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nosol` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for grupos
-- ----------------------------
DROP TABLE IF EXISTS `grupos`;
CREATE TABLE `grupos`  (
  `Grupo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `IdGrupo` int(11) NOT NULL AUTO_INCREMENT,
  `IdSucursal` int(3) NOT NULL,
  PRIMARY KEY (`IdGrupo`) USING BTREE,
  INDEX `nombre`(`Grupo`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 283 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of grupos
-- ----------------------------
INSERT INTO `grupos` VALUES ('x', 272, 0);
INSERT INTO `grupos` VALUES ('s', 273, 0);
INSERT INTO `grupos` VALUES ('21', 274, 0);
INSERT INTO `grupos` VALUES ('invasores', 275, 0);
INSERT INTO `grupos` VALUES ('Invansores de gonzalez', 276, 0);
INSERT INTO `grupos` VALUES ('h', 277, 0);
INSERT INTO `grupos` VALUES ('h', 278, 0);
INSERT INTO `grupos` VALUES ('g4', 281, 3);
INSERT INTO `grupos` VALUES ('g5', 282, 3);

-- ----------------------------
-- Table structure for historia
-- ----------------------------
DROP TABLE IF EXISTS `historia`;
CREATE TABLE `historia`  (
  `nitavu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 391156 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for historial_contrato
-- ----------------------------
DROP TABLE IF EXISTS `historial_contrato`;
CREATE TABLE `historial_contrato`  (
  `curp` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nosol` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `idgrupo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `grupo_cargo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time(6) NOT NULL,
  `iduser` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `idsucursal` int(3) NOT NULL,
  PRIMARY KEY (`curp`, `nosol`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of historial_contrato
-- ----------------------------
INSERT INTO `historial_contrato` VALUES ('curp-aldama', '20110511000001', '281', 'PRESIDENTE', '2011-05-11', '09:44:57.000000', 'admin', 0);
INSERT INTO `historial_contrato` VALUES ('xxx', '20110511000001', '281', 'TESORERO', '2011-05-11', '09:44:57.000000', 'admin', 0);

-- ----------------------------
-- Table structure for notificaciones
-- ----------------------------
DROP TABLE IF EXISTS `notificaciones`;
CREATE TABLE `notificaciones`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nuc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `grupal` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `asunto` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `entregar_fecha` date NOT NULL,
  `lectura_fecha` date NOT NULL,
  `lectura_hora` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nitavu_manda` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `contenido` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `pie` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `firma_img` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `docdigital` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `no_oficio` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `prefijo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pagos
-- ----------------------------
DROP TABLE IF EXISTS `pagos`;
CREATE TABLE `pagos`  (
  `curp` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nosol` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `capital` decimal(10, 0) NOT NULL,
  `int` decimal(10, 0) NOT NULL,
  `iva` decimal(10, 0) NOT NULL,
  `vencimiento` date NOT NULL,
  `no` int(11) NOT NULL,
  `comentario` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for personal
-- ----------------------------
DROP TABLE IF EXISTS `personal`;
CREATE TABLE `personal`  (
  `idp` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `personal_nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL COMMENT 'personal nombre',
  `personal_edad` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL COMMENT 'personal edad',
  `personal_salario` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL COMMENT 'personal salario',
  `fecha` date NOT NULL DEFAULT '2020-12-14',
  PRIMARY KEY (`idp`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 64 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci COMMENT = 'tabla personal' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for rel_a
-- ----------------------------
DROP TABLE IF EXISTS `rel_a`;
CREATE TABLE `rel_a`  (
  `x` int(11) NULL DEFAULT NULL,
  `y` int(11) NULL DEFAULT NULL,
  INDEX `x`(`x`, `y`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rel_a
-- ----------------------------
INSERT INTO `rel_a` VALUES (7, 4);
INSERT INTO `rel_a` VALUES (15, 2);
INSERT INTO `rel_a` VALUES (30, 1);

-- ----------------------------
-- Table structure for saldos
-- ----------------------------
DROP TABLE IF EXISTS `saldos`;
CREATE TABLE `saldos`  (
  `CURP` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `Cliente` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `grupo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `abono_pactado` decimal(10, 2) NOT NULL,
  `interes_pactado` decimal(10, 2) NOT NULL,
  `iva_pactado` decimal(10, 2) NOT NULL,
  `nosol` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `NPago` int(4) NOT NULL,
  `abono` decimal(10, 2) NOT NULL,
  `interes` decimal(10, 2) NOT NULL,
  `iva` decimal(10, 2) NOT NULL,
  `mora_dias` decimal(10, 2) NOT NULL,
  `formadepago` int(3) NOT NULL,
  `formadepago_tipo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `mora_tasa` decimal(10, 2) NOT NULL,
  `mora_multiplo` decimal(10, 2) NOT NULL,
  `mora_dia` decimal(10, 2) NOT NULL,
  `mora_debe` decimal(10, 2) NOT NULL,
  `Semanas` int(5) NOT NULL,
  `CargoSemana` decimal(10, 2) NOT NULL,
  `CargoSemanal` decimal(10, 2) NOT NULL,
  `CargoExtraOrdinario_concepto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `CargoExtraOrdinario_cantidad` decimal(10, 2) NOT NULL,
  `subTOTAL` decimal(10, 2) NOT NULL,
  `Descuento_concepto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `Descuento_cantidad` decimal(10, 2) NOT NULL,
  `TOTAL` decimal(10, 2) NOT NULL,
  `TotalFormat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `EstadoPago` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `comentario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `CajaCantidad` decimal(10, 2) NOT NULL,
  `CajaAhorro` decimal(10, 2) NOT NULL,
  `CajaFecha` date NOT NULL,
  `CajaCapital` decimal(10, 2) NOT NULL,
  `CajaInteres` decimal(10, 2) NOT NULL,
  `CajaImpuesto` decimal(10, 2) NOT NULL,
  `CajaMoratorio` decimal(10, 2) NOT NULL,
  `CajaExtras` decimal(10, 2) NOT NULL,
  `CajaCargoSemanal` decimal(10, 2) NOT NULL,
  `CajaComentario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `Caja_Usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `IdRecibo` int(50) NOT NULL,
  `CarteraEstatus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `act_fecha` date NOT NULL,
  `act_hora` time(6) NOT NULL,
  INDEX `nosol`(`nosol`, `mora_debe`, `TOTAL`) USING BTREE,
  INDEX `abono_pactado`(`abono_pactado`) USING BTREE,
  INDEX `fecha`(`fecha`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for seguros_config
-- ----------------------------
DROP TABLE IF EXISTS `seguros_config`;
CREATE TABLE `seguros_config`  (
  `idseguro` int(10) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `cantidad_asegurada` decimal(10, 2) NOT NULL,
  `costo` decimal(10, 2) NOT NULL,
  `nmeses` int(3) NOT NULL,
  PRIMARY KEY (`idseguro`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of seguros_config
-- ----------------------------
INSERT INTO `seguros_config` VALUES (1, 'INBURSA', 5000.00, 100.00, 6);
INSERT INTO `seguros_config` VALUES (6, 'BANORTE', 6000.00, 600.00, 6);
INSERT INTO `seguros_config` VALUES (7, 'GNP', 4000.00, 100.00, 3);
INSERT INTO `seguros_config` VALUES (9, '', 0.00, 0.00, 0);

-- ----------------------------
-- Table structure for semanas
-- ----------------------------
DROP TABLE IF EXISTS `semanas`;
CREATE TABLE `semanas`  (
  `no` int(11) NOT NULL,
  `inicio` date NOT NULL,
  `fin` date NOT NULL,
  `anio` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 212 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sessiones
-- ----------------------------
DROP TABLE IF EXISTS `sessiones`;
CREATE TABLE `sessiones`  (
  `id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL COMMENT 'Id de Session php',
  `session_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL COMMENT 'nombre de la session',
  `parametros` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL COMMENT 'Parametros de la sesion',
  `usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL COMMENT 'Usuario que se logueo',
  `fecha` date NOT NULL COMMENT 'Fecha de session',
  `hora` time(6) NOT NULL COMMENT 'Hora de la session',
  `cierre_fecha` date NOT NULL COMMENT 'Fecha de cierre de sesion',
  `cierre_hora` time(6) NOT NULL COMMENT 'Hora de cierre de sesion',
  `comentarios` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `ipcliente` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL COMMENT 'Ip del Cliente, se guarda desde login',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sess1`(`fecha`) USING BTREE,
  INDEX `sess2`(`usuario`(250)) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sucursales
-- ----------------------------
DROP TABLE IF EXISTS `sucursales`;
CREATE TABLE `sucursales`  (
  `IdSucursal` int(1) NOT NULL,
  `Sucursal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NULL DEFAULT NULL,
  `representante` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sucursales
-- ----------------------------
INSERT INTO `sucursales` VALUES (1, 'Aldama, Tam.', 'Edgar Treviño Sosa');
INSERT INTO `sucursales` VALUES (2, 'Est. Manuel, Gonzalez, Tam.', 'Edgar Treviño Sosa');
INSERT INTO `sucursales` VALUES (3, 'Gonzalez, Tam.', 'Edgar Treviño Sosa');
INSERT INTO `sucursales` VALUES (0, 'Oficinas Centrales', 'Edgar Treviño Sosa');

-- ----------------------------
-- Table structure for tabladepagos
-- ----------------------------
DROP TABLE IF EXISTS `tabladepagos`;
CREATE TABLE `tabladepagos`  (
  `nosol` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `cuenta_interna` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `curp` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `no` int(11) NOT NULL,
  `fin` date NOT NULL,
  `abono` decimal(10, 2) NOT NULL,
  `interes` decimal(10, 2) NOT NULL,
  `iva` decimal(10, 2) NOT NULL,
  `cargoseguro` decimal(10, 2) NULL DEFAULT NULL,
  `comentario` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semana` int(11) NOT NULL,
  `inicio` date NOT NULL,
  `ahorro` decimal(10, 2) NOT NULL,
  `usuario` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `act_fecha` date NULL DEFAULT NULL,
  `act_hora` time(6) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sol`(`nosol`) USING BTREE,
  INDEX `curp`(`curp`) USING BTREE,
  INDEX `estado`(`estado`) USING BTREE,
  INDEX `inicio`(`inicio`) USING BTREE,
  INDEX `nosol`(`nosol`, `no`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 63469 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- View structure for avales
-- ----------------------------
DROP VIEW IF EXISTS `avales`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `avales` AS select 
c.curp,
UPPER(c.nombre) as nombre,
c.telefono,
CONCAT(c.domicilio,', ',municipio, '. ', c.estado) as domicilio,
(select count(DISTINCT nosol) from cartera  where EstadoPago='PAGADO' and CURP = c.curp) as CreditosPagados,
(select count(DISTINCT nosol) from cartera  where EstadoPago<>'PAGADO' and CURP = c.curp and mora_dias>0) as CreditosConAdeudo,
ifnull((select MAX(mora_dias) from cartera  where EstadoPago<>'PAGADO' and CURP = c.curp and mora_dias>0),0) as DiasDeRetraso


from clientes c ;

-- ----------------------------
-- View structure for cartera
-- ----------------------------
DROP VIEW IF EXISTS `cartera`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `cartera` AS SELECT	
	tblPagos.curp as CURP,	
	(select clientes.nombre from clientes where curp = tblPagos.curp) as Cliente,
	
	(select clientes.IdGrupo from clientes where clientes.curp = tblPagos.curp limit 1) as IdGrupo,
	(select Grupos.Grupo from grupos where IdGrupo = (select clientes.IdGrupo from clientes where clientes.curp = tblPagos.curp limit 1)) as grupo,
	
	tblPagos.abono as abono_pactado,
	tblPagos.interes as interes_pactado,
	tblPagos.iva as iva_pactado,	
	tblPagos.nosol as nosol,
	tblPagos.fin as fecha,
	tblPagos.no as NPago,	
	tblPagos.cargoseguro,
	
	
	 
(tblPagos.abono - (IF(tblPagos.estado <> 'X',ifnull((select sum(capital) from corte where nosol=tblPagos.nosol and no=tblPagos.no ),'0'),tblPagos.abono) + ifnull((select sum(cantidad) from descuetos where nosol=tblPagos.nosol and no=tblPagos.no and IdTipoDescuento=5),'0'))	 ) as abono,
	
	IF(tblPagos.estado <> 'X',ifnull((select sum(capital) from corte where nosol=tblPagos.nosol and no=tblPagos.no ),'0'),tblPagos.abono) 	
	 as CajaCapital,
	
	 
	 
	(tblPagos.interes - 
	(IF(tblPagos.estado <> 'X',ifnull((select sum(interes) from corte where nosol=tblPagos.nosol and no=tblPagos.no ),'0'),tblPagos.interes) 	+ ifnull((select sum(cantidad) from descuetos where nosol=tblPagos.nosol and no=tblPagos.no and IdTipoDescuento=2),'0') )
		
	) as interes,
	

	IF(tblPagos.estado <> 'X',ifnull((select sum(interes) from corte where nosol=tblPagos.nosol and no=tblPagos.no ),'0'),tblPagos.interes) 	
	as CajaInteres,


	(tblPagos.iva - 
		IF(tblPagos.estado <> 'X',ifnull((select sum(impuesto) from corte where nosol=tblPagos.nosol and no=tblPagos.no ),'0'),tblPagos.iva) 	
	) as iva,

	 IF(tblPagos.estado <> 'X',ifnull((select sum(impuesto) from corte where nosol=tblPagos.nosol and no=tblPagos.no ),'0'),tblPagos.iva) 	
	 as CajaImpuesto,
	
	IF(curdate() < tblPagos.fin, 	
		'0',		
		(SELECT DATEDIFF(CURDATE(),tblPagos.fin))
	) 	
	as mora_dias,
	
	(SELECT cuentas.formadepago from cuentas where nosol=tblPagos.nosol limit 1) as formadepago,
	
	(SELECT nombre from cat_formadepago where dias = (SELECT cuentas.formadepago from cuentas where nosol=tblPagos.nosol limit 1)) as formadepago_tipo,
	
	(SELECT cuentas.tasa_moratorio from cuentas where nosol=tblPagos.nosol limit 1) as mora_tasa,
	
	(SELECT rel_a.y from rel_a where x=formadepago limit 1) as mora_multiplo,
	
	IF(tblPagos.estado <> 'X',
		(FORMAT((SELECT ((((abono+interes+iva) * mora_multiplo)/100)*mora_tasa)/30),2)), 
	CONCAT(0))  as mora_dia,

	IF(curdate() < tblPagos.fin, 	
	'0',
		(IF(UPPER(tblPagos.estado) = 'X',
			'0', 
			
				(
					(SELECT mora_dia *  mora_dias) - 
					(
						(ifnull((select sum(cantidad) from descuetos where nosol=tblPagos.nosol and no=tblPagos.no and IdTipoDescuento=1),'0')) + 
						(ifnull((select sum(moratorio) from corte where nosol=tblPagos.nosol and no=tblPagos.no ),0) )
					)
				
				) 
			
		)
	)) as mora_debe,
	
	(SELECT round(mora_dias / 7) ) as Semanas,
	
	IF(tblPagos.estado <> 'X',(SELECT cuentas.cargoporsemana from cuentas where nosol = tblPagos.nosol limit 1),'0')  as CargoSemana,
	
	IF(curdate() < tblPagos.fin, 	
	'0',
		(IF(UPPER(tblPagos.estado) = 'X',
			'0', 
			((SELECT Semanas * CargoSemana) - (ifnull((select sum(cargosemanal) from corte where nosol=tblPagos.nosol and no=tblPagos.no),'0') + ifnull((select sum(cantidad) from descuetos where nosol=tblPagos.nosol and no=tblPagos.no and IdTipoDescuento=4),'0') ) )	
			))
	) 		
	as CargoSemanal, -- Cargo por semana retrasada
	
	ifnull((select concepto from extraordinarios where nosol=tblPagos.nosol and no=tblPagos.no limit 1),'') as CargoExtraOrdinario_concepto,
	
	(ifnull((select sum(cantidad) from extraordinarios where nosol=tblPagos.nosol and no=tblPagos.no ),'0')
- (ifnull((select sum(extras) from corte where nosol=tblPagos.nosol and no=tblPagos.no ),'0') + ifnull((select sum(cantidad) from descuetos where nosol=tblPagos.nosol and no=tblPagos.no and IdTipoDescuento=3),'0') ))	as CargoExtraOrdinario_cantidad,
	
	
	(SELECT 
	(tblPagos.abono - IF(tblPagos.estado <> 'X',ifnull((select sum(capital) from corte where nosol=tblPagos.nosol and no=tblPagos.no ),'0'),tblPagos.abono))
	
	+ 
(tblPagos.interes - 
		IF(tblPagos.estado <> 'X',ifnull((select sum(interes) from corte where nosol=tblPagos.nosol and no=tblPagos.no ),'0'),tblPagos.interes) 	
	)
	
+ 

(tblPagos.iva - 
		IF(tblPagos.estado <> 'X',ifnull((select sum(impuesto) from corte where nosol=tblPagos.nosol and no=tblPagos.no ),'0'),tblPagos.iva) 	
	)
+ mora_debe + CargoSemanal + CargoExtraOrdinario_cantidad  + tblPagos.cargoseguro) as subTOTAL,
	
	ifnull(
	(select GROUP_CONCAT(concepto, ' por ',act_user,' el ',act_fecha,' ') from descuetos where nosol=tblPagos.nosol and no=tblPagos.no )
	,'') as Descuento_concepto,
	
	ifnull((select sum(cantidad) from descuetos where nosol=tblPagos.nosol and no=tblPagos.no and IdTipoDescuento=0),'0') as Descuento_cantidad,
	
	ifnull((select sum(cantidad) from descuetos where nosol=tblPagos.nosol and no=tblPagos.no and IdTipoDescuento=1),'0') as Descuento_Moratorio,

ifnull((select sum(cantidad) from descuetos where nosol=tblPagos.nosol and no=tblPagos.no and IdTipoDescuento=4),'0') as Descuento_CargoSemanal,

ifnull((select sum(cantidad) from descuetos where nosol=tblPagos.nosol and no=tblPagos.no and IdTipoDescuento=3),'0') as Descuento_CargosExtras,

ifnull((select sum(cantidad) from descuetos where nosol=tblPagos.nosol and no=tblPagos.no and IdTipoDescuento=2),'0') as Descuento_Financiamiento,

ifnull((select sum(cantidad) from descuetos where nosol=tblPagos.nosol and no=tblPagos.no and IdTipoDescuento=5),'0') as Descuento_Capital,

  
	(
		IF(UPPER(tblPagos.estado) = 'X',0,
			(SELECT (tblPagos.abono - (IF(tblPagos.estado <> 'X',ifnull((select sum(capital) from corte where nosol=tblPagos.nosol and no=tblPagos.no ),'0'),tblPagos.abono) + ifnull((select sum(cantidad) from descuetos where nosol=tblPagos.nosol and no=tblPagos.no and IdTipoDescuento=5),'0'))	 )  + (tblPagos.interes - 
	(IF(tblPagos.estado <> 'X',ifnull((select sum(interes) from corte where nosol=tblPagos.nosol and no=tblPagos.no ),'0'),tblPagos.interes) 	+ ifnull((select sum(cantidad) from descuetos where nosol=tblPagos.nosol and no=tblPagos.no and IdTipoDescuento=2),'0') )
		
	) + iva + mora_debe + CargoSemanal + CargoExtraOrdinario_cantidad + tblPagos.cargoseguro) - (SELECT Descuento_cantidad)
		)
	) as TOTAL,
	
	(SELECT FORMAT(TOTAL,2)) as TotalFormat,
	
	IF((select TOTAL )=  0,'PAGADO',
		(IF( UPPER(tblPagos.estado) = 'X','PAGADO','SIN PAGAR'))
	) AS EstadoPago,
	
	tblPagos.comentario,
	
	
	
	if (ifnull((select valor from corte where nosol=tblPagos.nosol and no=tblPagos.no limit 1),'') = '',
		IF(UPPER(tblPagos.estado) = 'X',
			
			( (SELECT abono + interes + iva + mora_debe + CargoSemanal + CargoExtraOrdinario_cantidad) - ifnull((select sum(cantidad) from descuetos where nosol=tblPagos.nosol and no=tblPagos.no ),'0'))
			
			,'0')	
		,(select sum(valor) from corte where nosol=tblPagos.nosol and no=tblPagos.no )
	) as CajaCantidad,
	
	
	
	ifnull((select sum(ahorro) from corte where nosol=tblPagos.nosol and no=tblPagos.no ),'') as CajaAhorro,
	
	
	
	
	
	if (ifnull((select valor from corte where nosol=tblPagos.nosol and no=tblPagos.no limit 1),'') = '',
		IF(UPPER(tblPagos.estado) = 'X',
			tblPagos.fin,
		  ''
		)	
	
	,ifnull((select fecha from corte where nosol=tblPagos.nosol and no=tblPagos.no limit 1),'') 	
	) as CajaFecha
	
	
	
	
	
	,ifnull((select sum(moratorio) from corte where nosol=tblPagos.nosol and no=tblPagos.no ),'0') 	
	 as CajaMoratorio
	
	,ifnull((select sum(extras) from corte where nosol=tblPagos.nosol and no=tblPagos.no ),'0') 	
	 as CajaExtras
	
	,ifnull((select sum(cargosemanal) from corte where nosol=tblPagos.nosol and no=tblPagos.no ),'0') 	
	 as CajaCargoSemanal,
	
	
	
	
	
	
	
	
		
if (ifnull((select valor from corte where nosol=tblPagos.nosol and no=tblPagos.no limit 1),'') = '',		
		IF(UPPER(tblPagos.estado) = 'X',
			CONCAT('PAGADO'),
			''),
		ifnull((select comentario from corte where nosol=tblPagos.nosol and no=tblPagos.no limit 1),'')

) as CajaComentario,	
	
	
	ifnull((select corte.usuario from corte where nosol=tblPagos.nosol and no=tblPagos.no limit 1),'') as Caja_Usuario,
	ifnull((select id from corte where nosol=tblPagos.nosol and no=tblPagos.no limit 1),'') as IdRecibo,
	
	IF(curdate() < tblPagos.fin, 	
	'AL CORRIENTE',
		
		IF((select TOTAL )=  0,'PAGADO',
			(IF( UPPER(tblPagos.estado) = 'X','PAGADO','VENCIDO'))
		) 
	
	) as CarteraEstatus,
	
	(select cuentas.IdEstatus from cuentas where nosol = tblPagos.nosol) as IdEstatus,
	(select cuentas.IdSucursal from cuentas where nosol = tblPagos.nosol) as IdSucursal
	
FROM
	tabladepagos tblPagos WHERE 
	(select cuentas.valoracion from cuentas where nosol = tblPagos.nosol) = 'APROBADO' 
	AND
	(select cuentas.IdEstatus from cuentas where nosol = tblPagos.nosol) <> '1' ;

-- ----------------------------
-- View structure for carteravencida
-- ----------------------------
DROP VIEW IF EXISTS `carteravencida`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `carteravencida` AS select 
	*
from cartera 
where
	EstadoPago<>'PAGADO' 
	and fecha<CURDATE() ;

-- ----------------------------
-- View structure for carteravencida_clientes
-- ----------------------------
DROP VIEW IF EXISTS `carteravencida_clientes`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `carteravencida_clientes` AS -- LA CARTERA VENCIDA
select DISTINCT c.Cliente, c.curp,
	
	(select GROUP_CONCAT(DISTINCT nosol) from cartera WHERE curp = c.curp and  EstadoPago<>'PAGADO' and fecha<CURDATE() )	as Solicitudes,
	(select count(DISTINCT nosol) from cartera WHERE curp = c.curp and  EstadoPago<>'PAGADO' and fecha<CURDATE() )	as NSolicitudes,
	
	(select sum(TOTAL) from cartera WHERE curp = c.curp and  EstadoPago<>'PAGADO' and fecha<CURDATE() )	as DeudaTotal,
	(select MIN(fecha) from cartera WHERE curp = c.curp and  EstadoPago<>'PAGADO' and fecha<CURDATE() )	as Atraso_Fecha,
	(select MAX(mora_dias)  from cartera WHERE curp = c.curp and  EstadoPago<>'PAGADO' and fecha<CURDATE() )	as Atraso_Dias,
	(select sum(mora_debe) from cartera WHERE curp = c.curp and  EstadoPago<>'PAGADO' and fecha<CURDATE() )	as Moratorios,
	(select sum(CargoSemanal) from cartera WHERE curp = c.curp and  EstadoPago<>'PAGADO' and fecha<CURDATE() )	as CargosSemanales,
	(select sum(CargoExtraOrdinario_cantidad) from cartera WHERE curp = c.curp and  EstadoPago<>'PAGADO' and fecha<CURDATE() )	as CargosExtraOrdinarios
		
from cartera c
where
	EstadoPago<>'PAGADO' 
	and fecha<CURDATE() ;

-- ----------------------------
-- View structure for carteravencida_totales
-- ----------------------------
DROP VIEW IF EXISTS `carteravencida_totales`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `carteravencida_totales` AS -- LA CARTERA VENCIDA
select 
	sum(TOTAL) as Total,
	sum(abono) as Abonos,
	sum(interes) as Intereses,
	sum(iva) as Impuestos,
	sum(mora_debe) as Moratorios,
	sum(CargoSemanal) as CargosSemanales,
	sum(CargoExtraOrdinario_cantidad) as CargosExtraOrdinarios,
	sum(Descuento_cantidad) as Descuentos
from cartera 
where
	EstadoPago<>'PAGADO' 
	and fecha<CURDATE() ;

-- ----------------------------
-- View structure for cartera_resumen
-- ----------------------------
DROP VIEW IF EXISTS `cartera_resumen`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `cartera_resumen` AS select DISTINCT s.nosol, s.curp, s.valoracion, s.cantidad, s.fechasol,
(select count(*) from cartera where nosol = s.nosol and EstadoPago='SIN PAGAR') as DebePagos,
ifnull((select sum(TOTAL) from cartera where nosol = s.nosol and EstadoPago='SIN PAGAR'),0) as Debe

from solicitudes s ;

-- ----------------------------
-- View structure for clientescongrupo
-- ----------------------------
DROP VIEW IF EXISTS `clientescongrupo`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `clientescongrupo` AS select 
c.curp,
c.nombre,

c.IdGrupo,
(select Grupo from grupos where IdGrupo = c.IdGrupo) as Grupo,
c.grupo_cargo,

c.IdSucursal,
(select Sucursal from sucursales where IdSucursal = c.IdSucursal) as Sucursal,
CONCAT('<a href="app_carnet.php?id=',c.curp,'">',c.nombre,'</a>') as nombre_html
from clientes c ;

-- ----------------------------
-- View structure for clientes_info
-- ----------------------------
DROP VIEW IF EXISTS `clientes_info`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `clientes_info` AS select DISTINCT c.Cliente, c.curp,
	
	(select GROUP_CONCAT(DISTINCT nosol) from cartera WHERE curp = c.curp and  EstadoPago<>'PAGADO' and fecha<CURDATE() )	as Solicitudes,
	(select count(DISTINCT nosol) from cartera WHERE curp = c.curp and  EstadoPago<>'PAGADO' and fecha<CURDATE() )	as NSolicitudes,
	
	(select sum(TOTAL) from cartera WHERE curp = c.curp and  EstadoPago<>'PAGADO' and fecha<CURDATE() )	as DeudaTotal,
	(select MIN(fecha) from cartera WHERE curp = c.curp and  EstadoPago<>'PAGADO' and fecha<CURDATE() )	as Atraso_Fecha,
	(select MAX(mora_dias)  from cartera WHERE curp = c.curp and  EstadoPago<>'PAGADO' and fecha<CURDATE() )	as Atraso_Dias,
	(select sum(mora_debe) from cartera WHERE curp = c.curp and  EstadoPago<>'PAGADO' and fecha<CURDATE() )	as Moratorios,
	(select sum(CargoSemanal) from cartera WHERE curp = c.curp and  EstadoPago<>'PAGADO' and fecha<CURDATE() )	as CargosSemanales,
	(select sum(CargoExtraOrdinario_cantidad) from cartera WHERE curp = c.curp and  EstadoPago<>'PAGADO' and fecha<CURDATE() )	as CargosExtraOrdinarios
		
from cartera c ;

-- ----------------------------
-- View structure for contratos
-- ----------------------------
DROP VIEW IF EXISTS `contratos`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `contratos` AS SELECT
	s.valoracion,
	s.nosol,
	s.tipo,
	s.Cliente,
	s.fechacontrato,
	s.cantidad,
	s.plazo,
	s.tasa_interes,
	s.tasa_moratorio,
	FORMAT( ifnull(( SELECT sum( TOTAL ) FROM saldos WHERE nosol = s.nosol ), 0 ), 2 ) AS Debe,
	FORMAT( ifnull(( SELECT sum( mora_debe ) FROM saldos WHERE nosol = s.nosol  and EstadoPago='SIN PAGAR'), 0 ), 2 ) AS DebeMora,
	ifnull(( SELECT max( mora_dias ) FROM saldos WHERE nosol = s.nosol ), 0 ) AS AtrasoDias,
	ifnull(( SELECT act_fecha FROM saldos WHERE nosol = s.nosol and act_fecha <> '' limit 1), 0) as Actualizacion
	,s.curp,
	(select grupo from clientes where curp = s.curp) as grupo,
	(select fin from tabladepagos where nosol=s.nosol order by no DESC limit 1) as vencimiento,
	(select cuentas.IdEstatus from cuentas where nosol = s.nosol) as IdEstatus
	

FROM
	solicitudes s 
WHERE
	nosol <> '' ;

SET FOREIGN_KEY_CHECKS = 1;
