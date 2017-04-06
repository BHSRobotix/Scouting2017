-- SQL to set up 2017 DB

CREATE DATABASE IF NOT EXISTS `devilbotz_stathead` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `devilbotz_stathead`;

-- --------------------------------------------------------
--
-- Table: sh_event
-- Purpose: this table tracks events
-- Year-Specific: no
--
DROP TABLE IF EXISTS `sh_event`;
CREATE TABLE IF NOT EXISTS `sh_event` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `eventKey` varchar(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `shortName` varchar(30) DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `week` int(2) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `eventType` int(2) DEFAULT NULL,  
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
TRUNCATE TABLE `sh_event`;

-- --------------------------------------------------------
--
-- Table: sh_event_playoff
-- Purpose: this table tracks event playoffs
-- Year-Specific: no
--
DROP TABLE IF EXISTS `sh_event_playoff`;
CREATE TABLE IF NOT EXISTS `sh_event_playoff` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `eventKey` varchar(11) NOT NULL,
  `allianceNum` int(2) DEFAULT NULL,
  `captain` varchar(10) DEFAULT NULL,
  `firstPick` varchar(10) DEFAULT NULL,
  `secondPick` varchar(10) DEFAULT NULL,
  `thirdPick` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
TRUNCATE TABLE `sh_event_playoff`;

-- --------------------------------------------------------
--
-- Table: team
-- Purpose: this table should have all teams in FRC
-- Year-Specific: no
--
DROP TABLE IF EXISTS `sh_team`;
CREATE TABLE IF NOT EXISTS `sh_team` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `teamKey` varchar(8) NOT NULL,
  `teamNumber` int(5) NOT NULL,
  `website` varchar(50) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `country` varchar(20) NOT NULL,
  `location` varchar(50) NOT NULL,
  `rookieYear` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=127 DEFAULT CHARSET=latin1;
TRUNCATE TABLE `sh_team`;

