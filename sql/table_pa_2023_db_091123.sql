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

-- Dumping structure for table pa_2023.transaksi_2023
CREATE TABLE IF NOT EXISTS `transaksi_2023` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idkar` bigint(20) NOT NULL,
  `fortable` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `value_1` text COLLATE latin1_general_ci NOT NULL,
  `score_1` int(1) NOT NULL DEFAULT 0,
  `value_2` text COLLATE latin1_general_ci DEFAULT NULL,
  `score_2` int(1) DEFAULT NULL,
  `value_3` text COLLATE latin1_general_ci DEFAULT NULL,
  `score_3` int(1) DEFAULT NULL,
  `value_4` text COLLATE latin1_general_ci DEFAULT NULL,
  `score_4` int(1) DEFAULT NULL,
  `value_5` text COLLATE latin1_general_ci DEFAULT NULL,
  `score_5` int(1) DEFAULT NULL,
  `synergized1` int(1) DEFAULT NULL,
  `synergized2` int(1) DEFAULT NULL,
  `synergized3` int(1) DEFAULT NULL,
  `integrity1` int(1) DEFAULT NULL,
  `integrity2` int(1) DEFAULT NULL,
  `integrity3` int(1) DEFAULT NULL,
  `growth1` int(1) DEFAULT NULL,
  `growth2` int(1) DEFAULT NULL,
  `growth3` int(1) DEFAULT NULL,
  `adaptive1` int(1) DEFAULT NULL,
  `adaptive2` int(1) DEFAULT NULL,
  `adaptive3` int(1) DEFAULT NULL,
  `passion1` int(1) DEFAULT NULL,
  `passion2` int(1) DEFAULT NULL,
  `passion3` int(1) DEFAULT NULL,
  `leadership1` int(1) DEFAULT NULL,
  `leadership2` int(1) DEFAULT NULL,
  `leadership3` int(1) DEFAULT NULL,
  `leadership4` int(1) DEFAULT NULL,
  `leadership5` int(1) DEFAULT NULL,
  `leadership6` int(1) DEFAULT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `periode` varchar(4) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `comment` text COLLATE latin1_general_ci DEFAULT NULL,
  `total_score` decimal(4,2) DEFAULT NULL,
  `total_culture` decimal(4,2) DEFAULT 0.00,
  `total_leadership` decimal(4,2) DEFAULT 0.00,
  `rating` decimal(4,2) DEFAULT NULL,
  `layer` varchar(2) COLLATE latin1_general_ci DEFAULT NULL,
  `approver_id` bigint(20) DEFAULT NULL,
  `approval_status` enum('Pending','Approved') COLLATE latin1_general_ci NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table pa_2023.transaksi_2023: ~0 rows (approximately)

-- Dumping structure for table pa_2023.transaksi_2023_final
CREATE TABLE IF NOT EXISTS `transaksi_2023_final` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idkar` bigint(20) NOT NULL,
  `fortable` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `value_1` text COLLATE latin1_general_ci NOT NULL,
  `score_1` int(1) NOT NULL DEFAULT 0,
  `value_2` text COLLATE latin1_general_ci DEFAULT NULL,
  `score_2` int(1) DEFAULT NULL,
  `value_3` text COLLATE latin1_general_ci DEFAULT NULL,
  `score_3` int(1) DEFAULT NULL,
  `value_4` text COLLATE latin1_general_ci DEFAULT NULL,
  `score_4` int(1) DEFAULT NULL,
  `value_5` text COLLATE latin1_general_ci DEFAULT NULL,
  `score_5` int(1) DEFAULT NULL,
  `synergized1` int(1) DEFAULT NULL,
  `synergized2` int(1) DEFAULT NULL,
  `synergized3` int(1) DEFAULT NULL,
  `integrity1` int(1) DEFAULT NULL,
  `integrity2` int(1) DEFAULT NULL,
  `integrity3` int(1) DEFAULT NULL,
  `growth1` int(1) DEFAULT NULL,
  `growth2` int(1) DEFAULT NULL,
  `growth3` int(1) DEFAULT NULL,
  `adaptive1` int(1) DEFAULT NULL,
  `adaptive2` int(1) DEFAULT NULL,
  `adaptive3` int(1) DEFAULT NULL,
  `passion1` int(1) DEFAULT NULL,
  `passion2` int(1) DEFAULT NULL,
  `passion3` int(1) DEFAULT NULL,
  `leadership1` int(1) DEFAULT NULL,
  `leadership2` int(1) DEFAULT NULL,
  `leadership3` int(1) DEFAULT NULL,
  `leadership4` int(1) DEFAULT NULL,
  `leadership5` int(1) DEFAULT NULL,
  `leadership6` int(1) DEFAULT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `periode` varchar(4) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `comment` text COLLATE latin1_general_ci DEFAULT NULL,
  `total_score` decimal(4,2) DEFAULT NULL,
  `total_culture` decimal(4,2) DEFAULT 0.00,
  `total_leadership` decimal(4,2) DEFAULT 0.00,
  `rating` int(1) DEFAULT NULL,
  `approver_review_id` bigint(20) NOT NULL,
  `approval_review` enum('Pending','Approved') COLLATE latin1_general_ci NOT NULL DEFAULT 'Pending',
  `layer` varchar(2) COLLATE latin1_general_ci DEFAULT NULL,
  `approver_rating_id` bigint(20) NOT NULL,
  `layer_rating` varchar(2) COLLATE latin1_general_ci DEFAULT NULL,
  `approval_rating` enum('Pending','Approved') COLLATE latin1_general_ci NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table pa_2023.transaksi_2023_final: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
