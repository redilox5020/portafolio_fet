-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para fetportafolioproyectos
CREATE DATABASE IF NOT EXISTS `fetportafolioproyectos` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `fetportafolioproyectos`;

-- Volcando estructura para tabla fetportafolioproyectos.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.failed_jobs: ~0 rows (aproximadamente)

-- Volcando estructura para tabla fetportafolioproyectos.investigadores
CREATE TABLE IF NOT EXISTS `investigadores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.investigadores: ~43 rows (aproximadamente)
INSERT IGNORE INTO `investigadores` (`id`, `nombre`) VALUES
	(1, 'Jose Ricardo Castañeda'),
	(2, 'Cristian Casanova'),
	(3, 'Steven castro'),
	(4, 'Jose Ricardo Castañeda Losada'),
	(5, 'Jhonatan Gelves'),
	(6, 'Marlon Steven'),
	(7, 'Wilber Adolfo Jaramillo Holguin'),
	(8, 'Diana Marcela Peña Triana'),
	(9, 'Diego Alejandro Perdomo Ibarra'),
	(10, 'Alvaro Suarez Gomez'),
	(11, 'Jhon Fredy Fajardo'),
	(12, 'Natalia Horta Gutierrez'),
	(13, 'Norma Constanza Robayo Gonzalez'),
	(14, 'Javier Fernando Zapata Guerrero'),
	(15, 'Karina Andrea Tovar Penagos'),
	(16, 'Diana Marcela Méndez Gómez'),
	(17, 'Luisa Fernanda Cuy Gómez'),
	(18, 'Laura Daniela Franco Calderón'),
	(19, 'Lina Marcela Ramírez'),
	(20, 'Daniela Hueso'),
	(21, 'Anyi Marcela Calderón Cortes'),
	(22, 'Juan Sebastián Salamanca Yaque'),
	(23, 'David Felipe Escobar'),
	(24, 'Mayra Alejandra Salazar Carrera'),
	(25, 'Jose Ignacio Rovira Ninco'),
	(26, 'Andres Felipe Ochica Larrota'),
	(27, 'Jose Ignaciio Castañeda'),
	(28, 'Jonathan Esteban Macías Pastrana'),
	(29, 'Jeffrey Díaz Aya'),
	(30, 'Leonardo Jiménez'),
	(31, 'Johan Sebastián Trujillo Pulido'),
	(32, 'Carlos Alberto Mosquera'),
	(33, 'Fernando Guzmán Vargas'),
	(34, 'Jesús Mauricio Andrade'),
	(35, 'Karla Díaz Donato'),
	(36, 'Anderson Javier González Guarnizo'),
	(37, 'Joey Steven Salamanca Quezada'),
	(38, 'Víctor David Herrera Rojas'),
	(39, 'John Sebastián Samaca Rebolledo'),
	(40, 'John Serrato'),
	(41, 'Kevin Andrés Dussan'),
	(42, 'Henry Mauricio Lozada'),
	(43, 'Luis Fernando Muñoz Suaza');

-- Volcando estructura para tabla fetportafolioproyectos.investigador_proyecto
CREATE TABLE IF NOT EXISTS `investigador_proyecto` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `investigador_id` bigint unsigned NOT NULL,
  `proyecto_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `investigador_proyecto_investigador_id_foreign` (`investigador_id`),
  KEY `investigador_proyecto_proyecto_id_foreign` (`proyecto_id`),
  CONSTRAINT `investigador_proyecto_investigador_id_foreign` FOREIGN KEY (`investigador_id`) REFERENCES `investigadores` (`id`) ON DELETE CASCADE,
  CONSTRAINT `investigador_proyecto_proyecto_id_foreign` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`codigo`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.investigador_proyecto: ~58 rows (aproximadamente)
INSERT IGNORE INTO `investigador_proyecto` (`id`, `investigador_id`, `proyecto_id`) VALUES
	(1, 1, 'SOF-5-1-2025-10'),
	(2, 2, 'SOF-5-1-2025-10'),
	(3, 3, 'SOF-5-1-2025-10'),
	(4, 5, 'SOF-4-2-2025-1'),
	(6, 4, 'AMB-4-1-2025-2'),
	(7, 5, 'AMB-4-1-2025-2'),
	(8, 7, 'SST-1-1-2020-1'),
	(9, 8, 'SST-1-1-2020-1'),
	(10, 9, 'SST-1-1-2020-1'),
	(11, 10, 'SST-1-1-2020-1'),
	(12, 11, 'SST-1-1-2020-1'),
	(13, 12, 'SST-1-1-2020-1'),
	(14, 13, 'SST-1-1-2020-1'),
	(15, 14, 'SST-1-1-2020-1'),
	(16, 15, 'SST-1-1-2020-2'),
	(17, 16, 'SST-1-1-2020-2'),
	(18, 17, 'SST-1-1-2020-2'),
	(19, 18, 'SST-1-1-2020-2'),
	(20, 19, 'SST-1-1-2020-2'),
	(21, 20, 'SST-1-1-2020-2'),
	(22, 21, 'SST-5-1-2020-1'),
	(23, 22, 'SST-5-1-2020-1'),
	(24, 23, 'SST-5-1-2020-1'),
	(25, 21, 'AMB-1-1-2020-1'),
	(26, 22, 'AMB-1-1-2020-1'),
	(27, 23, 'AMB-1-1-2020-1'),
	(30, 2, 'AMB-4-1-2025-1'),
	(31, 6, 'AMB-4-1-2025-1'),
	(32, 4, 'AMB-4-1-2025-1'),
	(33, 4, 'ALI-1-1-2020-1'),
	(34, 6, 'ALI-1-1-2020-1'),
	(35, 6, 'ALI-4-2-2025'),
	(36, 24, 'ALI-1-1-2020-2'),
	(37, 25, 'ALI-1-1-2020-2'),
	(38, 26, 'ALI-1-1-2020-2'),
	(39, 27, 'ALI-1-1-2020-1'),
	(40, 6, 'SOF-5-1-2025-2'),
	(41, 28, 'SOF-1-1-2020-1'),
	(42, 29, 'SOF-1-1-2020-1'),
	(43, 30, 'SOF-1-1-2020-1'),
	(45, 31, 'SOF-1-1-2020-2'),
	(46, 32, 'SOF-1-1-2020-2'),
	(47, 33, 'SOF-1-1-2020-2'),
	(48, 30, 'SOF-1-1-2020-2'),
	(49, 34, 'SOF-4-1-2020-1'),
	(50, 35, 'SOF-4-1-2020-1'),
	(51, 36, 'SOF-4-1-2020-2'),
	(52, 37, 'SOF-4-1-2020-2'),
	(53, 38, 'SOF-4-1-2020-2'),
	(54, 39, 'SOF-4-1-2020-2'),
	(55, 40, 'SOF-4-1-2020-2'),
	(56, 41, 'SOF-1-1-2025-1'),
	(57, 42, 'SOF-1-1-2025-1'),
	(58, 43, 'SOF-1-1-2025-1'),
	(59, 40, 'SOF-1-1-2025-1'),
	(60, 34, 'SOF-5-1-2025-8'),
	(61, 36, 'SOF-5-1-2025-8'),
	(62, 31, 'SOF-4-1-2025-1');

-- Volcando estructura para tabla fetportafolioproyectos.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.migrations: ~15 rows (aproximadamente)
INSERT IGNORE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2025_02_25_023121_create_procedencia_codigos_table', 1),
	(6, '2025_02_25_030614_create_procedencias_table', 1),
	(7, '2025_02_25_030957_create_programas_table', 1),
	(8, '2025_02_25_031243_create_investigadores_table', 1),
	(9, '2025_02_25_031332_create_tipologias_table', 1),
	(10, '2025_02_25_031645_create_proyectos_table', 1),
	(11, '2025_02_25_231224_create_investigador_proyecto_table', 1),
	(12, '2025_03_01_033650_add_new_column_to_proyectos', 1),
	(13, '2025_03_02_043509_update_costo_column_in_proyectos_table', 1),
	(14, '2025_03_03_203936_add_new_file_path_to_proyectos', 1),
	(15, '2025_03_29_031905_create_permission_tables', 1);

-- Volcando estructura para tabla fetportafolioproyectos.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.model_has_permissions: ~0 rows (aproximadamente)

-- Volcando estructura para tabla fetportafolioproyectos.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.model_has_roles: ~1 rows (aproximadamente)
INSERT IGNORE INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1);

-- Volcando estructura para tabla fetportafolioproyectos.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.password_reset_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla fetportafolioproyectos.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.permissions: ~20 rows (aproximadamente)
INSERT IGNORE INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'proyecto.create', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(2, 'proyecto.edit', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(3, 'proyecto.delete', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(4, 'proyecto.view', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(5, 'tipologia.create', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(6, 'tipologia.edit', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(7, 'tipologia.delete', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(8, 'tipologia.view', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(9, 'procedencia.create', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(10, 'procedencia.edit', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(11, 'procedencia.delete', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(12, 'procedencia.view', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(13, 'procedencia.codigo.create', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(14, 'procedencia.codigo.edit', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(15, 'procedencia.codigo.delete', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(16, 'procedencia.codigo.view', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(17, 'programa.create', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(18, 'programa.edit', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(19, 'programa.delete', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(20, 'programa.view', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32');

-- Volcando estructura para tabla fetportafolioproyectos.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.personal_access_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla fetportafolioproyectos.procedencias
CREATE TABLE IF NOT EXISTS `procedencias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `opcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.procedencias: ~5 rows (aproximadamente)
INSERT IGNORE INTO `procedencias` (`id`, `opcion`) VALUES
	(1, 'Semillero de Investigación'),
	(2, 'Grupo de Investigación'),
	(3, 'Aula de clase'),
	(4, 'Extensión'),
	(5, 'Programa Académico - Prácticas');

-- Volcando estructura para tabla fetportafolioproyectos.procedencia_codigos
CREATE TABLE IF NOT EXISTS `procedencia_codigos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `opcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.procedencia_codigos: ~7 rows (aproximadamente)
INSERT IGNORE INTO `procedencia_codigos` (`id`, `opcion`) VALUES
	(1, 'Ing. Ambiental'),
	(2, 'Ing. Alimentos'),
	(3, 'Ing. Eléctrica'),
	(4, 'Ing. Software'),
	(5, 'ASST'),
	(6, 'Extensión'),
	(7, 'Dirección de I+D+i');

-- Volcando estructura para tabla fetportafolioproyectos.programas
CREATE TABLE IF NOT EXISTS `programas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sufijo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.programas: ~7 rows (aproximadamente)
INSERT IGNORE INTO `programas` (`id`, `nombre`, `sufijo`) VALUES
	(1, 'Ingeniería Ambiental', 'AMB'),
	(2, 'Ingeniería de Alimentos', 'ALI'),
	(3, 'Ingeniería Software', 'SOF'),
	(4, 'Administración de la Seguridad y Salud en el Trabajo', 'SST'),
	(5, 'Coordinación Educación Continua', 'CEC'),
	(6, 'Dirección de I+D+i', 'IDD'),
	(7, 'Otro Programa', 'OTr');

-- Volcando estructura para tabla fetportafolioproyectos.proyectos
CREATE TABLE IF NOT EXISTS `proyectos` (
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `objetivo_general` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `programa_id` bigint unsigned NOT NULL,
  `procedencia_id` bigint unsigned NOT NULL,
  `procedencia_codigo_id` bigint unsigned NOT NULL,
  `tipologia_id` bigint unsigned NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `costo` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `anio` year NOT NULL,
  `pdf_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `proyectos_programa_id_foreign` (`programa_id`),
  KEY `proyectos_procedencia_id_foreign` (`procedencia_id`),
  KEY `proyectos_procedencia_codigo_id_foreign` (`procedencia_codigo_id`),
  KEY `proyectos_tipologia_id_foreign` (`tipologia_id`),
  CONSTRAINT `proyectos_procedencia_codigo_id_foreign` FOREIGN KEY (`procedencia_codigo_id`) REFERENCES `procedencia_codigos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `proyectos_procedencia_id_foreign` FOREIGN KEY (`procedencia_id`) REFERENCES `procedencias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `proyectos_programa_id_foreign` FOREIGN KEY (`programa_id`) REFERENCES `programas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `proyectos_tipologia_id_foreign` FOREIGN KEY (`tipologia_id`) REFERENCES `tipologias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.proyectos: ~27 rows (aproximadamente)
INSERT IGNORE INTO `proyectos` (`codigo`, `nombre`, `objetivo_general`, `programa_id`, `procedencia_id`, `procedencia_codigo_id`, `tipologia_id`, `fecha_inicio`, `fecha_fin`, `costo`, `created_at`, `updated_at`, `anio`, `pdf_url`) VALUES
	('ALI-1-1-2020-1', 'Elaboración de bebida fermentada kombucha saborizada con cholupa', 'Formular y caracterizar una bebida funcional a partir de hongo de té Kombucha adicionado de sacarosa, cúrcuma longa y sabor natural a Cholupa (Passiflora maliformis).', 2, 1, 1, 1, '2020-03-01', '2020-12-01', 5000000.00, '2025-03-02 14:44:03', '2025-03-02 14:44:03', '2020', NULL),
	('ALI-1-1-2020-2', 'Elaboración y caracterización de Néctares de Gulupa (Passiflora edulis f. edulis sims) con zanahoria (Daucus carota) y remolacha (Beta vulgaris) con uva Isabela (Vitis labrusca).', 'Laborar y caracterizar dos Néctares a base de mezcla de Gulupa y Zanahoria; y la mezcla de Remolacha y Uva Isabela', 2, 1, 1, 1, '2025-03-04', '2026-10-01', 2000000.00, '2025-03-02 14:56:37', '2025-03-02 14:56:37', '2020', NULL),
	('ALI-4-2-2025', 'proyecto prueba', 'primera prueba', 2, 2, 4, 2, '2025-02-26', '2025-03-26', 10000000.00, '2025-02-27 12:21:28', '2025-02-27 12:21:28', '2024', NULL),
	('AMB-1-1-2020-1', 'Proyección del crecimiento de los procesos de desertificación en el bosque seco tropical tatacoa ubicado en el municipio de villa vieja departamento del Huila.', 'Realizar un análisis multitemporal de la dinámica del proceso de desertificación en el bosque seco tropical tatacoa ubicado en el municipio de Villa Vieja departamento del Huila, por medio de los Sistemas de Información Geográfica.', 1, 1, 1, 1, '2024-06-01', '2025-03-31', 5670980.00, '2025-03-01 15:14:50', '2025-03-01 15:14:50', '2020', NULL),
	('AMB-4-1-2025-1', 'Ecommerce Diamond pijamas', 'ecommerce para un restaurante', 1, 2, 4, 1, '2025-02-26', '2026-07-27', 10000000.13, '2025-02-28 12:28:38', '2025-03-02 14:31:04', '2024', NULL),
	('AMB-4-1-2025-2', 'ecommerce', 'ecommerce para un restaurante', 1, 2, 4, 1, '2025-02-26', '2026-07-27', 10000000.00, '2025-02-28 12:33:20', '2025-02-28 12:33:20', '2024', NULL),
	('CEC-5-1-2025-1', 'prueba 2', 'esta es la segunda prueba de codigo', 5, 1, 5, 1, '2025-02-26', '2025-03-26', 10000000.00, '2025-02-27 12:51:22', '2025-02-27 12:51:22', '2025', NULL),
	('SOF-1-1-2020-1', 'DriverSecurity', 'Desarrollar una aplicación móvil capaz de prevenir la aparición de microsueños de los conductores sin importar su categoría.', 3, 1, 1, 1, '2025-04-02', '2025-06-20', 5200000.00, '2025-03-03 06:31:52', '2025-03-03 06:31:52', '2020', NULL),
	('SOF-1-1-2020-2', 'CanaimanCo', 'Desarrollar un videojuego 2D que logre ser de apoyo en el conocimiento de culturas dentro y fuera de nuestra universidad', 3, 1, 1, 1, '2020-02-04', '2024-07-03', 2542000.00, '2025-03-04 07:32:18', '2025-03-04 07:32:18', '2020', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1741037537/pdfs/tcdioax7hvlmjkdc184f.pdf'),
	('SOF-1-1-2025-1', 'Contaminación Invisible', 'Identificar la contaminación invisible por radiación electromagnética que generan los diferentes dispositivos móviles (Tecnología 3G, 4G, 5G).', 3, 1, 1, 1, '2025-03-04', '2026-01-03', 55000000.00, '2025-03-04 08:28:14', '2025-03-04 08:28:14', '2025', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1741040893/pdfs/phxtt4rlfou6l9hipbsg.pdf'),
	('SOF-4-1-2020-1', 'Plataforma de Gestión de Auditoría en la Seguridad de la Información basada en la norma ISO 27001 en el área de TI para las empresas.', 'Implementar una plataforma de Gestión de Auditoría en la Seguridad de la Información basada en la norma ISO 27001 en el área de TI para las empresas', 3, 1, 4, 1, '2020-02-03', '2020-08-03', 1200000.00, '2025-03-04 08:19:57', '2025-03-04 08:19:57', '2020', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1741040396/pdfs/jpgjogymx28pmcqmanzk.pdf'),
	('SOF-4-1-2020-2', 'Investigación y análisis de las vulnerabilidades producidas por ataques de software malicioso “malware” en empresas', 'Investigar y analizar las vulnerabilidades producidas por los softwares maliciosos, logrando obtener el conocimiento requerido conllevando así la prevención de infecciones en usuarios.', 3, 1, 4, 1, '2024-02-03', '2025-11-12', 6000000.00, '2025-03-04 08:24:49', '2025-03-04 08:24:49', '2020', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1741040688/pdfs/gz1japlnbcdmrqpc0mep.pdf'),
	('SOF-4-1-2025-1', 'prueba orden ultimo', 'aqui una descripcion random', 3, 3, 4, 1, '2025-03-30', '2025-08-30', 20000.00, '2025-03-31 00:03:55', '2025-03-31 00:03:55', '2025', NULL),
	('SOF-4-2-2025-1', 'Gestor administrativo de clientes', 'es un software administrativo de clientess para un gymnasio', 3, 1, 4, 2, '2025-02-27', '2025-11-30', 99999999.00, '2025-02-28 12:21:59', '2025-02-28 12:21:59', '2020', NULL),
	('SOF-5-1-2025-1', 'prueba 3', 'esta es la tercera prueba de codigo', 3, 1, 5, 1, '2025-02-26', '2025-03-26', 90000000.00, '2025-02-27 12:51:58', '2025-02-27 12:51:58', '2025', NULL),
	('SOF-5-1-2025-10', 'prueba con investigadores', 'otrra prueba con un array de investigadores', 3, 1, 5, 1, '2023-02-26', '2025-03-28', 90000000.00, '2025-02-27 14:33:59', '2025-02-27 14:33:59', '2025', NULL),
	('SOF-5-1-2025-2', 'Un proyecto de Ing. Soft', 'esta es la cuarta prueba de codigo', 3, 1, 5, 1, '2025-02-20', '2025-03-29', 90000000.00, '2025-02-27 12:53:52', '2025-03-03 06:28:12', '2021', NULL),
	('SOF-5-1-2025-3', 'prueba 5', 'esta es la cuarta prueba de codigo', 3, 1, 5, 1, '2025-02-20', '2025-03-29', 99000000.00, '2025-02-27 12:54:48', '2025-02-27 12:54:48', '2021', NULL),
	('SOF-5-1-2025-4', 'prueba 6', 'esta es la cuarta prueba de codigo', 3, 1, 5, 1, '2025-02-20', '2025-03-29', 99000000.00, '2025-02-27 13:20:09', '2025-02-27 13:20:09', '2021', NULL),
	('SOF-5-1-2025-5', 'prueba con investigadores', 'otrra prueba con un array de investigadores', 3, 1, 5, 1, '2025-02-26', '2025-03-28', 90000000.00, '2025-02-27 14:04:02', '2025-02-27 14:04:02', '2025', NULL),
	('SOF-5-1-2025-6', 'prueba con investigadores', 'otrra prueba con un array de investigadores', 3, 1, 5, 1, '2025-02-26', '2025-03-28', 90000000.00, '2025-02-27 14:08:56', '2025-02-27 14:08:56', '2019', NULL),
	('SOF-5-1-2025-7', 'prueba con investigadores', 'otrra prueba con un array de investigadores', 3, 1, 5, 1, '2025-02-26', '2025-03-28', 90000000.00, '2025-02-27 14:12:16', '2025-02-27 14:12:16', '2018', NULL),
	('SOF-5-1-2025-8', 'prueba con investigadores actualizado', 'otrra prueba con un array de investigadores', 3, 1, 5, 1, '2025-02-26', '2025-03-28', 90000000.00, '2025-02-27 14:20:17', '2025-03-05 14:05:47', '2019', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1741147546/pdfs/xsmnwe4lionvzd5tmpwg.pdf'),
	('SOF-5-1-2025-9', 'prueba con investigadores', 'otrra prueba con un array de investigadores', 3, 1, 5, 1, '2025-02-26', '2025-03-28', 90000000.00, '2025-02-27 14:32:07', '2025-02-27 14:32:07', '2021', NULL),
	('SST-1-1-2020-1', 'Diseño de un protocolo para la contratación de personas en situación de discapacidad para las empresas de la ciudad de Neiva', 'Diseñar una herramienta digital para la evaluación de posturas ergonómicas en las tareas administrativas dentro de la organización Funeraria San José, ubicada en la ciudad de Neiva', 4, 1, 1, 1, '2024-12-28', '2025-03-20', 2770000.00, '2025-03-01 14:09:11', '2025-03-01 14:09:11', '2020', NULL),
	('SST-1-1-2020-2', 'Factores de riesgos asociados a los trastornos músculo esqueléticos a los que están expuestos los trabajadores informales de la plaza de mercado MercaNeiva.', 'Identificar los factores de riesgos asociados a los trastornos músculo esqueléticos a los que están expuestos los trabajadores informales de la plaza de mercado MercaNeiva.', 4, 1, 1, 1, '2020-01-01', '2021-01-01', 2770000.00, '2025-03-01 15:06:56', '2025-03-01 15:06:56', '2020', NULL),
	('SST-5-1-2020-1', 'Evaluación de posturas ergonómicas en el área administrativa a partir de una herramienta digital', 'Diseñar  una  herramienta digita para la evaluación de posturas ergonómicas a partir de la metodología Ocra para el buen desarrollo de las  tareas administrativas dentro de la organización Funeraria San José, ubicada en la ciudad de Neiva.', 4, 1, 5, 1, '2023-07-12', '2024-03-06', 12000000.00, '2025-03-01 15:10:29', '2025-03-01 15:10:29', '2020', NULL);

-- Volcando estructura para tabla fetportafolioproyectos.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.roles: ~8 rows (aproximadamente)
INSERT IGNORE INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'super-admin', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(2, 'editor', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(3, 'creator', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(4, 'proyecto.all', 'web', '2025-03-30 08:25:44', '2025-03-30 08:25:44'),
	(5, 'tipologia.all', 'web', '2025-03-30 08:27:48', '2025-03-30 08:27:48'),
	(6, 'procedencia.all', 'web', '2025-03-30 08:28:33', '2025-03-30 08:28:33'),
	(7, 'viewer', 'web', '2025-03-30 08:47:57', '2025-03-30 08:47:57'),
	(8, 'procedencia.codigo.all', 'web', '2025-03-30 14:27:06', '2025-03-30 14:27:06');

-- Volcando estructura para tabla fetportafolioproyectos.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.role_has_permissions: ~66 rows (aproximadamente)
INSERT IGNORE INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(5, 1),
	(6, 1),
	(7, 1),
	(8, 1),
	(9, 1),
	(10, 1),
	(11, 1),
	(12, 1),
	(13, 1),
	(14, 1),
	(15, 1),
	(16, 1),
	(17, 1),
	(18, 1),
	(19, 1),
	(20, 1),
	(1, 2),
	(2, 2),
	(4, 2),
	(5, 2),
	(6, 2),
	(8, 2),
	(9, 2),
	(10, 2),
	(12, 2),
	(13, 2),
	(14, 2),
	(16, 2),
	(17, 2),
	(18, 2),
	(20, 2),
	(1, 3),
	(4, 3),
	(5, 3),
	(8, 3),
	(9, 3),
	(12, 3),
	(13, 3),
	(16, 3),
	(17, 3),
	(20, 3),
	(1, 4),
	(2, 4),
	(3, 4),
	(4, 4),
	(5, 5),
	(6, 5),
	(7, 5),
	(8, 5),
	(9, 6),
	(10, 6),
	(11, 6),
	(12, 6),
	(4, 7),
	(8, 7),
	(12, 7),
	(16, 7),
	(20, 7),
	(13, 8),
	(14, 8),
	(15, 8),
	(16, 8);

-- Volcando estructura para tabla fetportafolioproyectos.tipologias
CREATE TABLE IF NOT EXISTS `tipologias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `opcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.tipologias: ~5 rows (aproximadamente)
INSERT IGNORE INTO `tipologias` (`id`, `opcion`) VALUES
	(1, 'Investigación'),
	(2, 'Innovación'),
	(3, 'Desarrollo Tecnológico'),
	(4, 'Emprendimiento'),
	(5, 'Convenio/Consultoría');

-- Volcando estructura para tabla fetportafolioproyectos.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.users: ~1 rows (aproximadamente)
INSERT IGNORE INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Super Usuario', 'superadmin@example.com', NULL, '$2y$12$3MBcYEmdDN9kdwcQ5z/kUOlDWcLlL5anMvWsTNmCOexs3.4pVOHHi', NULL, '2025-03-30 06:15:40', '2025-03-30 08:04:53');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
