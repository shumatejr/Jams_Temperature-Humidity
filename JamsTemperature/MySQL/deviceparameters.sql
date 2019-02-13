/*
File: deviceparameters.sql
Description: SQL script to create device parameters table for JAMS temperature & humidity sensor
Date: February 13, 2019
Authors: Justin Shumate & Pierre Baillargeon
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for deviceparameters
-- ----------------------------
DROP TABLE IF EXISTS `deviceparameters`;
CREATE TABLE `deviceparameters` (
  `deviceID` int(11) NOT NULL AUTO_INCREMENT,
  `pollingRate` int(11) DEFAULT NULL,
  `tempAlarmLowerThreshold` int(11) DEFAULT NULL,
  `tempAlarmUpperThreshold` int(11) DEFAULT NULL,
  `humidityAlarmLowerThreshold` int(11) DEFAULT NULL,
  `humidityAlarmUpperThreshold` int(11) DEFAULT NULL,
  PRIMARY KEY (`deviceID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
