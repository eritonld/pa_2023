/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : pa_2023

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2023-10-25 09:16:59
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `bobot`
-- ----------------------------
DROP TABLE IF EXISTS `bobot`;
CREATE TABLE `bobot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fortable` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `self` int(11) NOT NULL,
  `culture` int(11) NOT NULL,
  `leadership` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- ----------------------------
-- Records of bobot
-- ----------------------------
INSERT INTO bobot VALUES ('1', 'nonstaff', '60', '40', '0');
INSERT INTO bobot VALUES ('2', 'staff', '65', '35', '0');
INSERT INTO bobot VALUES ('3', 'staffb', '45', '30', '25');
INSERT INTO bobot VALUES ('4', 'managerial', '35', '30', '35');
