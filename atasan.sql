/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : pa_2023

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2023-10-18 10:13:11
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `atasan`
-- ----------------------------
DROP TABLE IF EXISTS `atasan`;
CREATE TABLE `atasan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idkar` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `layer` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `id_atasan` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `lastupdate` date DEFAULT NULL,
  `edit_by` varchar(12) COLLATE latin1_general_ci DEFAULT NULL,
  `update_admin` date DEFAULT NULL,
  `edit_by_admin` varchar(12) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- ----------------------------
-- Records of atasan
-- ----------------------------
INSERT INTO atasan VALUES ('1', '2979', 'L0', '', null, null, null, null);
INSERT INTO atasan VALUES ('2', '2979', 'L1', '3351', null, null, null, null);
INSERT INTO atasan VALUES ('3', '2979', 'L2', '44051', null, null, null, null);
INSERT INTO atasan VALUES ('4', '2979', 'L3', '50914', null, null, null, null);
INSERT INTO atasan VALUES ('5', '1780', 'L0', '', null, null, null, null);
INSERT INTO atasan VALUES ('6', '1780', 'L1', '3351', null, null, null, null);
INSERT INTO atasan VALUES ('7', '1780', 'L2', '44051', null, null, null, null);
INSERT INTO atasan VALUES ('8', '1780', 'L3', '50914', null, null, null, null);
INSERT INTO atasan VALUES ('9', '2970', 'L0', '', null, null, null, null);
INSERT INTO atasan VALUES ('10', '2970', 'L1', '51321', null, null, null, null);
INSERT INTO atasan VALUES ('11', '2970', 'L2', '44051', null, null, null, null);
INSERT INTO atasan VALUES ('12', '2970', 'L3', '50914', null, null, null, null);
INSERT INTO atasan VALUES ('13', '16942', 'L0', '', null, null, null, null);
INSERT INTO atasan VALUES ('14', '16942', 'L1', '51321', null, null, null, null);
INSERT INTO atasan VALUES ('15', '16942', 'L2', '44051', null, null, null, null);
INSERT INTO atasan VALUES ('16', '16942', 'L3', '50914', null, null, null, null);
INSERT INTO atasan VALUES ('17', '4491', 'L0', '', null, null, null, null);
INSERT INTO atasan VALUES ('18', '4491', 'L1', '51321', null, null, null, null);
INSERT INTO atasan VALUES ('19', '4491', 'L2', '44051', null, null, null, null);
INSERT INTO atasan VALUES ('20', '4491', 'L3', '50914', null, null, null, null);
