/*
File: templog.sql
Description: SQL script to create templog table for JAMS temperature & humidity sensor
Date: February 13, 2019
Authors: Justin Shumate & Pierre Baillargeon
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for templog
-- ----------------------------
DROP TABLE IF EXISTS `templog`;
CREATE TABLE `templog` (
  `logID` int(11) NOT NULL AUTO_INCREMENT,
  `deviceID` int(11) DEFAULT NULL,
  `temperature` double(11,0) DEFAULT NULL,
  `humidity` double(11,2) DEFAULT NULL,
  `logDate` date DEFAULT NULL,
  `logTime` time DEFAULT NULL,
  PRIMARY KEY (`logID`),
  KEY `DateIndexes` (`logDate`)
) ENGINE=InnoDB AUTO_INCREMENT=730124 DEFAULT CHARSET=utf8;
