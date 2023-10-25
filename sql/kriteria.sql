/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : pa_2023

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2023-10-25 10:18:10
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `kriteria`
-- ----------------------------
DROP TABLE IF EXISTS `kriteria`;
CREATE TABLE `kriteria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ranges` double(11,1) NOT NULL,
  `grade` varchar(5) COLLATE latin1_general_ci DEFAULT '',
  `kesimpulan` varchar(75) COLLATE latin1_general_ci NOT NULL,
  `tahun` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `warna` varchar(15) COLLATE latin1_general_ci DEFAULT NULL,
  `icon` text COLLATE latin1_general_ci DEFAULT NULL,
  `bermasalah` varchar(2) COLLATE latin1_general_ci DEFAULT 'F' COMMENT 'berikan T jika batas untuk tampilah yg bermasalah dibawah nilai itu',
  `percent_a` varchar(10) COLLATE latin1_general_ci DEFAULT '',
  `percent_b` varchar(10) COLLATE latin1_general_ci DEFAULT '',
  `percent_c` varchar(10) COLLATE latin1_general_ci DEFAULT '',
  `percent_d` varchar(10) COLLATE latin1_general_ci DEFAULT '',
  `percent_e` varchar(10) COLLATE latin1_general_ci DEFAULT '',
  `total_a` int(11) DEFAULT NULL,
  `total_b` int(11) DEFAULT NULL,
  `total_c` int(11) DEFAULT NULL,
  `total_d` int(11) DEFAULT NULL,
  `total_e` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- ----------------------------
-- Records of kriteria
-- ----------------------------
INSERT INTO kriteria VALUES ('1', '90.0', 'A', 'Selalu melampaui harapan', '2015', 'ffc000', 'outstanding.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('2', '70.0', 'B', 'Selalu memenuhi dan kadang-kadang melampaui harapan', '2015', '00b050', 'verygood.png', 'T', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('3', '50.0', 'C', 'Memenuhi harapan', '2015', '0070c0', 'good.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('4', '30.0', 'D', 'Tidak selalu memenuhi harapan', '2015', 'ff0000', 'poor.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('5', '0.0', 'E', 'Tidak memenuhi harapan', '2015', '000000', 'verypoor.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('6', '90.0', 'A', 'Selalu melampaui harapan', '2016', 'ffc000', 'outstanding.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('7', '70.0', 'B', 'Selalu memenuhi dan kadang-kadang melampaui harapan', '2016', '00b050', 'verygood.png', 'T', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('8', '50.0', 'C', 'Memenuhi harapan', '2016', '0070c0', 'good.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('9', '30.0', 'D', 'Tidak selalu memenuhi harapan', '2016', 'ff0000', 'poor.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('10', '0.0', 'E', 'Tidak memenuhi harapan', '2016', '000000', 'verypoor.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('11', '90.0', 'A', 'Selalu melampaui harapan', '2017', 'ffc000', 'outstanding.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('12', '70.0', 'B', 'Selalu memenuhi dan kadang-kadang melampaui harapan', '2017', '00b050', 'verygood.png', 'T', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('13', '50.0', 'C', 'Memenuhi harapan', '2017', '0070c0', 'good.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('14', '30.0', 'D', 'Tidak selalu memenuhi harapan', '2017', 'ff0000', 'poor.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('15', '0.0', 'E', 'Tidak memenuhi harapan', '2017', '000000', 'verypoor.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('16', '90.0', 'A', 'Selalu melampaui harapan', '2018', 'ffc000', 'outstanding.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('17', '70.0', 'B', 'Selalu memenuhi dan kadang-kadang melampaui harapan', '2018', '00b050', 'verygood.png', 'T', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('18', '50.0', 'C', 'Memenuhi harapan', '2018', '0070c0', 'good.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('19', '30.0', 'D', 'Tidak selalu memenuhi harapan', '2018', 'ff0000', 'poor.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('20', '0.0', 'E', 'Tidak memenuhi harapan', '2018', '000000', 'verypoor.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('21', '91.0', 'A', '', '2019', 'ffc000', 'outstanding.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('22', '76.0', 'B', '', '2019', '00b050', 'verygood.png', 'T', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('23', '60.0', 'C', '', '2019', '0070c0', 'good.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('24', '40.0', 'D', '', '2019', 'ff0000', 'poor.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('25', '0.0', 'E', '', '2019', '000000', 'verypoor.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('26', '91.0', 'A', '', '2020', 'ffc000', 'outstanding.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('27', '76.0', 'B', '', '2020', '00b050', 'verygood.png', 'T', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('28', '60.0', 'C', '', '2020', '0070c0', 'good.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('29', '40.0', 'D', '', '2020', 'ff0000', 'poor.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('30', '0.0', 'E', '', '2020', '000000', 'verypoor.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('31', '91.0', 'A', '', '2021', 'ffc000', 'outstanding.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('32', '76.0', 'B', '', '2021', '00b050', 'verygood.png', 'T', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('33', '60.0', 'C', '', '2021', '0070c0', 'good.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('34', '40.0', 'D', '', '2021', 'ff0000', 'poor.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('35', '0.0', 'E', '', '2021', '000000', 'verypoor.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('36', '91.0', 'A', '', '2022', 'ffc000', 'outstanding.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('37', '76.0', 'B', '', '2022', '00b050', 'verygood.png', 'T', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('38', '60.0', 'C', '', '2022', '0070c0', 'good.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('39', '40.0', 'D', '', '2022', 'ff0000', 'poor.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('40', '0.0', 'E', '', '2022', '000000', 'verypoor.png', 'F', null, null, null, null, null, null, null, null, null, null);
INSERT INTO kriteria VALUES ('41', '4.5', 'A', '', '2023', 'ffc000', 'outstanding.png', 'F', '20', '30', '35', '10', '0', null, null, null, null, null);
INSERT INTO kriteria VALUES ('42', '4.0', 'B', '', '2023', '00b050', 'verygood.png', 'T', '15', '30', '35', '20', '5', null, null, null, null, null);
INSERT INTO kriteria VALUES ('43', '3.0', 'C', '', '2023', '0070c0', 'good.png', 'F', '10', '20', '40', '20', '10', null, null, null, null, null);
INSERT INTO kriteria VALUES ('44', '2.0', 'D', '', '2023', 'ff0000', 'poor.png', 'F', '5', '20', '35', '30', '15', null, null, null, null, null);
INSERT INTO kriteria VALUES ('45', '0.0', 'E', '', '2023', '000000', 'verypoor.png', 'F', '0', '10', '35', '30', '20', null, null, null, null, null);
INSERT INTO kriteria VALUES ('46', '0.0', 'A_3', '', '2023', null, null, 'F', '', '', '', '', '', '0', '3', '0', '0', '0');
INSERT INTO kriteria VALUES ('47', '0.0', 'A_4', '', '2023', null, null, 'F', '', '', '', '', '', '0', '4', '0', '0', '0');
INSERT INTO kriteria VALUES ('48', '0.0', 'A_5', '', '2023', null, null, 'F', '', '', '', '', '', '1', '3', '1', '0', '0');
INSERT INTO kriteria VALUES ('49', '0.0', 'A_6', '', '2023', null, null, 'F', '', '', '', '', '', '1', '3', '1', '1', '0');
INSERT INTO kriteria VALUES ('50', '0.0', 'A_7', '', '2023', null, null, 'F', '', '', '', '', '', '1', '3', '2', '1', '0');
INSERT INTO kriteria VALUES ('51', '0.0', 'A_8', '', '2023', null, null, 'F', '', '', '', '', '', '2', '3', '2', '1', '0');
INSERT INTO kriteria VALUES ('52', '0.0', 'A_9', '', '2023', null, null, 'F', '', '', '', '', '', '2', '4', '2', '1', '0');
INSERT INTO kriteria VALUES ('53', '0.0', 'A_10', '', '2023', null, null, 'F', '', '', '', '', '', '2', '5', '2', '1', '0');
INSERT INTO kriteria VALUES ('54', '0.0', 'A_11', '', '2023', null, null, 'F', '', '', '', '', '', '2', '5', '3', '1', '0');
INSERT INTO kriteria VALUES ('55', '0.0', 'B_3', '', '2023', null, null, 'F', '', '', '', '', '', '0', '3', '0', '0', '0');
INSERT INTO kriteria VALUES ('56', '0.0', 'B_4', '', '2023', null, null, 'F', '', '', '', '', '', '0', '4', '0', '0', '0');
INSERT INTO kriteria VALUES ('57', '0.0', 'B_5', '', '2023', null, null, 'F', '', '', '', '', '', '1', '2', '1', '1', '0');
INSERT INTO kriteria VALUES ('58', '0.0', 'B_6', '', '2023', null, null, 'F', '', '', '', '', '', '1', '3', '1', '1', '0');
INSERT INTO kriteria VALUES ('59', '0.0', 'B_7', '', '2023', null, null, 'F', '', '', '', '', '', '1', '4', '1', '1', '0');
INSERT INTO kriteria VALUES ('60', '0.0', 'B_8', '', '2023', null, null, 'F', '', '', '', '', '', '1', '3', '2', '1', '1');
INSERT INTO kriteria VALUES ('61', '0.0', 'B_9', '', '2023', null, null, 'F', '', '', '', '', '', '1', '4', '2', '1', '1');
INSERT INTO kriteria VALUES ('62', '0.0', 'B_10', '', '2023', null, null, 'F', '', '', '', '', '', '1', '4', '3', '1', '1');
INSERT INTO kriteria VALUES ('63', '0.0', 'B_11', '', '2023', null, null, 'F', '', '', '', '', '', '1', '4', '3', '2', '1');
INSERT INTO kriteria VALUES ('64', '0.0', 'C_3', '', '2023', null, null, 'F', '', '', '', '', '', '0', '0', '3', '0', '0');
INSERT INTO kriteria VALUES ('65', '0.0', 'C_4', '', '2023', null, null, 'F', '', '', '', '', '', '0', '0', '4', '0', '0');
INSERT INTO kriteria VALUES ('66', '0.0', 'C_5', '', '2023', null, null, 'F', '', '', '', '', '', '0', '1', '3', '1', '0');
INSERT INTO kriteria VALUES ('67', '0.0', 'C_6', '', '2023', null, null, 'F', '', '', '', '', '', '0', '1', '4', '1', '0');
INSERT INTO kriteria VALUES ('68', '0.0', 'C_7', '', '2023', null, null, 'F', '', '', '', '', '', '0', '1', '5', '1', '0');
INSERT INTO kriteria VALUES ('69', '0.0', 'C_8', '', '2023', null, null, 'F', '', '', '', '', '', '1', '1', '4', '1', '1');
INSERT INTO kriteria VALUES ('70', '0.0', 'C_9', '', '2023', null, null, 'F', '', '', '', '', '', '1', '1', '5', '1', '1');
INSERT INTO kriteria VALUES ('71', '0.0', 'C_10', '', '2023', null, null, 'F', '', '', '', '', '', '1', '2', '4', '2', '1');
INSERT INTO kriteria VALUES ('72', '0.0', 'C_11', '', '2023', null, null, 'F', '', '', '', '', '', '1', '2', '5', '2', '1');
INSERT INTO kriteria VALUES ('73', '0.0', 'D_3', '', '2023', null, null, 'F', '', '', '', '', '', '0', '0', '3', '0', '0');
INSERT INTO kriteria VALUES ('74', '0.0', 'D_4', '', '2023', null, null, 'F', '', '', '', '', '', '0', '0', '4', '0', '0');
INSERT INTO kriteria VALUES ('75', '0.0', 'D_5', '', '2023', null, null, 'F', '', '', '', '', '', '0', '0', '3', '1', '1');
INSERT INTO kriteria VALUES ('76', '0.0', 'D_6', '', '2023', null, null, 'F', '', '', '', '', '', '0', '0', '3', '2', '1');
INSERT INTO kriteria VALUES ('77', '0.0', 'D_7', '', '2023', null, null, 'F', '', '', '', '', '', '0', '0', '4', '2', '1');
INSERT INTO kriteria VALUES ('78', '0.0', 'D_8', '', '2023', null, null, 'F', '', '', '', '', '', '0', '0', '4', '3', '1');
INSERT INTO kriteria VALUES ('79', '0.0', 'D_9', '', '2023', null, null, 'F', '', '', '', '', '', '0', '0', '4', '3', '2');
INSERT INTO kriteria VALUES ('80', '0.0', 'D_10', '', '2023', null, null, 'F', '', '', '', '', '', '0', '0', '5', '3', '2');
INSERT INTO kriteria VALUES ('81', '0.0', 'D_11', '', '2023', null, null, 'F', '', '', '', '', '', '0', '0', '5', '4', '2');
INSERT INTO kriteria VALUES ('82', '0.0', 'E_3', '', '2023', null, null, 'F', '', '', '', '', '', '0', '0', '0', '3', '0');
INSERT INTO kriteria VALUES ('83', '0.0', 'E_4', '', '2023', null, null, 'F', '', '', '', '', '', '0', '0', '0', '4', '0');
INSERT INTO kriteria VALUES ('84', '0.0', 'E_5', '', '2023', null, null, 'F', '', '', '', '', '', '0', '0', '1', '3', '1');
INSERT INTO kriteria VALUES ('85', '0.0', 'E_6', '', '2023', null, null, 'F', '', '', '', '', '', '0', '0', '1', '4', '1');
INSERT INTO kriteria VALUES ('86', '0.0', 'E_7', '', '2023', null, null, 'F', '', '', '', '', '', '0', '0', '1', '5', '1');
INSERT INTO kriteria VALUES ('87', '0.0', 'E_8', '', '2023', null, null, 'F', '', '', '', '', '', '0', '0', '1', '6', '1');
INSERT INTO kriteria VALUES ('88', '0.0', 'E_9', '', '2023', null, null, 'F', '', '', '', '', '', '0', '0', '2', '5', '2');
INSERT INTO kriteria VALUES ('89', '0.0', 'E_10', '', '2023', null, null, 'F', '', '', '', '', '', '0', '0', '3', '5', '2');
INSERT INTO kriteria VALUES ('90', '0.0', 'E_11', '', '2023', null, null, 'F', '', '', '', '', '', '0', '0', '3', '6', '2');
