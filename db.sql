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

-- Volcando estructura para tabla fetportafolioproyectos.failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
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
DROP TABLE IF EXISTS `investigadores`;
CREATE TABLE IF NOT EXISTS `investigadores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.investigadores: ~72 rows (aproximadamente)
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
	(43, 'Luis Fernando Muñoz Suaza'),
	(47, 'Thalia Ramirez'),
	(54, 'jp hernannnder'),
	(57, 'annama'),
	(58, 'JSP Polania'),
	(87, 'Toby Castañeda Losada'),
	(88, 'Maria Isabel Castañeda Losada'),
	(91, 'Maria Paz'),
	(92, 'Jose Jose'),
	(94, 'dfdgfgfg'),
	(95, 'dfdfdfdf'),
	(96, 'Andres Camilo'),
	(97, 'Eiby Alexander Pulido Caviedes'),
	(98, 'Leonardo Andrés Silva'),
	(99, 'Diana Marcela Triana Peña'),
	(100, 'Angee Suaza'),
	(101, 'Cristian Salas Valencia'),
	(102, 'Juan Camilo Mallungo'),
	(103, 'Natalia Sandoval'),
	(104, 'Linda Daniela Cuellar'),
	(105, 'Diana Carolina Silva Yara'),
	(106, 'Gloria Andrea Wualtero'),
	(107, 'Lina Marcela Ramírez Rojas'),
	(108, 'Marcela Horta Calderon'),
	(109, 'Yesika Alejandra Losada Salazar'),
	(110, 'Anyenson Stid Garcia'),
	(111, 'Yiseth Paola Diaz Toloza'),
	(112, 'Nicolás Mauricio Cardoso Perdomo'),
	(113, 'Kevin Santiago Manrique Cardoso'),
	(114, 'Sergio Alexis Castro Hermosa'),
	(115, 'Diana Paola Montenegro'),
	(116, 'Oscar Iván Muñetón Lara'),
	(117, 'Hugo Andres Rivera'),
	(118, 'Marlon Estiven Castro Hio'),
	(119, 'Cristian Steven Casanova Anacona'),
	(120, 'Antonio Roveda Hoyos'),
	(121, 'Diego Andres Montenegro'),
	(122, 'Julian David Araque'),
	(123, 'David Santiago Naranjo Rivera'),
	(124, 'Sergio Andrés Trujillo Perdomo'),
	(125, 'Tania Yulieth Sánchez Tovar'),
	(126, 'Didier Alejandro López castillo'),
	(127, 'Karen stefany Arias Morales'),
	(128, 'Cristian Fabian Diaz Ambito'),
	(129, 'Yessica Andrea Vasquez González'),
	(130, 'Marco Coca Rodríguez'),
	(131, 'Jairo Andrés pinzón'),
	(132, 'Eduar Zuñiga Tamayo'),
	(133, 'Edwar Mayorga'),
	(134, 'Carlos Humberto Salcedo'),
	(135, 'Pablo Francisco Hernandez Lugo'),
	(136, 'Judith Bermeo');

-- Volcando estructura para tabla fetportafolioproyectos.investigador_proyecto
DROP TABLE IF EXISTS `investigador_proyecto`;
CREATE TABLE IF NOT EXISTS `investigador_proyecto` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `investigador_id` bigint unsigned NOT NULL,
  `proyecto_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invest_proyecto_unique` (`investigador_id`,`proyecto_id`,`deleted_at`),
  KEY `investigador_proyecto_investigador_id_index` (`investigador_id`),
  KEY `investigador_proyecto_proyecto_id_index` (`proyecto_id`),
  KEY `investigador_proyecto_proyecto_deleted_index` (`proyecto_id`,`deleted_at`),
  CONSTRAINT `investigador_proyecto_investigador_id_foreign` FOREIGN KEY (`investigador_id`) REFERENCES `investigadores` (`id`) ON DELETE CASCADE,
  CONSTRAINT `investigador_proyecto_proyecto_id_foreign` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=177 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.investigador_proyecto: ~105 rows (aproximadamente)
INSERT IGNORE INTO `investigador_proyecto` (`id`, `investigador_id`, `proyecto_id`, `created_at`, `deleted_at`) VALUES
	(1, 1, 21, '2025-04-15 22:43:29', '2025-04-20 07:33:33'),
	(2, 2, 21, '2025-04-15 22:43:29', '2025-04-20 07:33:33'),
	(3, 3, 21, '2025-04-15 22:43:29', '2025-04-20 07:33:33'),
	(4, 5, 19, '2025-04-15 22:43:29', NULL),
	(6, 4, 11, '2025-04-15 22:43:29', '2025-04-20 07:35:53'),
	(7, 5, 11, '2025-04-15 22:43:29', '2025-04-20 07:35:53'),
	(8, 7, 30, '2025-04-15 22:43:29', NULL),
	(9, 8, 30, '2025-04-15 22:43:29', NULL),
	(10, 9, 30, '2025-04-15 22:43:29', NULL),
	(11, 10, 30, '2025-04-15 22:43:29', NULL),
	(12, 11, 30, '2025-04-15 22:43:29', NULL),
	(13, 12, 30, '2025-04-15 22:43:29', NULL),
	(14, 13, 30, '2025-04-15 22:43:29', NULL),
	(15, 14, 30, '2025-04-15 22:43:29', NULL),
	(17, 16, 31, '2025-04-15 22:43:29', NULL),
	(18, 17, 31, '2025-04-15 22:43:29', NULL),
	(19, 18, 31, '2025-04-15 22:43:29', NULL),
	(20, 19, 31, '2025-04-15 22:43:29', NULL),
	(21, 20, 31, '2025-04-15 22:43:29', NULL),
	(25, 21, 4, '2025-04-15 22:43:29', NULL),
	(26, 22, 4, '2025-04-15 22:43:29', NULL),
	(27, 23, 4, '2025-04-15 22:43:29', NULL),
	(30, 2, 10, '2025-04-15 22:43:29', NULL),
	(31, 6, 10, '2025-04-15 22:43:29', NULL),
	(32, 4, 10, '2025-04-15 22:43:29', NULL),
	(33, 4, 1, '2025-04-15 22:43:29', NULL),
	(34, 6, 1, '2025-04-15 22:43:29', NULL),
	(36, 24, 2, '2025-04-15 22:43:29', NULL),
	(37, 25, 2, '2025-04-15 22:43:29', NULL),
	(38, 26, 2, '2025-04-15 22:43:29', NULL),
	(39, 27, 1, '2025-04-15 22:43:29', NULL),
	(40, 6, 22, '2025-04-15 22:43:29', NULL),
	(41, 28, 13, '2025-04-15 22:43:29', NULL),
	(42, 29, 13, '2025-04-15 22:43:29', NULL),
	(43, 30, 13, '2025-04-15 22:43:29', NULL),
	(45, 31, 14, '2025-04-15 22:43:29', NULL),
	(46, 32, 14, '2025-04-15 22:43:29', NULL),
	(47, 33, 14, '2025-04-15 22:43:29', NULL),
	(48, 30, 14, '2025-04-15 22:43:29', NULL),
	(49, 34, 16, '2025-04-15 22:43:29', NULL),
	(50, 35, 16, '2025-04-15 22:43:29', NULL),
	(51, 36, 17, '2025-04-15 22:43:29', NULL),
	(52, 37, 17, '2025-04-15 22:43:29', NULL),
	(53, 38, 17, '2025-04-15 22:43:29', NULL),
	(54, 39, 17, '2025-04-15 22:43:29', NULL),
	(55, 40, 17, '2025-04-15 22:43:29', NULL),
	(56, 41, 15, '2025-04-15 22:43:29', NULL),
	(57, 42, 15, '2025-04-15 22:43:29', NULL),
	(58, 43, 15, '2025-04-15 22:43:29', NULL),
	(59, 40, 15, '2025-04-15 22:43:29', NULL),
	(60, 34, 28, '2025-04-15 22:43:29', NULL),
	(61, 36, 28, '2025-04-15 22:43:29', NULL),
	(62, 31, 18, '2025-04-15 22:43:29', NULL),
	(79, 31, 9, '2025-04-15 22:43:29', NULL),
	(81, 31, 5, '2025-04-15 22:43:29', NULL),
	(82, 54, 32, '2025-04-15 22:43:29', '2025-04-19 19:44:24'),
	(83, 47, 32, '2025-04-15 22:43:29', NULL),
	(85, 47, 34, '2025-04-15 22:43:29', NULL),
	(86, 31, 36, '2025-04-15 22:43:29', NULL),
	(87, 47, 29, '2025-04-15 22:43:29', '2025-04-20 07:31:01'),
	(88, 31, 29, '2025-04-15 22:43:29', '2025-04-20 07:31:01'),
	(89, 4, 29, '2025-04-15 22:43:29', '2025-04-20 07:31:01'),
	(92, 31, 37, '2025-04-15 22:43:29', NULL),
	(93, 47, 37, '2025-04-15 22:43:29', NULL),
	(94, 57, 29, '2025-04-15 22:43:29', '2025-04-20 07:31:01'),
	(95, 58, 29, '2025-04-15 22:43:29', '2025-04-20 07:31:01'),
	(96, 54, 29, '2025-04-15 22:43:29', '2025-04-20 07:31:01'),
	(97, 47, 31, '2025-04-15 22:43:29', NULL),
	(98, 31, 35, '2025-04-15 22:43:29', NULL),
	(100, 47, 38, '2025-04-15 22:43:29', NULL),
	(104, 47, 40, '2025-04-15 22:43:29', NULL),
	(105, 87, 31, '2025-04-16 01:48:23', '2025-04-16 06:49:50'),
	(106, 87, 31, '2025-04-16 01:49:50', NULL),
	(107, 88, 31, '2025-04-16 02:00:08', '2025-04-16 07:00:38'),
	(108, 88, 31, '2025-04-16 02:00:47', NULL),
	(111, 91, 31, '2025-04-16 04:48:15', NULL),
	(113, 87, 27, '2025-04-17 21:06:17', '2025-04-20 07:24:35'),
	(114, 92, 42, '2025-04-17 23:14:03', NULL),
	(116, 94, 26, '2025-04-17 23:49:05', '2025-04-18 04:49:19'),
	(117, 95, 26, '2025-04-17 23:49:05', '2025-04-18 04:49:19'),
	(118, 47, 43, '2025-04-18 12:14:33', NULL),
	(119, 96, 12, '2025-04-19 10:02:05', NULL),
	(120, 97, 18, '2025-04-19 19:34:13', NULL),
	(121, 98, 7, '2025-04-19 19:35:51', NULL),
	(122, 98, 8, '2025-04-19 19:37:45', NULL),
	(123, 99, 9, '2025-04-19 19:40:39', NULL),
	(124, 100, 5, '2025-04-19 19:42:35', NULL),
	(125, 9, 32, '2025-04-19 19:44:24', NULL),
	(126, 101, 33, '2025-04-19 19:45:26', NULL),
	(127, 102, 34, '2025-04-19 19:46:55', NULL),
	(128, 103, 35, '2025-04-19 19:48:34', NULL),
	(129, 104, 36, '2025-04-19 19:49:38', NULL),
	(130, 105, 37, '2025-04-19 19:50:56', NULL),
	(131, 7, 38, '2025-04-19 19:52:15', NULL),
	(132, 106, 40, '2025-04-19 19:53:02', NULL),
	(133, 107, 42, '2025-04-19 19:53:55', NULL),
	(134, 108, 43, '2025-04-19 19:54:50', NULL),
	(135, 109, 44, '2025-04-19 20:03:43', NULL),
	(136, 110, 45, '2025-04-19 20:05:44', NULL),
	(137, 111, 46, '2025-04-19 20:09:34', NULL),
	(138, 112, 47, '2025-04-19 20:11:16', NULL),
	(139, 113, 48, '2025-04-19 20:13:13', NULL),
	(144, 114, 12, '2025-04-20 06:40:11', NULL),
	(145, 115, 12, '2025-04-20 06:40:11', NULL),
	(146, 116, 12, '2025-04-20 06:40:11', NULL),
	(147, 117, 20, '2025-04-20 06:58:09', NULL),
	(148, 116, 20, '2025-04-20 06:58:09', NULL),
	(149, 118, 22, '2025-04-20 07:06:02', NULL),
	(150, 4, 22, '2025-04-20 07:06:02', NULL),
	(151, 119, 22, '2025-04-20 07:06:02', NULL),
	(152, 116, 23, '2025-04-20 07:09:26', NULL),
	(153, 120, 24, '2025-04-20 07:11:51', NULL),
	(154, 121, 24, '2025-04-20 07:11:51', NULL),
	(155, 116, 24, '2025-04-20 07:11:51', NULL),
	(156, 120, 25, '2025-04-20 07:14:16', NULL),
	(157, 121, 25, '2025-04-20 07:14:16', NULL),
	(158, 116, 25, '2025-04-20 07:14:16', NULL),
	(159, 122, 26, '2025-04-20 07:20:53', NULL),
	(160, 114, 26, '2025-04-20 07:20:53', NULL),
	(161, 123, 27, '2025-04-20 07:24:35', NULL),
	(162, 124, 27, '2025-04-20 07:24:35', NULL),
	(163, 125, 27, '2025-04-20 07:24:35', NULL),
	(164, 126, 27, '2025-04-20 07:24:35', NULL),
	(165, 127, 27, '2025-04-20 07:24:35', NULL),
	(166, 128, 27, '2025-04-20 07:24:35', NULL),
	(167, 129, 27, '2025-04-20 07:24:35', NULL),
	(168, 130, 28, '2025-04-20 07:28:18', NULL),
	(169, 131, 28, '2025-04-20 07:28:18', NULL),
	(170, 132, 28, '2025-04-20 07:28:18', NULL),
	(171, 133, 28, '2025-04-20 07:28:18', NULL),
	(172, 134, 28, '2025-04-20 07:28:18', NULL),
	(173, 135, 28, '2025-04-20 07:28:18', NULL),
	(174, 136, 29, '2025-04-20 07:31:01', NULL),
	(175, 136, 21, '2025-04-20 07:33:33', NULL),
	(176, 136, 11, '2025-04-20 07:35:53', NULL);

-- Volcando estructura para tabla fetportafolioproyectos.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.migrations: ~17 rows (aproximadamente)
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
	(15, '2025_03_29_031905_create_permission_tables', 1),
	(16, '2025_04_06_013341_drop_foreign_proyecto_id_to_investigador_proyecto', 2),
	(17, '2025_04_06_013428_add_id_to_proyectos_table', 2),
	(18, '2025_04_06_022547_add_proyecto_id_to_investigador_proyecto', 3),
	(19, '2025_04_10_234116_create_route_permissions_table', 4),
	(20, '2025_04_15_203803_add_timestamps_and_soft_delete_to_investigador_proyecto', 5);

-- Volcando estructura para tabla fetportafolioproyectos.model_has_permissions
DROP TABLE IF EXISTS `model_has_permissions`;
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
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.model_has_roles: ~3 rows (aproximadamente)
INSERT IGNORE INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(4, 'App\\Models\\User', 2),
	(7, 'App\\Models\\User', 7),
	(13, 'App\\Models\\User', 9);

-- Volcando estructura para tabla fetportafolioproyectos.password_reset_tokens
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.password_reset_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla fetportafolioproyectos.permissions
DROP TABLE IF EXISTS `permissions`;
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
DROP TABLE IF EXISTS `personal_access_tokens`;
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
DROP TABLE IF EXISTS `procedencias`;
CREATE TABLE IF NOT EXISTS `procedencias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `opcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.procedencias: ~5 rows (aproximadamente)
INSERT IGNORE INTO `procedencias` (`id`, `opcion`) VALUES
	(1, 'Semillero de Investigación'),
	(2, 'Grupo de Investigación'),
	(3, 'Aula de clase'),
	(4, 'Extensión'),
	(5, 'Programa Académico - Prácticas'),
	(13, 'pronmsh'),
	(14, 'fgfgfg'),
	(15, 'procedencia text'),
	(16, 'Educación Continua');

-- Volcando estructura para tabla fetportafolioproyectos.procedencia_codigos
DROP TABLE IF EXISTS `procedencia_codigos`;
CREATE TABLE IF NOT EXISTS `procedencia_codigos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `opcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.procedencia_codigos: ~7 rows (aproximadamente)
INSERT IGNORE INTO `procedencia_codigos` (`id`, `opcion`) VALUES
	(1, 'Ing. Ambiental'),
	(2, 'Ing. Alimentos'),
	(3, 'Ing. Eléctrica'),
	(4, 'Ing. Software'),
	(5, 'ASST'),
	(6, 'Extensión'),
	(7, 'Dirección de I+D+i'),
	(11, 'ssdf'),
	(12, 'Ejemplo');

-- Volcando estructura para tabla fetportafolioproyectos.programas
DROP TABLE IF EXISTS `programas`;
CREATE TABLE IF NOT EXISTS `programas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sufijo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.programas: ~7 rows (aproximadamente)
INSERT IGNORE INTO `programas` (`id`, `nombre`, `sufijo`) VALUES
	(1, 'Ingeniería Ambiental', 'AMB'),
	(2, 'Ingeniería de Alimentos', 'ALI'),
	(3, 'Ingeniería Software', 'SOF'),
	(4, 'Administración de la Seguridad y Salud en el Trabajo', 'SST'),
	(5, 'Coordinación Educación Continua', 'CEC'),
	(6, 'Dirección de I+D+i', 'IDD'),
	(8, 'Ingenieria Sanitaria', 'SANIC'),
	(16, 'Ingenieria Industrial', 'IIA'),
	(17, 'Ingenieria Eléctrica', 'LIE');

-- Volcando estructura para tabla fetportafolioproyectos.proyectos
DROP TABLE IF EXISTS `proyectos`;
CREATE TABLE IF NOT EXISTS `proyectos` (
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `objetivo_general` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `proyectos_codigo_unique` (`codigo`),
  KEY `proyectos_programa_id_foreign` (`programa_id`),
  KEY `proyectos_procedencia_id_foreign` (`procedencia_id`),
  KEY `proyectos_procedencia_codigo_id_foreign` (`procedencia_codigo_id`),
  KEY `proyectos_tipologia_id_foreign` (`tipologia_id`),
  CONSTRAINT `proyectos_procedencia_codigo_id_foreign` FOREIGN KEY (`procedencia_codigo_id`) REFERENCES `procedencia_codigos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `proyectos_procedencia_id_foreign` FOREIGN KEY (`procedencia_id`) REFERENCES `procedencias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `proyectos_programa_id_foreign` FOREIGN KEY (`programa_id`) REFERENCES `programas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `proyectos_tipologia_id_foreign` FOREIGN KEY (`tipologia_id`) REFERENCES `tipologias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.proyectos: ~44 rows (aproximadamente)
INSERT IGNORE INTO `proyectos` (`codigo`, `nombre`, `objetivo_general`, `programa_id`, `procedencia_id`, `procedencia_codigo_id`, `tipologia_id`, `fecha_inicio`, `fecha_fin`, `costo`, `created_at`, `updated_at`, `anio`, `pdf_url`, `id`) VALUES
	('ALI-1-1-2020-1', 'Elaboración de bebida fermentada kombucha saborizada con cholupa', 'Formular y caracterizar una bebida funcional a partir de hongo de té Kombucha adicionado de sacarosa, cúrcuma longa y sabor natural a Cholupa (Passiflora maliformis).', 2, 1, 1, 1, '2020-03-01', '2020-12-01', 5000000.00, '2025-03-02 14:44:03', '2025-03-02 14:44:03', '2020', NULL, 1),
	('ALI-1-1-2020-2', 'Elaboración y caracterización de Néctares de Gulupa (Passiflora edulis f. edulis sims) con zanahoria (Daucus carota) y remolacha (Beta vulgaris) con uva Isabela (Vitis labrusca).', 'Laborar y caracterizar dos Néctares a base de mezcla de Gulupa y Zanahoria; y la mezcla de Remolacha y Uva Isabela', 2, 1, 1, 1, '2025-03-04', '2026-10-01', 2000000.00, '2025-03-02 14:56:37', '2025-04-19 01:20:59', '2020', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1745007656/pdfs/ALI-1-1-2020-2.pdf', 2),
	('AMB-1-1-2020-1', 'Proyección del crecimiento de los procesos de desertificación en el bosque seco tropical tatacoa ubicado en el municipio de villa vieja departamento del Huila.', 'Realizar un análisis multitemporal de la dinámica del proceso de desertificación en el bosque seco tropical tatacoa ubicado en el municipio de Villa Vieja departamento del Huila, por medio de los Sistemas de Información Geográfica.', 1, 1, 1, 1, '2024-06-01', '2025-03-31', 5670980.00, '2025-03-01 15:14:50', '2025-03-01 15:14:50', '2020', NULL, 4),
	('SST-1-1-2023-1', 'Diseño de un programa de bienestar laboral- Empresa PROALPAN', 'esto es una prueba, para que el anio se sincronize con la fecha de inicio', 4, 5, 1, 1, '2023-02-04', '2026-02-05', 5600000.00, '2025-04-06 05:30:48', '2025-04-19 19:42:35', '2023', NULL, 5),
	('ALI-2-1-2025-1', 'Aprovechamiento de productos alimentarios en la fundación banco diocesano de alimentos.', 'Evaluar estrategias de aprovechamiento de materias primas alimentarias en el Banco Diocesano de  Alimentos.', 2, 5, 2, 1, '2025-04-01', '2025-04-30', 12000.00, '2025-04-06 02:21:21', '2025-04-19 19:35:51', '2025', NULL, 7),
	('ALI-1-1-2025-1', 'Capacitación e implementación de estrategias de manejo inocuo de insumos alimentarios, dirigidas a diversas fundaciones de la ciudad de Neiva, Huila, Colombia.', 'Implementación de estrategias de manejo inocuo de insumos alimentarios, dirigidas a diversas', 2, 5, 1, 1, '2025-04-01', '2025-04-30', 24224.00, '2025-04-06 02:35:19', '2025-04-19 19:37:45', '2025', NULL, 8),
	('SST-1-1-2025-1', 'Diseño de un programa de pausas activas y hábitos de vida saludable.', 'ghjghj', 4, 5, 1, 1, '2025-04-02', '2025-04-30', 6455446.00, '2025-04-06 02:46:16', '2025-04-19 19:39:08', '2025', NULL, 9),
	('AMB-4-1-2025-1', 'Ecommerce Diamond pijamas', 'ecommerce para un restaurante', 1, 2, 4, 1, '2025-02-26', '2026-07-27', 10000000.13, '2025-02-28 12:28:38', '2025-03-02 14:31:04', '2024', NULL, 10),
	('CEC-4-1-2021-1', 'Contrato de Aceptación de Oferta de la Invitación Pública del proceso de Mínima Cuantía N° 009 de 2021 suscrito entre el Municipio de Aipe-Huila y la Fundacion Escuela Tecnologica de Neiva-Jesus Oviedo Perez.', 'Prestación de servicios para la realización de capacitaciones virtuales y presenciales en los cursos Preicfes Saber 11° dirigido a los alumnos de las Instituciones educativas oficiales del municipio de Aipe Departamento del Huila.', 5, 16, 4, 1, '2021-02-10', '2021-03-27', 13200000.00, '2025-02-28 12:33:20', '2025-04-20 07:35:53', '2021', NULL, 11),
	('IDD-5-1-2021-1', 'Fortalecimiento de competencias en investigación, innovación y emprendimiento', 'Fortalecer los conocimientos y habilidades de los estudiantes mediante sesiones de formación con expertos brindando conocimientos y herramientas que desarrollen estudiantes altamente competitivos y competentes.', 6, 1, 5, 1, '2021-02-26', '2021-07-26', 10000000.00, '2025-02-27 12:51:22', '2025-04-20 06:40:11', '2021', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1745038837/pdfs/IDD-5-1-2021-1.pdf', 12),
	('SOF-1-1-2020-1', 'DriverSecurity', 'Desarrollar una aplicación móvil capaz de prevenir la aparición de microsueños de los conductores sin importar su categoría.', 3, 1, 1, 1, '2025-04-02', '2025-06-20', 5200000.00, '2025-03-03 06:31:52', '2025-03-03 06:31:52', '2020', NULL, 13),
	('SOF-1-1-2020-2', 'CanaimanCo', 'Desarrollar un videojuego 2D que logre ser de apoyo en el conocimiento de culturas dentro y fuera de nuestra universidad', 3, 1, 1, 1, '2020-02-04', '2024-07-03', 2542000.00, '2025-03-04 07:32:18', '2025-03-04 07:32:18', '2020', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1741037537/pdfs/tcdioax7hvlmjkdc184f.pdf', 14),
	('SOF-1-1-2025-1', 'Contaminación Invisible', 'Identificar la contaminación invisible por radiación electromagnética que generan los diferentes dispositivos móviles (Tecnología 3G, 4G, 5G).', 3, 1, 1, 1, '2025-03-04', '2026-01-03', 55000000.00, '2025-03-04 08:28:14', '2025-03-04 08:28:14', '2025', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1741040893/pdfs/phxtt4rlfou6l9hipbsg.pdf', 15),
	('SOF-4-1-2020-1', 'Plataforma de Gestión de Auditoría en la Seguridad de la Información basada en la norma ISO 27001 en el área de TI para las empresas.', 'Implementar una plataforma de Gestión de Auditoría en la Seguridad de la Información basada en la norma ISO 27001 en el área de TI para las empresas', 3, 1, 4, 1, '2020-02-03', '2020-08-03', 1200000.00, '2025-03-04 08:19:57', '2025-03-04 08:19:57', '2020', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1741040396/pdfs/jpgjogymx28pmcqmanzk.pdf', 16),
	('SOF-4-1-2020-2', 'Investigación y análisis de las vulnerabilidades producidas por ataques de software malicioso “malware” en empresas', 'Investigar y analizar las vulnerabilidades producidas por los softwares maliciosos, logrando obtener el conocimiento requerido conllevando así la prevención de infecciones en usuarios.', 3, 1, 4, 1, '2024-02-03', '2025-11-12', 6000000.00, '2025-03-04 08:24:49', '2025-03-04 08:24:49', '2020', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1741040688/pdfs/gz1japlnbcdmrqpc0mep.pdf', 17),
	('SOF-4-1-2025-1', 'Ahorro y eficiencia energética en tiempo de Covid', 'Crear conciencia en el ahorro del consumo de energía eléctrica en tiempos de pandemia COVID-19, mejorando la calidad de vida y teniendo un efecto colateral en el pago de las facturas de servicios públicos.', 3, 5, 4, 1, '2025-03-30', '2025-08-30', 20000.00, '2025-03-31 00:03:55', '2025-04-19 19:34:13', '2025', NULL, 18),
	('SOF-4-2-2025-1', 'Gestor administrativo de clientes', 'es un software administrativo de clientess para un gymnasio', 3, 1, 4, 2, '2025-02-27', '2025-11-30', 99999999.00, '2025-02-28 12:21:59', '2025-02-28 12:21:59', '2020', NULL, 19),
	('IDD-5-1-2021-2', 'Servicio de Consultoria Empresarial para la Creación de una Operadora Turistica de la Organización Casablanca SAS', 'Desarrollar una consultoría empresarial para la ORGANIZACIÓN CASABLANCA SAS, establecimiento de propiedad del CONTRATANTE, en el municipio de Garzón (H), que le permita a ésta, desarrollar el prototipo de innovación funcional del servicio turístico experiencial y vivencial a partir de la identificación de las necesidades del entorno', 6, 1, 5, 1, '2021-02-26', '2021-07-26', 30000000.00, '2025-02-27 12:51:58', '2025-04-20 06:58:09', '2021', NULL, 20),
	('CEC-5-1-2022-2', 'Contrato por Prestación de Servicios Profesionales N° 148 de 2021, suscrito entre el Municipio de Rivera y la Fundación Escuela Tecnológica de Neiva "Jesus Oviedo Perez"', 'Prestación de servicios profesionales por parte del Contratista y a favor del Municipio, para el diseño, desarrollo y aplicación del programa de formación y capacitación de los estudiantes del grado undécimo de las Instituciones Educativas del municipio de Rivera (H) para la prestación de las Pruebas de Estado "SABER 11", durante la vigencia 2021.', 5, 16, 5, 1, '2022-02-26', '2022-06-28', 40000000.00, '2025-02-27 14:33:59', '2025-04-20 07:33:33', '2022', NULL, 21),
	('SOF-4-2-2024-1', 'Campus Navigator', 'Es una herramienta interactiva diseñada para facilitar la orientación de estudiantes nuevos y visitantes dentro del campus universitario. Este software proporciona un mapa detallado de los bloques de la universidad, destacando puntos clave como oficinas administrativas, áreas de bienestar y otros componentes esenciales para la formación de los estudiantes.  Al hacer clic en los iconos azules del mapa, se despliega una tarjeta flotante que muestra información clave sobre cada entidad universitaria, incluyendo su nombre y su impacto en el desarrollo académico y personal de los estudiantes. Además, las tarjetas incluyen un botón de eventos que revela una columna lateral con los últimos eventos organizados por cada área, fomentando la participación activa de la comunidad universitaria en actividades de bienestar, apoyo psicológico y otras iniciativas clave.  Campus Navigator no solo orienta a los estudiantes en su recorrido por la universidad, sino que también promueve la interacción y el aprovechamiento de los recursos que la institución ofrece para su crecimiento integral.', 3, 3, 4, 2, '2024-08-27', '2024-10-19', 800000.00, '2025-02-27 12:53:52', '2025-04-20 07:06:02', '2024', NULL, 22),
	('IDD-7-1-2021-1', 'Servicio de Formación Continua Empresarial en Modalidad Dual', 'Diseñar un prototipo funcional de servicio de formación continua bajo la modalidad Dual, para el fortalecimiento de competencias y cualificación del talento humano del sector empresarial del departamento del Huila', 6, 1, 7, 1, '2021-02-20', '2021-06-29', 30000000.00, '2025-02-27 12:54:48', '2025-04-20 07:09:26', '2021', NULL, 23),
	('IDD-7-1-2021-2', 'ASESORÍA Y DISEÑO DE CONTENIDOS DE ORANGE CENTRO EMPRESARIAL DE LA CAMARA DE COMERCIO DEL HUILA, ASÍ COMO DEL PORTAFOLIO DE SERVICIOS Y PROGRAMAS DE FORMACIÓN', 'PRESTAR EL SERVICIO DE ASESORÍA Y DISEÑO DE CONTENIDOS DE ORANGE CENTRO EMPRESARIAL DE LA CAMARA DE COMERCIO DEL HUILA, ASÍ COMO DEL PORTAFOLIO DE SERVICIOS Y PROGRAMAS DE FORMACIÓN', 6, 1, 7, 1, '2021-02-20', '2021-08-29', 40000000.00, '2025-02-27 13:20:09', '2025-04-20 07:11:51', '2021', NULL, 24),
	('IDD-7-1-2021-3', 'XI FERIA DE INVESTIGACION, INNOVACION Y EMPRENDIMIENO INNOEM', 'Fomentar las actividades de Ciencia, Tecnología e innovación resultantes de los semilleros de investigación y/o proyectos de aulas de las instituciones de educación superior del departamento del Huila.', 6, 1, 7, 1, '2021-02-26', '2021-07-28', 40000000.00, '2025-02-27 14:04:02', '2025-04-20 07:14:16', '2021', NULL, 25),
	('LIE-5-1-2021-1', 'Construcción de un Prototipo Móvil de Producción de Energías Renovables, como Herramienta Educativa para Diferentes Grupos Sociales en Cinco Municipios del Departamento del Huila', 'Construir un prototipo de dispositivo móvil de producción eficiente de energía renovable, fotovoltaica y eólica, como herramienta educativa para diferentes grupos sociales en municipios del departamento del Huila', 17, 1, 5, 1, '2021-01-26', '2021-12-28', 3000000.00, '2025-02-27 14:08:56', '2025-04-20 07:20:53', '2021', NULL, 26),
	('AMB-1-1-2022-1', 'Huella hídrica de la producción de vino artesanal en el corregimiento del Caguan, Huila', 'Determinar la huella hídrica de la producción de vino en el corregimiento del Caguan, Huila.', 1, 1, 1, 1, '2022-02-26', '2022-12-28', 2980000000.00, '2025-02-27 14:12:16', '2025-04-20 07:24:35', '2022', NULL, 27),
	('SOF-4-1-2022-1', 'Repositorio Proyectos de Investigación.', 'Desarrollar un Sistema de Información transversal de investigación de la Fundación Escuela Tecnología de Neiva.', 3, 1, 4, 1, '2022-02-26', '2023-03-28', 1000000.00, '2025-02-27 14:20:17', '2025-04-20 07:28:18', '2022', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1741147546/pdfs/SOF-4-1-2022-1.pdf', 28),
	('CEC-5-1-2022-1', 'Convenio de Asociación N° 2711 de 2021, Suscrito entre el Municipio de Neiva y Fundación Escuela Tecnológica de Neiva "Jesús Oviedo Perez"', 'Aunar esfuerzos para fortalecer y contribuir en lal construcción de un "sistema de formación y evaluación por competencias", en las instituciones educativas oficiales del Municipio de Neiva, a partir del diseño y desarrollo de un programa específico y especializado de formación y evaluación, para los estudiantes y docentes de los colegios públicos de las trece (13) institución de educación categorizadas en clasificación "C" del municipio de Neiva-Huila, en las Pruebas de Estado Saber 11°.', 5, 16, 5, 1, '2022-02-26', '2022-08-28', 162586000.00, '2025-02-27 14:32:07', '2025-04-20 07:31:01', '2022', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1743924559/pdfs/CEC-5-1-2022-1.pdf', 29),
	('SST-1-1-2020-1', 'Diseño de un protocolo para la contratación de personas en situación de discapacidad para las empresas de la ciudad de Neiva', 'Diseñar una herramienta digital para la evaluación de posturas ergonómicas en las tareas administrativas dentro de la organización Funeraria San José, ubicada en la ciudad de Neiva', 4, 1, 1, 1, '2024-12-28', '2025-03-20', 2770000.00, '2025-03-01 14:09:11', '2025-04-19 10:47:01', '2020', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1745041620/pdfs/SST-1-1-2020-1.pdf', 30),
	('SST-5-1-2020-1', 'Factores de riesgos asociados a los trastornos músculo esqueléticos a los que están expuestos los trabajadores informales de la plaza de mercado MercaNeiva.', 'Identificar los factores de riesgos asociados a los trastornos músculo esqueléticos a los que están expuestos los trabajadores informales de la plaza de mercado MercaNeiva.', 4, 1, 5, 1, '2020-01-01', '2021-01-01', 2770000.00, '2025-03-01 15:06:56', '2025-04-19 10:32:32', '2020', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1745040750/pdfs/SST-5-1-2020-1.pdf', 31),
	('SST-1-1-2025-2', 'Diseño de un programa de bienestar laboral - Empresa LAS BRISAS', 'jskldksdkjskjdkjsdjkksjd', 4, 1, 1, 1, '2025-01-02', '2028-10-05', 45000000.00, '2025-04-06 08:41:08', '2025-04-19 19:44:24', '2025', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1745011460/pdfs/SST-1-1-2025-2.pdf', 32),
	('SST-1-1-2023-2', 'Diseño de manual de seguridad del paciente- Visualcenter', 'fjghfgjfgj', 4, 5, 1, 1, '2023-02-01', '2025-07-17', 545645.00, '2025-04-06 08:49:57', '2025-04-19 19:45:26', '2023', NULL, 33),
	('SST-1-1-2020-2', 'Revision y actualizacion de la documentacion de espacios confinados acorde a las res-0491 de 2020- Guacamayas Oil', 'urrra esta quedando gennial', 4, 1, 1, 1, '2020-01-06', '2025-04-30', 48984.00, '2025-04-06 10:36:51', '2025-04-19 19:46:55', '2020', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1743917810/pdfs/SST-1-1-2020-2.pdf', 34),
	('SST-1-1-2025-3', 'Diseño de un programa de capacitación lúdica ¨Jugando y aprendiendo a prevenir¨- Piscicola New York', 'gfhfghfgh', 4, 1, 1, 1, '2025-04-03', '2025-04-06', 54545.00, '2025-04-06 11:15:32', '2025-04-19 19:48:34', '2025', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1743920130/pdfs/SST-1-1-2025-3.pdf', 35),
	('AMB-1-2-2025-1', 'Diseño guía de humanización en los servicios de salud - Visualcenter', 'gdgfgfd', 1, 5, 1, 2, '2025-04-02', '2025-04-06', 53535.00, '2025-04-06 11:41:32', '2025-04-19 19:49:38', '2025', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1743921691/pdfs/AMB-1-2-2025-1.pdf', 36),
	('SST-1-1-2025-4', 'Diseño y aplicación de instrumento de base de datos de accidente y enfermedades laborales- ESE Carmen Emilia Ospina', 'jkhjkhjkj', 4, 1, 1, 1, '2025-04-02', '2025-04-06', 566556.00, '2025-04-06 12:42:37', '2025-04-19 19:50:56', '2025', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1743925356/pdfs/SST-1-1-2025-4.pdf', 37),
	('SST-5-3-2025-1', 'Diseño de un programa de riesgo quimico de la ese carmen emilia ospina - ESE Carmen Emilia Ospina', 'fgjfghjghjghjj', 4, 5, 5, 3, '2025-02-05', '2025-04-07', 345345.00, '2025-04-07 18:18:29', '2025-04-19 19:52:15', '2025', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1744031907/pdfs/SST-5-3-2025-1.pdf', 38),
	('SST-5-41-2025-1', 'Diseño plan de prevención, preparación y respuesta ante emergencias en la Registraduría Nacional Del Estado Civil Auxiliar Neiva - Huila- Registraduría', 'sdfdsfdsf', 4, 5, 5, 41, '2025-04-04', '2025-04-24', 3434.00, '2025-04-13 03:22:47', '2025-04-19 19:53:02', '2025', NULL, 40),
	('SST-5-3-2024-1', 'Diseño y aplicación de instrumento de base de datos de accidente y enfermedades laborales- ESE Carmen Emilia Ospina', 'pagina web', 4, 5, 5, 3, '2024-10-01', '2025-04-30', 500.00, '2025-04-18 04:14:03', '2025-04-19 19:53:55', '2024', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1744931642/pdfs/SST-5-3-2024-1.pdf', 42),
	('AMB-1-3-2025-1', 'Formulacion del Plan de responsabilidad social empresarial E y J Services Group', 'dfgdfgdfg', 1, 5, 1, 3, '2025-04-17', '2025-04-24', 32432423423.00, '2025-04-18 12:14:33', '2025-04-19 19:54:50', '2025', 'https://res.cloudinary.com/dqxq7tupx/image/upload/v1744991805/pdfs/AMB-1-3-2025-1.pdf', 43),
	('AMB-1-2-2021-1', 'Actualizacion PGIRS Empresa tienda Carpes', 'Lorem insepu', 1, 5, 1, 2, '2021-01-19', '2021-10-19', 10000000.00, '2025-04-19 20:03:43', '2025-04-19 20:03:43', '2021', NULL, 44),
	('AMB-1-1-2021-1', 'Manual de Silvicultura de la USCO', 'Manual de Silvicultura de la USCO', 1, 5, 1, 1, '2021-03-05', '2021-06-04', 5222212.00, '2025-04-19 20:05:44', '2025-04-19 20:05:44', '2021', NULL, 45),
	('AMB-1-5-2021-1', 'Desarrollo de inventario de Fauna Silvestre y especies domésticas en la USCO', 'Desarrollo de inventario de Fauna Silvestre y especies domésticas en la USCO', 1, 5, 1, 5, '2021-02-01', '2021-05-08', 8622220.00, '2025-04-19 20:09:34', '2025-04-19 20:09:34', '2021', NULL, 46),
	('AMB-1-5-2021-2', 'Evaluacion de viabilidad de rutas de recoleccion de basuras de la vereda Otas, y Tinajito del municipio de Campoalegre', 'Evaluacion de viabilidad de rutas de recoleccion de basuras de la vereda Otas, y Tinajito del municipio de Campoalegre', 1, 5, 1, 5, '2021-06-09', '2022-07-03', 3256645.00, '2025-04-19 20:11:16', '2025-04-19 20:11:16', '2021', NULL, 47),
	('AMB-1-5-2021-3', 'Evaluacion de viabilidad de rutas de recoleccion de basuras de la vereda La Vega y La Variante  del municipio de Campoalegre', 'Evaluacion de viabilidad de rutas de recoleccion de basuras de la vereda La Vega y La Variante  del municipio de Campoalegre', 1, 5, 1, 5, '2021-02-02', '2023-01-20', 32233552.00, '2025-04-19 20:13:13', '2025-04-19 20:13:13', '2021', NULL, 48);

-- Volcando estructura para tabla fetportafolioproyectos.roles
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.roles: ~10 rows (aproximadamente)
INSERT IGNORE INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'super-admin', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(2, 'editor', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(3, 'creator', 'web', '2025-03-30 06:15:32', '2025-03-30 06:15:32'),
	(4, 'proyecto.all', 'web', '2025-03-30 08:25:44', '2025-03-30 08:25:44'),
	(5, 'tipologia.all', 'web', '2025-03-30 08:27:48', '2025-03-30 08:27:48'),
	(6, 'procedencia.all', 'web', '2025-03-30 08:28:33', '2025-03-30 08:28:33'),
	(7, 'viewer', 'web', '2025-03-30 08:47:57', '2025-03-30 08:47:57'),
	(8, 'procedencia.codigo.all', 'web', '2025-03-30 14:27:06', '2025-03-30 14:27:06'),
	(9, 'programa.all', 'web', '2025-04-01 07:59:54', '2025-04-01 07:59:54'),
	(13, 'rol prueba', 'web', '2025-04-15 23:10:48', '2025-04-15 23:10:48');

-- Volcando estructura para tabla fetportafolioproyectos.role_has_permissions
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.role_has_permissions: ~78 rows (aproximadamente)
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
	(16, 8),
	(17, 9),
	(18, 9),
	(19, 9),
	(20, 9),
	(1, 13),
	(2, 13),
	(3, 13),
	(4, 13),
	(5, 13),
	(6, 13),
	(7, 13),
	(8, 13);

-- Volcando estructura para tabla fetportafolioproyectos.route_permissions
DROP TABLE IF EXISTS `route_permissions`;
CREATE TABLE IF NOT EXISTS `route_permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `route_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `route_permissions_route_name_unique` (`route_name`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.route_permissions: ~27 rows (aproximadamente)
INSERT IGNORE INTO `route_permissions` (`id`, `route_name`, `permission_name`, `created_at`, `updated_at`) VALUES
	(1, 'proyectos.create', 'proyecto.create', '2025-04-11 05:10:50', '2025-04-11 05:10:50'),
	(2, 'proyectos.store', 'proyecto.create', '2025-04-11 05:10:50', '2025-04-11 05:10:50'),
	(3, 'proyectos.delete', 'proyecto.delete', '2025-04-11 05:10:50', '2025-04-11 05:10:50'),
	(4, 'proyecto.por.codigo', 'proyecto.view', '2025-04-11 05:10:50', '2025-04-11 05:10:50'),
	(5, 'proyectos.edit', 'proyecto.edit', '2025-04-11 05:10:50', '2025-04-11 05:10:50'),
	(6, 'proyectos.update', 'proyecto.edit', '2025-04-11 05:10:50', '2025-04-11 05:10:50'),
	(7, 'tipologia.create', 'tipologia.create', '2025-04-11 05:10:50', '2025-04-11 05:10:50'),
	(8, 'tipologia.store', 'tipologia.create', '2025-04-11 05:10:50', '2025-04-11 05:10:50'),
	(9, 'tipologia.delete', 'tipologia.delete', '2025-04-11 05:10:50', '2025-04-11 05:10:50'),
	(10, 'procedencia.store', 'procedencia.create', '2025-04-11 05:10:50', '2025-04-11 05:10:50'),
	(11, 'procedencia.delete', 'procedencia.delete', '2025-04-11 05:10:50', '2025-04-11 05:10:50'),
	(12, 'procedencia.codigo.store', 'procedencia.codigo.create', '2025-04-11 05:10:50', '2025-04-11 05:10:50'),
	(13, 'procedencia.codigo.delete', 'procedencia.codigo.delete', '2025-04-11 05:10:50', '2025-04-11 05:10:50'),
	(14, 'programa.store', 'programa.create', '2025-04-11 05:10:50', '2025-04-11 05:10:50'),
	(15, 'programa.delete', 'programa.delete', '2025-04-11 05:10:50', '2025-04-11 05:10:50'),
	(16, 'users', 'admin-access', '2025-04-11 05:10:50', '2025-04-12 09:24:41'),
	(17, 'user.edit', 'edit-user,user', '2025-04-11 05:10:50', '2025-04-12 09:24:41'),
	(18, 'user.update', 'edit-user,user', '2025-04-11 05:10:50', '2025-04-12 09:24:41'),
	(19, 'user.delete', 'admin-access', '2025-04-11 05:10:50', '2025-04-11 09:56:12'),
	(20, 'roles.index', 'admin-access', '2025-04-11 05:10:50', '2025-04-11 05:10:50'),
	(21, 'roles.store', 'admin-access', '2025-04-11 05:10:50', '2025-04-11 05:10:50'),
	(22, 'roles.update', 'admin-access', '2025-04-11 05:10:50', '2025-04-11 05:10:50'),
	(23, 'roles.delete', 'admin-access', '2025-04-11 05:10:50', '2025-04-11 05:10:50'),
	(24, 'routes.index', 'admin-access', '2025-04-11 05:10:50', '2025-04-11 05:10:50'),
	(26, 'tipologia.index', 'tipologia.view', '2025-04-11 05:22:02', '2025-04-13 00:38:20'),
	(27, 'routes.update-permissions', 'admin-access', '2025-04-11 06:02:59', '2025-04-11 06:02:59'),
	(28, 'proyectos.por.programa', 'proyecto.view', '2025-04-11 06:12:35', '2025-04-11 06:17:38'),
	(29, 'procedencia.index', 'procedencia.view', '2025-04-18 04:20:33', '2025-04-18 04:20:33'),
	(30, 'procedencia.codigo.index', 'procedencia.codigo.view', '2025-04-18 04:21:15', '2025-04-18 04:21:15'),
	(31, 'programa.index', 'programa.view', '2025-04-18 04:22:04', '2025-04-18 04:22:04');

-- Volcando estructura para tabla fetportafolioproyectos.tipologias
DROP TABLE IF EXISTS `tipologias`;
CREATE TABLE IF NOT EXISTS `tipologias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `opcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.tipologias: ~8 rows (aproximadamente)
INSERT IGNORE INTO `tipologias` (`id`, `opcion`) VALUES
	(1, 'Investigación'),
	(2, 'Innovación'),
	(3, 'Desarrollo Tecnológico'),
	(5, 'Convenio/Consultoría'),
	(41, 'tipologia_validada255'),
	(42, 'Emprendimiento'),
	(44, 'fghfgh'),
	(46, 'fgdfgdfg');

-- Volcando estructura para tabla fetportafolioproyectos.users
DROP TABLE IF EXISTS `users`;
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla fetportafolioproyectos.users: ~4 rows (aproximadamente)
INSERT IGNORE INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Super Usuario', 'superadmin@example.com', NULL, '$2y$12$3MBcYEmdDN9kdwcQ5z/kUOlDWcLlL5anMvWsTNmCOexs3.4pVOHHi', NULL, '2025-03-30 06:15:40', '2025-03-30 08:04:53'),
	(2, 'José Losada', 'tec.cuenta@gmail.com', NULL, '$2y$12$RoD1sSkCSHTQJyJh3xztEe8jJ52mJivzl2m66JdqQb/zqcDXnWWsO', NULL, '2025-03-31 22:27:48', '2025-03-31 22:27:48'),
	(7, 'Ana Maria Losada', 'anama@example.com', NULL, '$2y$12$.OZ72LGSmXSgXefwdp6s4OT0WAih9HCtlzBhNLZ.S9kp3Tw9blEH.', NULL, '2025-04-03 02:51:37', '2025-04-03 02:51:37'),
	(9, 'Jose Ignacio Castañeda Castañeda', 'nacho1957@hotmail.com', NULL, '$2y$12$vcJnziNPvo.m1nQnTaYXW.bIiN3jGQUkAGIuxiBjAf6OJHZZ0L0CO', NULL, '2025-04-15 09:21:11', '2025-04-15 09:21:11');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
