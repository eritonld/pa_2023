-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.24-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table pa_2023.atasan
CREATE TABLE IF NOT EXISTS `atasan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idkar` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `layer` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `id_atasan` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `updated_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Dumping data for table pa_2023.atasan: ~24 rows (approximately)
REPLACE INTO `atasan` (`id`, `idkar`, `layer`, `id_atasan`, `updated_date`, `updated_by`, `created_by`, `created_date`) VALUES
	(1, '2979', 'L0', '3770', NULL, NULL, NULL, NULL),
	(2, '2979', 'L1', '3770', NULL, NULL, NULL, NULL),
	(3, '2979', 'L2', '3351', NULL, NULL, NULL, NULL),
	(4, '2979', 'L3', '44051', NULL, NULL, NULL, NULL),
	(5, '1780', 'L0', '', NULL, NULL, NULL, NULL),
	(6, '1780', 'L1', '3351', NULL, NULL, NULL, NULL),
	(7, '1780', 'L2', '44051', NULL, NULL, NULL, NULL),
	(8, '1780', 'L3', '50914', NULL, NULL, NULL, NULL),
	(10, '2970', 'L1', '51321', NULL, NULL, NULL, NULL),
	(11, '2970', 'L2', '44051', NULL, NULL, NULL, NULL),
	(12, '2970', 'L3', '50914', NULL, NULL, NULL, NULL),
	(14, '16942', 'L1', '51321', NULL, NULL, NULL, NULL),
	(15, '16942', 'L2', '44051', NULL, NULL, NULL, NULL),
	(16, '16942', 'L3', '50914', NULL, NULL, NULL, NULL),
	(17, '4491', 'L0', '', NULL, NULL, NULL, NULL),
	(18, '4491', 'L1', '51321', NULL, NULL, NULL, NULL),
	(19, '4491', 'L2', '44051', NULL, NULL, NULL, NULL),
	(20, '4491', 'L3', '50914', NULL, NULL, NULL, NULL),
	(21, '44051', 'L1', '50914', NULL, NULL, NULL, NULL),
	(22, '51321', 'L1', '44051', NULL, NULL, NULL, NULL),
	(23, '51321', 'L2', '50914', NULL, NULL, NULL, NULL),
	(24, '3351', 'L1', '44051', NULL, NULL, NULL, NULL),
	(25, '3351', 'L2', '50914', NULL, NULL, NULL, NULL),
	(29, '2979', 'L4', '50914', NULL, NULL, NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
