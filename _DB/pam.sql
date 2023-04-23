/* CREACION DE LA BASE DE DE DATOS PARA EL PROYECTO PAM (Plataforma de Acuerdos y Minutas)*/
CREATE DATABASE IF NOT EXISTS `PAM` CHARACTER SET = utf8mb4;
USE `PAM`;
/* CREACION DE LAS TABLAS*/
CREATE TABLE `roles` (
    `rol_id` INT(11) NOT NULL AUTO_INCREMENT,
    `rol_nombre` VARCHAR(20) NOT NULL,
    `rol_estado` INT(2) NOT NULL DEFAULT 1 COMMENT '0=Inactivo 1=Activo',
    PRIMARY KEY(`rol_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `roles` (`rol_id`, `rol_nombre`, `rol_estado`) VALUES
(1, 'Administrador', 1),
(2, 'UTIC', 1),
(3, 'Fábrica', 1);

CREATE TABLE `modulos`(
    `mod_id` INT (11) NOT NULL AUTO_INCREMENT,
    `mod_nombre` VARCHAR (50) NOT NULL,
    `mod_estado` INT(2) NOT NULL DEFAULT 1 COMMENT '0=inactivo 1=activo',
    PRIMARY KEY(`mod_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `modulos`(`mod_id`, `mod_nombre`, `mod_estado`) VALUES
(1, 'Modulo Usuarios', 1),
(2, 'Modulo Minutas', 1),
(3, 'Modulo Oficios', 1),
(4, 'Modulo CTR', 1),
(5, 'Modulo Logos', 1),
(6, 'Modulo Oficios', 1);

CREATE TABLE `permisos`(
    `permiso_id` INT(11) NOT NULL AUTO_INCREMENT,
    `permiso_rol` INT(11) NOT NULL,
    `permiso_mod` INT(11) NOT NULL,
    `permiso_leer` INT(2) NOT NULL DEFAULT 0,
    `permiso_crear` INT(2) NOT NULL DEFAULT 0,
    `permiso_modif` INT(2) NOT NULL DEFAULT 0,
    `permiso_borrar` INT(2) NOT NULL DEFAULT 0,
    PRIMARY KEY (`permiso_id`),
    FOREIGN KEY(`permiso_rol`) REFERENCES `roles`(`rol_id`),
    FOREIGN KEY(`permiso_mod`) REFERENCES `modulos` (`mod_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `titulos` (
    `titulo_id` INT(11) NOT NULL AUTO_INCREMENT,
    `titulo_abr` VARCHAR(15)NULL,
    `titulo_nom` VARCHAR(255) NULL,
    `titulo_estado` INT(11) NOT NULL DEFAULT 1 COMMENT '0=Inactivo 1=Activo',
    PRIMARY KEY(`titulo_id`)
)ENGINE = INNODB DEFAULT CHARSET = utf8;

INSERT INTO `titulos` (`titulo_id`, `titulo_abr`, `titulo_nom`) VALUES
(1, 'Ing.', 'Ingeniero'),
(2, 'Ing.', 'Ingeniera'),
(3, 'Lic.', 'Licenciado'),
(4, 'Lic.', 'Licenciada'),
(5, 'Mtro.', 'Maestro'),
(6, 'Mtra.', 'Maestra'),
(7, 'Cr.', 'Contador'),
(8, 'Cra.', 'Contadora');

CREATE TABLE`acciones`(
    `accion_id` INT(11) NOT NULL AUTO_INCREMENT,
    `accion_cmd` VARCHAR(50) NOT NULL,
    PRIMARY KEY(`accion_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `acciones` (`accion_id`, `accion_cmd`) VALUES
(1, 'Crear Usuario'),
(2, 'Editar Usuario'),
(3, 'Inactivar Usuario '),
(4, 'Crear Minuta'),
(5, 'Editar Minuta'),
(6, 'Activar Minuta'),
(7, 'Inactivar Minuta'),
(8, 'Cerrar Minuta'),
(9, 'Crear Acuerdo'),
(10, 'Editar Acuerdo'),
(11, 'Activar Acuerdo'),
(12, 'Inactivar Acuerdo'),
(13, 'Cerrar Acuerdo'),
(14, 'Imprimir Minuta'),
(15, 'Crear Rol'),
(16, 'Editar Rol'),
(17, 'Eliminar Rol'),
(18, 'Crear Cargo'),
(19, 'Editar Cargo'),
(20, 'Eliminar Cargo'),
(21, 'Crear Titulo'),
(22, 'Editar Titulo'),
(23, 'Eliminar Titulo'),
(24, 'Crear Permisos'),
(25, 'Editar Permisos'),
(26, 'Imprimir Oficio'),
(27, 'Registrar Invitado'),
(28, 'Editar Invitado'),
(29, 'Eliminar Invitado'),
(30, 'Crear Reporte'),
(31, 'Editar Reporte'),
(32, 'Activar Reporte'),
(33, 'Inactivar Reporte'),
(34, 'Eliminar Reporte'),
(35, 'Crear Cadena'),
(36, 'Editar Cadena'),
(37, 'Borrar Cadena'),
(38, 'Imprimir Reporte'),
(39, 'Crear Persona'),
(40, 'Editar Persona'),
(41, 'Borrar Persona'),
(42, 'Crear Destinatario'),
(43, 'Editar Destinatario'),
(44, 'Borrar Destinatario'),
(45, 'Crear Remitente'),
(46, 'Editar Remitente'),
(47, 'Borrar Remitente'),
(48, 'Crear Empresa'),
(49, 'Editar Empresa'),
(50, 'Borrar Empresa'),
(51, 'Subir Oficio'),
(52, 'Editar Oficio'),
(53, 'Borrar Oficio'),
(54, 'Subir Logo'),
(55, 'Editar Logo'),
(56, 'Borrar Logo');

CREATE TABLE `unidades` (
    `unidad_id` INT(11) NOT NULL AUTO_INCREMENT,
    `unidad_num` INT(11) NOT NULL,
    `unidad_nom` VARCHAR(100) NOT NULL,
    `unidad_tipo` INT(2) NOT NULL DEFAULT 1 COMMENT '0=Externo 1=Interno',
    PRIMARY KEY (`unidad_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `unidades` (`unidad_id`, `unidad_num`, `unidad_nom`) VALUES
(1, 100, 'SECRETARIO DEL RAMO '),
(2, 102, 'DIRECCION GENERAL DE VINCULACION'),
(3, 110, 'UNIDAD DE ASUNTOS JURIDICOS'),
(4, 111, 'DIRIRECCION GENERAL DE COMUNICACION SOCIAL'),
(5, 112, 'ORGANO INTERNO DE CONTROL'),
(6, 114, 'DIRECCION GENERAL DE PLANEACION'),
(7, 200, 'SUBSECRETARIO DE INFRAESTRUCTURA'),
(8, 205, 'U. INFRAESTRUCTURA CARRETERA PARA EL DESARROLLO REG'),
(9, 210, 'DIR. GRAL. DE CARRETERAS'),
(10, 211, 'DIR. GRAL. DE CONSERVACION DE CARRETERAS'),
(11, 212, 'DIR. GRAL. DE SERVICIOS TECNICOS'),
(12, 214, 'DIR. GRAL. DE DESARROLLO CARRETERO'),
(13, 300, 'SUBSECRETARIA DEL TRANSPORTE'),
(14, 310, 'DIR. GRAL. DE AERONAUTICA CIVIL'),
(15, 311, 'DIRECCION GENERAL DE DESARROLLO FERROVIARIO Y MULTIMODAL'),
(16, 312, 'DIR. GRAL. DE AUTOTRANSPORTE FEDERAL'),
(17, 313, 'DIR. GRAL. DE PROTECT. Y MED. PREV. EN EL TRANSP'),
(18, 400, 'SUBSECRETARIA DE COMUNICACIONES'),
(19, 410, 'DIR. GRAL. DE SISTEMAS DE RADIO Y TELEVISION'),
(20, 411, 'DIR. GRAL. DE POLITICA DE TELECOMUNICACIONES Y RADIODIFUSION'),
(21, 414, 'UNIDAD DE LA RED FEDERAL'),
(22, 415, 'COORDINACION DE LA SOCIEDAD DE LA INFORMACION Y EL CONOCIMIENTO'),
(23, 500, 'COORD. GENERAL DE PUERTOS Y MARINA MERCANTE'),
(24, 510, 'DIR. GRAL. DE PUERTOS'),
(25, 511, 'DIR. GRAL. DE MARINA MERCANTE'),
(26, 512, 'DIR. GRAL. DE FOMENTO Y ADMINISTRACION PORTUARIA'),
(27, 600, 'COORDINACION GENERAL DE CENTRO S.C.T'),
(28, 611, 'DIR. GRAL. DE EVALUACION'),
(29, 621, 'CENTRO S.C.T AGUASCALIENTES'),
(30, 622, 'CENTRO S.C.T BAJA CALIFORNIA'),
(31, 623, 'CENTRO S.C.T BAJA CALIFORNIA SUR'),
(32, 624, 'CENTRO S.C.T CAMPECHE'),
(33, 625, 'CENTRO S.C.T COAHUILA'),
(34, 626, 'CENTRO S.C.T COLIMA'),
(35, 627, 'CENTRO S.C.T CHIAPAS'),
(36, 628, 'CENTRO S.C.T CHIHUAHUA'),
(37, 630, 'CENTRO S.C.T DURANGO'),
(38, 631, 'CENTRO S.C.T GUANAJUATO'),
(39, 632, 'CENTRO S.C.T GUERRERO'),
(40, 633, 'CENTRO S.C.T HIDALGO'),
(41, 634, 'CENTRO S.C.T JALISCO'),
(42, 635, 'CENTRO S.C.T MEXICO'),
(43, 636, 'CENTRO S.C.T MICHOACAN'),
(44, 637, 'CENTRO S.C.T MORELOS'),
(45, 638, 'CENTRO S.C.T NAYARIT'),
(46, 639, 'CENTRO S.C.T NUEVO LEON'),
(47, 640, 'CENTRO S.C.T OAXACA'),
(48, 641, 'CENTRO S.C.T PUEBLA'),
(49, 642, 'CENTRO S.C.T QUERETARO'),
(50, 643, 'CENTRO S.C.T QUINTANA ROO'),
(51, 644, 'CENTRO S.C.T SAN LUIS POTOSI'),
(52, 645, 'CENTRO S.C.T SINALOA'),
(53, 646, 'CENTRO S.C.T SONORA'),
(54, 647, 'CENTRO S.C.T TABASCO'),
(55, 648, 'CENTRO S.C.T TAMAULIPAS'),
(56, 649, 'CENTRO S.C.T TLAXCALA'),
(57, 650, 'CENTRO S.C.T VERACRUZ'),
(58, 651, 'CENTRO S.C.T YUCATAN'),
(59, 652, 'CENTRO S.C.T ZACATECAS'),
(60, 700, 'UNIDAD DE ADMINISTRACION Y FINANZAS'),
(61, 710, 'DIR. GRAL. DE PROG. ORGANIZACION Y PRESUP.'),
(62, 711, 'DIR. GRAL. DE RECURSOS HUMANOS'),
(63, 712, 'DIR. GRAL. DE RECURSOS MATERIALES'),
(64, 713, 'UNIDAD DE TECNOLOGIA DE INFORMACION Y COMUNICACIONES');

CREATE TABLE `cargos`(
    `cargo_id` INT(11) NOT NULL AUTO_INCREMENT,
    `cargo_nom` VARCHAR(100) NOT NULL,
    `cargo_tipo` INT(2) NOT NULL DEFAULT 1 COMMENT '0=Externo 1=Interno',
    `cargo_estado` INT(2) NOT NULL DEFAULT 1 COMMENT '0=Inactivo 1=Activo',
    /*`cargo_madeBy` INT(11) NOT NULL,*/
    PRIMARY KEY (`cargo_id`)/*,
    FOREIGN KEY (`cargo_madeBy`)REFERENCES `usuarios`(`user_id`)*/
)ENGINE = INNODB DEFAULT CHARSET = utf8mb4;

INSERT INTO `cargos` (`cargo_id`, `cargo_nom`, `cargo_tipo`) VALUES
(1, 'Dirección Coordinadora de Innovación y Desarrollo Tecnológico', 1),
(2, 'Dirección de Desarrollo Tecnológico', 1),
(3, 'Dirección de Administración y Gestión Electrónica de Documentos', 1),
(4, 'Subdirección de Sistemas Administrativos', 1),
(5, 'Subdirección de Implementación y Administración de Aplicaciones', 1),
(6, 'Subdirección de Gestión Electrónica de Documentos', 1),
(7, 'Departamento de Portales y Administración de Contenido', 1),
(8, 'Departamento de Sistemas Ejecutivos', 1),
(9, 'Subdirección de Administración de Portales', 1),
(10, 'Subdirección de Politica de Transparencia e Información', 1),
(11, 'Subdirección de Administración de Portales', 1),
(12, 'Subdirección de Innovación Tecnológica', 1),
(13, 'Subdirección de Comunicaciones e Ingeniería', 1),
(14, 'Subdirección de Seguridad Informática y Servicios de Voz', 1),
(15, 'Jefatura de Departamento de Informática', 1),
(16, 'Subdirección de Sistemas Sectoriales', 1),
(17, 'Subdirección de Sistemas Administrativos', 1),
(18, 'Jefatura de Departamento de Supervisión de Entrega de Servicios', 1),
(19, 'Subdirección de Administración de Soporte a Servicios de Tecnologías deInformación y Comunicaciones ', 1),
(20, 'Jefatura de Departamento de Comunicaciones e Ingeniería', 1),
(21, 'Jefatura de Departamento de Portales y Administración de Contenido', 1),
(22, 'Dirección de Normatividad en Tecnologías de la Información y Comunicaciones', 1),
(23, 'Dirección Coordinadora de Estartegía en Tecnología de Información y Comunicaciones', 1),
(24, 'Dirección de Comunicaciones', 1),
(25, 'Dirección de Servicios Informáticos', 1),
(26, 'Titular de la Unidad de Tecnologías de la Infomación y Comunicaciones', 1);

CREATE TABLE `usuarios` (
    `user_id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_titulo` INT(11),
    `user_nom` VARCHAR(30) NOT NULL,
    `user_ap` VARCHAR(30) NOT NULL,
    `user_am` VARCHAR(30) NOT NULL,
    `user_unidad`  INT(5) NOT NULL,
    `user_cargo` INT(5) NOT NULL,
    `user_rol` INT(5) NOT NULL,
    `user_mail` VARCHAR(50) NOT NULL,
    `user_pass` VARCHAR(250) NOT NULL,
    `user_estado` INT(3) NOT NULL DEFAULT 1,
    `user_fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `user_madeBy` INT(11) NOT NULL,
    PRIMARY KEY(`user_id`),
    FOREIGN KEY(`user_titulo`) REFERENCES `titulos`(`titulo_id`),
    FOREIGN KEY(`user_unidad`) REFERENCES `unidades`(`unidad_id`),
    FOREIGN KEY(`user_cargo`) REFERENCES `cargos`(`cargo_id`),
    FOREIGN KEY(`user_rol`) REFERENCES `roles`(`rol_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*INSERT INTO `usuarios` (`user_id`, `user_titulo`, `user_nom`, `user_ap`, `user_am`, `user_unidad`, `user_cargo`, `user_rol`, `user_mail`, `user_pass`, `user_estado`, `user_fecha`, `user_madeBy`) VALUES
(1, 2, 'Marysse', 'Peña', 'Baena', 64, 5, 1, 'maryset@gmail.com', '$2y$10$D9SONoGTeJicBRpESHmVEuo7CTo7rHSvQkzkN6VwMGj9n5WvGjlBe', 1, '2022-09-25 15:11:36', 0),
(2, 2, 'Lesley María', 'Ibarra', 'Zarate', 64, 5, 1, 'lesmaria@gmail.com', '$2y$10$8KTxyWSMTw4tLeVmZoWB9OobjkP7.QhBDrD/YpK3pQs/Y5kg8SfA2', 1, '2022-10-04 15:22:36', 0),
(3, 4, 'Nyta', 'Brionel', 'Tapia', 6, 12, 2, 'nyta12@gmail.com', '$2y$10$9wkCFl3s2g/BLa1Q/aJIGOLqhwvS05IOM7hjIT1e7AATsYYzOdc6K', 1, '2022-10-04 15:24:30', 0),
(4, 8, 'Edith', 'Tentle', 'Jiménez', 64, 2, 3, 'edith@gmail.com', '$2y$10$JIHQS/3VTBG2WO8Ox4OjXuU4t9MAyM6SpdwstZtDpBEs4sX80xymW', 1, '2022-10-07 21:57:50', 0);
*/


CREATE TABLE `entes`(
    `ente_id` INT(11) NOT NULL AUTO_INCREMENT,
    `ente_nom` VARCHAR(100) NOT NULL,
    `ente_tipo` INT(2) NOT NULL DEFAULT 1 COMMENT '0=Externo 1=Interno',
    `ente_estado` INT(11) NOT NULL DEFAULT 1 COMMENT '0-Inactivo, 1-Activo',
    `ente_categoria` INT (11) NOT NULL COMMENT '1-dest, 2-rem, 3-emp',
    `ente_madeBy` INT(11) NOT NULL,
    PRIMARY KEY (`ente_id`),
    FOREIGN KEY (`ente_madeBy`)REFERENCES `usuarios`(`user_id`)
)ENGINE = INNODB DEFAULT CHARSET = utf8;


CREATE TABLE `minutas` (
    `minuta_id` INT(11) NOT NULL AUTO_INCREMENT,
    `minuta_madeBy` INT(11) NOT NULL DEFAULT 1,
    `minuta_titulo` VARCHAR(150) NOT NULL, 
    `minuta_desarrollo` LONGTEXT NOT NULL,
    `minuta_lugar` VARCHAR (100) NOT NULL,
    `minuta_fecha` DATE NOT NULL,
    `minuta_hora` VARCHAR (11) NOT NULL,
    `minuta_hora_cierre` VARCHAR (11) NULL,
    `minuta_unidad_admin` INT(5) NOT NULL,
    `minuta_participantes` VARCHAR(255) NOT NULL,
    `minuta_status` INT(5) NOT NULL DEFAULT 1 COMMENT '0-Finalizada, 1-Activa, 2-En Espera',
    `minuta_prioridad` INT(5) NOT NULL DEFAULT 0 COMMENT '0-Normal, 1-Urgente. 2-Paso Fecha',
    `minuta_fecha_PAM` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`minuta_id`),
    FOREIGN KEY (`minuta_madeBy`)REFERENCES `usuarios`(`user_id`),
    FOREIGN KEY(`minuta_unidad_admin`) REFERENCES `cargos`(`cargo_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `participantes` (
    `participante_id` INT(11) NOT NULL AUTO_INCREMENT,
    `participante_nom` VARCHAR( 250) NOT NULL,
    `participante_titulo` INT(11) NOT NULL,
    `participante_cargo` INT(11) NOT NULL,
    `participante_mail` VARCHAR(250) NOT NULL,
    `participante_tipo` INT(11) NOT NULL COMMENT '0-Externo, 1-Interno',
    `participante_estado` INT(11) NOT NULL DEFAULT 1 COMMENT '0-Inactivo, 1-Activo',
    PRIMARY KEY (`participante_id`),
    FOREIGN KEY(`participante_titulo`) REFERENCES `titulos`(`titulo_id`),
    FOREIGN KEY(`participante_cargo`) REFERENCES `cargos`(`cargo_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `acuerdos` (
    `acuerdo_id` INT(11) NOT NULL AUTO_INCREMENT,
    `acuerdo_minuta` INT( 11) NOT NULL,
    `acuerdo_titulo` VARCHAR(100) NOT NULL,
    `acuerdo_fecha_entrega` DATE NOT NULL,
    `acuerdo_responsable` INT(11) NOT NULL,
    `acuerdo_fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `acuerdo_status` INT(11) NOT NULL DEFAULT 0 COMMENT '0-Pendiente, 1-Hecho',
    `minuta_prioridad` INT(5) NOT NULL DEFAULT 0 COMMENT '0-Normal, 1-Urgente. 2-Paso Fecha',
    PRIMARY KEY (`acuerdo_id`),
    FOREIGN KEY(`acuerdo_minuta`) REFERENCES `minutas`(`minuta_id`),
    FOREIGN KEY (`acuerdo_responsable`) REFERENCES `participantes`(`participante_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `receptores`(
    `receptor_id` INT(11) NOT NULL AUTO_INCREMENT,
    `receptor_nom` VARCHAR( 250) NOT NULL,
    `receptor_tipo` INT(11) NOT NULL COMMENT '0-Externo, 1-Interno',
    `receptor_estado` INT(11) NOT NULL DEFAULT 1 COMMENT '0-Inactivo, 1-Activo',
    `receptor_MadeBy` INT(11) NOT NULL,
    PRIMARY KEY (`receptor_id`),
    FOREIGN KEY(`receptor_madeBy`) REFERENCES `usuarios`(`user_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `reportes`(
    `reporte_id` INT(11) NOT NULL AUTO_INCREMENT,
    `reporte_titulo` VARCHAR(255) NOT NULL,
    `reporte_fecha_incidente` DATE NOT NULL,
    `reporte_incidente` VARCHAR(100) NOT NULL,
    `reporte_caso` VARCHAR(100) NOT NULL,
    `reporte_consentimiento` INT(11) NOT NULL,
    `reporte_etiqueta` VARCHAR(100) NOT NULL,
    `reporte_modelo` VARCHAR(100) NOT NULL,
    `reporte_fabricante` VARCHAR(100) NOT NULL,
    `reporte_num_serie` VARCHAR(100) NOT NULL,
    `reporte_descripcion` LONGTEXT NOT NULL,
    `reporte_persona` INT (11) NOT NULL,
    `reporte_disp_final` VARCHAR(255) NOT NULL,
    `reporte_fecha_final` DATE NOT NULL,
    `reporte_fecha_sis` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `reporte_madeBy` INT(11) NOT NULL,
    `reporte_estado` INT(11) NOT NULL DEFAULT 1 COMMENT '0-Inactivo, 1-Activo',
    PRIMARY KEY (`reporte_id`),
    FOREIGN KEY(`reporte_persona`) REFERENCES `receptores`(`receptor_id`),
    FOREIGN KEY(`reporte_madeBy`) REFERENCES `usuarios`(`user_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `evidencias`(
    `evidencia_id` INT(11) NOT NULL AUTO_INCREMENT,
    `evidencia_reporte` INT( 11) NOT NULL,
    `evidencia_origen` VARCHAR(255) NOT NULL,
    `evidencia_fecha` DATE NOT NULL,
    `evidencia_razon` VARCHAR(255) NOT NULL,
    `evidencia_destino` VARCHAR(255) NOT NULL,
    `evidencia_prueba` VARCHAR(255) NULL,
    `evidencia_fecha_sis` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `evidencia_status` INT(11) NOT NULL DEFAULT 0 COMMENT '0-Pendiente, 1-Hecho',
    `evidencia_prioridad` INT(5) NOT NULL DEFAULT 0 COMMENT '0-Normal, 1-Urgente. 2-Paso Fecha',
    PRIMARY KEY (`evidencia_id`),
    FOREIGN KEY(`evidencia_reporte`) REFERENCES `reportes`(`reporte_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `oficios` (
  `ofi_id` INT(11) NOT NULL AUTO_INCREMENT,
  `ofi_subidoPor` INT(11) NOT NULL,
  `ofi_destinatario` INT(11) NOT NULL,
  `ofi_cargoDest` INT(11) DEFAULT NULL,
  `ofi_unidadDest` INT(11) DEFAULT NULL,
  `ofi_remitente` INT(11) NOT NULL,
  `ofi_cargoRem` INT(11) NOT NULL,
  `ofi_unidadRem` INT(11) DEFAULT NULL,
  `ofi_fechaE` DATE NOT NULL,
  `ofi_fechaRecep` DATE NOT NULL,
  `ofi_asunto` VARCHAR(50) NOT NULL,
  `ofi_numero` VARCHAR(50) NOT NULL,
  `ofi_observacion` VARCHAR(250) NOT NULL,
  `ofi_fechaSOFI` DATE NOT NULL DEFAULT current_timestamp(),
  `ofi_activo` INT(2) NOT NULL DEFAULT 1 COMMENT'0=Inactivo 1=Activo',
  `ofi_url` LONGTEXT NOT NULL,
  PRIMARY KEY (`ofi_id`),
  FOREIGN KEY (`ofi_subidoPor`) REFERENCES `usuarios`(`user_id`),
  FOREIGN KEY (`ofi_destinatario`) REFERENCES `entes`(`ente_id`),
  FOREIGN KEY (`ofi_cargoDest`) REFERENCES `cargos`(`cargo_id`),
  FOREIGN KEY (`ofi_unidadDest`) REFERENCES `entes`(`ente_id`),
  FOREIGN KEY (`ofi_remitente`) REFERENCES `entes`(`ente_id`),
  FOREIGN KEY (`ofi_cargoRem`) REFERENCES `cargos`(`cargo_id`),
  FOREIGN KEY (`ofi_unidadRem`) REFERENCES `entes`(`ente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `logos`(
    `logo_id` INT(11) NOT NULL AUTO_INCREMENT,
    `logo_nombre` VARCHAR(255) NOT NULL,
    `logo_url` VARCHAR(255) NOT NULL,
    `logo_anho` INT(11) NOT NULL,
    `logo_para` INT(11) NOT NULL COMMENT'1-Minuta 2=Reporte 3=piePag',
    `logo_estado` INT(11) NOT NULL DEFAULT 1 COMMENT '0=Inactivo 1=Activo',
    PRIMARY KEY (`logo_id`)
);

INSERT INTO `logos` (`logo_nombre`, `logo_url`, `logo_anho`, `logo_para`, `logo_estado` VALUES
('sict flores magon large', 2022, 1,1),
('pie de pag', 2022, 3,1),
('sict logo', 2022, 2,1),
('flores magon banner', 2022, 2,1);

CREATE TABLE `historial` (
    `hist_id` INT(11) NOT NULL AUTO_INCREMENT,
    `hist_user` INT(11) NOT NULL,
    `hist_fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `hist_ip` VARCHAR(50) NOT NULL,
    `hist_accion` INT(11) NOT NULL,
    PRIMARY KEY (`hist_id`),
    FOREIGN KEY(`hist_user`) REFERENCES `usuarios`(`user_id`),
    FOREIGN KEY(`hist_accion`) REFERENCES `acciones`(`accion_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


/*
ALTER TABLE `acuerdos` DROP FOREIGN KEY `acuerdos_ibfk_2`;
ALTER TABLE `acuerdos` DROP INDEX `acuerdo_responsable`;
ALTER TABLE `acuerdos` DROP `acuerdo_responsable`;
ALTER TABLE `acuerdos` ADD INDEX(`acuerdo_responsable`);
DROP TABLE `acuerdos`;
*/