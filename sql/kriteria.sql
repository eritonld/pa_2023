/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : pa_2023

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2023-10-25 09:02:05
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `kriteria`
-- ----------------------------
DROP TABLE IF EXISTS `kriteria`;
CREATE TABLE `kriteria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ranges` double(11,1) NOT NULL,
  `grade` varchar(2) COLLATE latin1_general_ci DEFAULT NULL,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- ----------------------------
-- Records of kriteria
-- ----------------------------
INSERT INTO kriteria VALUES ('1', '90.0', 'A', 'Selalu melampaui harapan', '2015', 'ffc000', 'outstanding.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('2', '70.0', 'B', 'Selalu memenuhi dan kadang-kadang melampaui harapan', '2015', '00b050', 'verygood.png', 'T', null, null, null, null, null);
INSERT INTO kriteria VALUES ('3', '50.0', 'C', 'Memenuhi harapan', '2015', '0070c0', 'good.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('4', '30.0', 'D', 'Tidak selalu memenuhi harapan', '2015', 'ff0000', 'poor.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('5', '0.0', 'E', 'Tidak memenuhi harapan', '2015', '000000', 'verypoor.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('6', '90.0', 'A', 'Selalu melampaui harapan', '2016', 'ffc000', 'outstanding.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('7', '70.0', 'B', 'Selalu memenuhi dan kadang-kadang melampaui harapan', '2016', '00b050', 'verygood.png', 'T', null, null, null, null, null);
INSERT INTO kriteria VALUES ('8', '50.0', 'C', 'Memenuhi harapan', '2016', '0070c0', 'good.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('9', '30.0', 'D', 'Tidak selalu memenuhi harapan', '2016', 'ff0000', 'poor.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('10', '0.0', 'E', 'Tidak memenuhi harapan', '2016', '000000', 'verypoor.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('11', '90.0', 'A', 'Selalu melampaui harapan', '2017', 'ffc000', 'outstanding.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('12', '70.0', 'B', 'Selalu memenuhi dan kadang-kadang melampaui harapan', '2017', '00b050', 'verygood.png', 'T', null, null, null, null, null);
INSERT INTO kriteria VALUES ('13', '50.0', 'C', 'Memenuhi harapan', '2017', '0070c0', 'good.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('14', '30.0', 'D', 'Tidak selalu memenuhi harapan', '2017', 'ff0000', 'poor.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('15', '0.0', 'E', 'Tidak memenuhi harapan', '2017', '000000', 'verypoor.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('16', '90.0', 'A', 'Selalu melampaui harapan', '2018', 'ffc000', 'outstanding.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('17', '70.0', 'B', 'Selalu memenuhi dan kadang-kadang melampaui harapan', '2018', '00b050', 'verygood.png', 'T', null, null, null, null, null);
INSERT INTO kriteria VALUES ('18', '50.0', 'C', 'Memenuhi harapan', '2018', '0070c0', 'good.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('19', '30.0', 'D', 'Tidak selalu memenuhi harapan', '2018', 'ff0000', 'poor.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('20', '0.0', 'E', 'Tidak memenuhi harapan', '2018', '000000', 'verypoor.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('21', '91.0', 'A', '', '2019', 'ffc000', 'outstanding.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('22', '76.0', 'B', '', '2019', '00b050', 'verygood.png', 'T', null, null, null, null, null);
INSERT INTO kriteria VALUES ('23', '60.0', 'C', '', '2019', '0070c0', 'good.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('24', '40.0', 'D', '', '2019', 'ff0000', 'poor.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('25', '0.0', 'E', '', '2019', '000000', 'verypoor.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('26', '91.0', 'A', '', '2020', 'ffc000', 'outstanding.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('27', '76.0', 'B', '', '2020', '00b050', 'verygood.png', 'T', null, null, null, null, null);
INSERT INTO kriteria VALUES ('28', '60.0', 'C', '', '2020', '0070c0', 'good.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('29', '40.0', 'D', '', '2020', 'ff0000', 'poor.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('30', '0.0', 'E', '', '2020', '000000', 'verypoor.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('31', '91.0', 'A', '', '2021', 'ffc000', 'outstanding.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('32', '76.0', 'B', '', '2021', '00b050', 'verygood.png', 'T', null, null, null, null, null);
INSERT INTO kriteria VALUES ('33', '60.0', 'C', '', '2021', '0070c0', 'good.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('34', '40.0', 'D', '', '2021', 'ff0000', 'poor.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('35', '0.0', 'E', '', '2021', '000000', 'verypoor.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('36', '91.0', 'A', '', '2022', 'ffc000', 'outstanding.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('37', '76.0', 'B', '', '2022', '00b050', 'verygood.png', 'T', null, null, null, null, null);
INSERT INTO kriteria VALUES ('38', '60.0', 'C', '', '2022', '0070c0', 'good.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('39', '40.0', 'D', '', '2022', 'ff0000', 'poor.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('40', '0.0', 'E', '', '2022', '000000', 'verypoor.png', 'F', null, null, null, null, null);
INSERT INTO kriteria VALUES ('41', '4.5', 'A', '', '2023', 'ffc000', 'outstanding.png', 'F', '20', '15', '10', '5', '0');
INSERT INTO kriteria VALUES ('42', '4.0', 'B', '', '2023', '00b050', 'verygood.png', 'T', '30', '30', '20', '20', '10');
INSERT INTO kriteria VALUES ('43', '3.0', 'C', '', '2023', '0070c0', 'good.png', 'F', '35', '35', '40', '35', '35');
INSERT INTO kriteria VALUES ('44', '2.0', 'D', '', '2023', 'ff0000', 'poor.png', 'F', '10', '20', '20', '30', '30');
INSERT INTO kriteria VALUES ('45', '0.0', 'E', '', '2023', '000000', 'verypoor.png', 'F', '0', '5', '10', '15', '20');
