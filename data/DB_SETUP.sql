-- SQL to set up 2017 DB

CREATE DATABASE IF NOT EXISTS `devilbotz_scouting` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `devilbotz_scouting`;

-- --------------------------------------------------------
--
-- Table: bluealliancerankings
-- Purpose: self-explanatory, probably, but this is pulled and refreshed from the blue alliance
--     periodically, and should represent a single state of the rankings (no history in other words)
-- Year-Specific: yes
--
DROP TABLE IF EXISTS `bluealliancerankings`;
CREATE TABLE IF NOT EXISTS `bluealliancerankings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `eventkey` varchar(11) NOT NULL,
  `teamnumber` int(5) NOT NULL,
  `rank` int(3) NOT NULL,
  `rankingScore` float NOT NULL,
  `matchPoints` float NOT NULL,
  `auto` float NOT NULL,
  `rotor` float NOT NULL,
  `touchpad` float NOT NULL,
  `pressure` float NOT NULL,
  `record` varchar(16) NOT NULL,
  `played` int(2) NOT NULL,
  `oprs` float NOT NULL,
  `ccwms` float NOT NULL,
  `dprs` float NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `teamNumber` (`teamnumber`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;
TRUNCATE TABLE `bluealliancerankings`;

-- --------------------------------------------------------
--
-- Table: driverfeedback
-- Purpose: self-explanatory, probably, but this is a simple table where a driver can leave text
--     comments feedback for a team they worked with (or witnessed interaction with)
-- Year-Specific: no
--
DROP TABLE IF EXISTS `driverfeedback`;
CREATE TABLE IF NOT EXISTS `driverfeedback` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `eventkey` varchar(11) NOT NULL,
  `teamnumber` int(5) NOT NULL,
  `comments` text COMMENT 'General comments',
  `scout` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
TRUNCATE TABLE `driverfeedback`;

-- --------------------------------------------------------
--
-- Table: eventstatus
-- Purpose: this table is constantly updated for the current event to track the match number, mostly,
--     and I've kept the old entries for no apparent reason
-- Year-Specific: no
--
DROP TABLE IF EXISTS `eventstatus`;
CREATE TABLE IF NOT EXISTS `eventstatus` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `eventkey` varchar(11) NOT NULL,
  `eventName` varchar(100) DEFAULT NULL,
  `eventShortName` varchar(30) DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `numQualMatches` int(11) DEFAULT NULL,
  `currentMatchNumber` int(11) NOT NULL,
  `active` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
TRUNCATE TABLE `eventstatus`;
INSERT DELAYED IGNORE INTO `eventstatus` (`id`, `eventkey`, `eventName`, `eventShortName`, `startDate`, `endDate`, `numQualMatches`, `currentMatchNumber`, `active`) VALUES
(1, '2015marea', 'NE District - Reading Event 2015', 'Reading', '2015-03-06', '2015-03-08', NULL, 56, 'false'),
(2, '2015nhnas', 'NE District - Granite State Event 2015', 'Granite State', '2015-02-26', '2015-02-28', NULL, 80, 'false'),
(3, '2015necmp', 'NE District - Championship Event 2015', 'NE Championships', '2015-04-08', '2015-04-12', NULL, 120, 'false'),
(4, '2015carv', 'FRC Championship - Carver Division 2015', 'Carver', '2015-04-23', '2015-04-25', NULL, 4, 'false'),
(5, '2016marea', 'NE District - Reading Event 2016', 'Reading', '2016-03-11', '2016-03-13', 78, 15, 'false'),
(7, '2016nhdur', 'NE District - UNH Event 2016', 'UNH', '2016-03-24', '2016-03-26', 80, 80, 'false'),
(8, '2016mabos', 'NE District - Boston Event 2016', 'BU', '2016-04-01', '2016-04-03', 80, 0, 'false'),
(9, '2016necmp', 'NE District - Championship Event 2016', 'NE Championships', '2016-04-13', '2016-04-16', 126, 0, 'true');

-- --------------------------------------------------------
--
-- Table: matches
-- Purpose: this table is basically the schedule at an event, and is pulled from TBA
-- Year-Specific: no
--
DROP TABLE IF EXISTS `matches`;
CREATE TABLE IF NOT EXISTS `matches` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `matchnumber` int(11) NOT NULL,
  `eventkey` varchar(11) NOT NULL,
  `redteam1` int(11) NOT NULL,
  `redteam2` int(11) NOT NULL,
  `redteam3` int(11) NOT NULL,
  `blueteam1` int(11) NOT NULL,
  `blueteam2` int(11) NOT NULL,
  `blueteam3` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=127 DEFAULT CHARSET=latin1;
TRUNCATE TABLE `matches`;

-- --------------------------------------------------------
--
-- Table: matchresults
-- Purpose: this table was not used in 2016, but the idea is to pull the individual match results from 
--     TBA and put the data in here.
-- Year-Specific: yes, if used
--
DROP TABLE IF EXISTS `matchresults`;
CREATE TABLE IF NOT EXISTS `matchresults` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `matchnumber` int(11) NOT NULL,
  `eventkey` varchar(11) NOT NULL,
  `redteam1` int(11) NOT NULL,
  `redteam2` int(11) NOT NULL,
  `redteam3` int(11) NOT NULL,
  `blueteam1` int(11) NOT NULL,
  `blueteam2` int(11) NOT NULL,
  `blueteam3` int(11) NOT NULL,
  `redscoreAuto` int(11) DEFAULT NULL,
  `redscoreTote` int(11) DEFAULT NULL,
  `redscoreContainer` int(11) DEFAULT NULL,
  `redscoreLitter` int(11) DEFAULT NULL,
  `redscoreFoul` int(11) DEFAULT NULL,
  `redscoreTotal` int(11) DEFAULT NULL,
  `bluescoreAuto` int(11) DEFAULT NULL,
  `bluescoreTote` int(11) DEFAULT NULL,
  `bluescoreContainer` int(11) DEFAULT NULL,
  `bluescoreLitter` int(11) DEFAULT NULL,
  `bluescoreFoul` int(11) DEFAULT NULL,
  `bluescoreTotal` int(11) DEFAULT NULL,
  `coopscore` int(11) DEFAULT NULL COMMENT 'co-op score',
  
        "redRobot1Auto": "None",
        "redRobot2Auto": "None",
        "redRobot3Auto": "None",
        "redRotor1Auto": false,
        "redRotor2Auto": false,
        "redAutoMobilityPoints": 0,
        "redAutoRotorPoints": 0,
        "redAutoFuelLow": 0,
        "redAutoFuelHigh": 0,
        "redAutoFuelPoints": 0,
        "redAutoPoints": 0,
        "redRotor1Engaged": false,
        "redRotor2Engaged": false,
        "redRotor3Engaged": false,
        "redRotor4Engaged": false,
        "redTeleopRotorPoints": 0,
        "redRotorBonusPoints": 0,
        "redRotorRankingPointAchieved": false,
        "redTeleopFuelLow": 0,
        "redTeleopFuelHigh": 0,
        "redTeleopFuelPoints": 0,
        "redKPaBonusPoints": 0,
        "redKPaRankingPointAchieved": false,
        "redTouchpadFar": "None",
        "redTouchpadMiddle": "None",
        "redTouchpadNear": "None",
        "redTeleopTakeoffPoints": 0,
        "redTeleopPoints": 0,
        "redFoulCount": 0,
        "redTechFoulCount": 0,
        "redFoulPoints": 0,
        "redAdjustPoints": 0,
        "redTotalPoints": 0,
        
        "blueRobot1Auto": "None",
        "blueRobot2Auto": "None",
        "blueRobot3Auto": "None",
        "blueRotor1Auto": false,
        "blueRotor2Auto": false,
        "blueAutoMobilityPoints": 0,
        "blueAutoRotorPoints": 0,
        "blueAutoFuelLow": 0,
        "blueAutoFuelHigh": 0,
        "blueAutoFuelPoints": 0,
        "blueAutoPoints": 0,
        "blueRotor1Engaged": false,
        "blueRotor2Engaged": false,
        "blueRotor3Engaged": false,
        "blueRotor4Engaged": false,
        "blueTeleopRotorPoints": 0,
        "blueRotorBonusPoints": 0,
        "blueRotorRankingPointAchieved": false,
        "blueTeleopFuelLow": 0,
        "blueTeleopFuelHigh": 0,
        "blueTeleopFuelPoints": 0,
        "blueKPaBonusPoints": 0,
        "blueKPaRankingPointAchieved": false,
        "blueTouchpadFar": "None",
        "blueTouchpadMiddle": "None",
        "blueTouchpadNear": "None",
        "blueTeleopTakeoffPoints": 0,
        "blueTeleopPoints": 0,
        "blueFoulCount": 0,
        "blueTechFoulCount": 0,
        "blueFoulPoints": 0,
        "blueAdjustPoints": 0,
        "blueTotalPoints": 0,
  
  
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;
TRUNCATE TABLE `matchresults`;

-- --------------------------------------------------------
--
-- Table: performances
-- Purpose: this table stores all match scouting data and therefore the columns vary from year to year 
-- Year-Specific: yes
--
DROP TABLE IF EXISTS `performances`;
CREATE TABLE IF NOT EXISTS `performances` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `matchnumber` int(11) NOT NULL,
  `eventkey` varchar(11) NOT NULL,
  `teamnumber` int(5) NOT NULL,
  `functional_code` varchar(6) NOT NULL,
  `functional_comments` text,
  `auto_mobility` varchar(6) DEFAULT NULL,
  `auto_gear` varchar(6) DEFAULT NULL,
  `auto_gear_peg_location` varchar(2) DEFAULT NULL,
  `auto_hopper` varchar(6) DEFAULT NULL,
  `auto_shot_high_attempt` int(3) DEFAULT NULL,
  `auto_shot_high_success` int(3) DEFAULT NULL,
  `auto_shot_low_attempt` int(3) DEFAULT NULL,
  `auto_shot_low_success` int(3) DEFAULT NULL,
  `tele_fuel_acquire_floor` int(4) DEFAULT NULL,
  `tele_fuel_acquire_hopper` int(4) DEFAULT NULL,
  `tele_fuel_acquire_station` int(4) DEFAULT NULL,
  `tele_shot_low_success` int(4) DEFAULT NULL,
  `tele_shot_high_success` int(4) DEFAULT NULL,
  `tele_shot_location` varchar(32) DEFAULT NULL,
  `tele_gears_acquire_station` int(5) DEFAULT NULL,
  `tele_gears_acquire_floor` int(5) DEFAULT NULL,
  `tele_gears_delivered` int(5) DEFAULT NULL,
  `tele_climb_attempt` varchar(6) DEFAULT NULL,
  `tele_climb_outcome` varchar(6) DEFAULT NULL,
  `tele_defense` varchar(6) DEFAULT NULL,
  `tele_defense_comments` text,
  `comment` text,
  `scout` varchar(24) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1895 DEFAULT CHARSET=latin1;
TRUNCATE TABLE `performances`;

-- --------------------------------------------------------
--
-- Table: pitdata
-- Purpose: this table stores all pit scouting (which we are not big on - therefore just the pictures)
-- Year-Specific: no
--
DROP TABLE IF EXISTS `pitdata`;
CREATE TABLE IF NOT EXISTS `pitdata` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `eventkey` varchar(11) NOT NULL,
  `teamnumber` int(5) NOT NULL,
  `robotPicture` tinytext,
  `driverPicture` tinytext,
  `scout` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
TRUNCATE TABLE `pitdata`;

-- --------------------------------------------------------
--
-- Table: scrapedrankings
-- Purpose: this table is an old (2015) table and is being dropped
-- Year-Specific: n/a
--
DROP TABLE IF EXISTS `scrapedrankings`;

-- --------------------------------------------------------
--
-- Table: teams
-- Purpose: this table is just the teams that are at the events we are scouting and is pulled from TBA
-- Year-Specific: no
--
DROP TABLE IF EXISTS `teams`;
CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `eventkey` varchar(11) DEFAULT NULL,
  `number` int(10) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;
TRUNCATE TABLE `teams`;

-- --------------------------------------------------------
--
-- Table: users
-- Purpose: this table is our list of users and roles.  roles are just strings and are implemented in code.
-- Year-Specific: no
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  `realname` varchar(35) DEFAULT NULL,
  `role` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=latin1;
TRUNCATE TABLE `users`;
INSERT DELAYED IGNORE INTO `users` (`id`, `username`, `password`, `realname`, `role`) VALUES
(1, 'mentor', 'mentor', 'Generic Mentor', 'drive'),
(2, 'driver', 'driver', 'Generic Driver ', 'drive'),
(3, 'scout', 'scout', 'Generic Scout ', 'scout'),
(4, 'mrkhan', 'mrkhan', 'Arshad Khan', 'scout'),
(5, 'meredithp', 'meredithp', 'Meredith Palmer', 'scout'),
(6, 'ricko', 'ricko', 'Rick ODonnell', 'admin'),
(7, 'anushad', 'anushad', 'Anusha Datar', 'admin'),
(8, 'jakeod', 'jakeod', 'Jake ODonnell', 'drive'),
(9, 'shivanip', 'shivanip', 'Shivani Patel', 'scout'),
(10, 'adamk', 'adamk', 'Adam Krupp', 'scout'),
(11, 'annat', 'annat', 'Anna Tamura', 'scout'),
(12, 'ashleyd', 'ashleyd', 'Ashley DeFrancesco', 'scout'),
(13, 'ianc', 'ianc', 'Ian Casciola', 'admin'),
(14, 'melissac', 'melissac', 'Melissa Costello', 'scout'),
(15, 'michellep', 'michellep', 'Michelle Pothier', 'scout'),
(16, 'chrisco', 'chrisco', 'Chris Costello', 'drive'),
(17, 'mattc', 'mattc', 'Matt Chellali', 'scout'),
(18, 'shirinb', 'shirinb', 'Shirin Bakre', 'scout'),
(19, 'danielc', 'danielc', 'Daniel Castellarin', 'scout'),
(20, 'joanneod', 'joanneod', 'Joanne ODonnell', 'scout'),
(21, 'trudog', 'trudog', 'Peter Marek', 'admin'),
(22, 'thomasm', 'thomasm', 'Thomas M.', 'scout'),
(23, 'benh', 'benh', 'Ben Horgan', 'scout'),
(24, 'sarahs', 'sarahs', 'Sarah Schissler', 'scout'),
(25, 'ryanm', 'ryanm', 'Ryan McLaughlin', 'scout'),
(26, 'natet', 'natet', 'Nate Troughman', 'scout'),
(27, 'rajd', 'rajd', 'Raj Datar', 'scout'),
(28, 'kevins', 'kevins', 'Kevin Sebastian', 'scout'),
(29, 'carolinea', 'carolinea', 'Caroline Allain', 'scout'),
(30, 'andrewb', 'andrewb', 'Andrew Buxton', 'scout'),
(31, 'kevinb', 'kevinb', 'Kevin Buxton', 'scout'),
(32, 'eshaand', 'eshaand', 'Eshaan Datar', 'scout'),
(33, 'sydneyc', 'sydneyc', 'Sydney Cooperman', 'scout'),
(34, 'ananyag', 'ananyag', 'Ananya Gurjar', 'scout'),
(35, 'kennyg', 'kennyg', 'Kenny Gazra', 'scout'),
(36, 'g2', 'g2', 'Gerry Pothier II', 'scout'),
(37, 'g3', 'g3', 'Gerry Pothier III', 'scout');
