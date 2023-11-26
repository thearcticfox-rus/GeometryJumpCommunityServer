-- MariaDB dump 10.19  Distrib 10.11.4-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: gjcs
-- ------------------------------------------------------
-- Server version	10.11.4-MariaDB-1~deb12u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `acccomments`
--

DROP TABLE IF EXISTS `acccomments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acccomments` (
  `accountID` int(10) unsigned NOT NULL,
  `userName` varchar(50) NOT NULL,
  `comment` longtext NOT NULL,
  `commentID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `isSpam` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`commentID`),
  KEY `accountID` (`accountID`),
  KEY `timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `userName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gjp2` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `accountID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `saveData` longtext DEFAULT NULL,
  `isAdmin` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `mS` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `frS` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `youtubeurl` varchar(255) NOT NULL DEFAULT '',
  `registerDate` int(10) unsigned NOT NULL DEFAULT 0,
  `stars` mediumint(8) unsigned NOT NULL DEFAULT 0,
  `demons` mediumint(8) unsigned NOT NULL DEFAULT 0,
  `icon` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `color1` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `color2` tinyint(2) unsigned NOT NULL DEFAULT 3,
  `iconType` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `coins` smallint(5) unsigned NOT NULL DEFAULT 0,
  `userCoins` mediumint(8) unsigned NOT NULL DEFAULT 0,
  `gameVersion` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `accIcon` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `accShip` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `accBall` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `accBird` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `accDart` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `accRobot` tinyint(1) unsigned DEFAULT 0,
  `accGlow` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `creatorPoints` smallint(5) unsigned NOT NULL DEFAULT 0,
  `lastPlayed` int(10) unsigned NOT NULL DEFAULT 0,
  `isBanned` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `isCreatorBanned` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`accountID`),
  UNIQUE KEY `userName` (`userName`),
  KEY `isAdmin` (`isAdmin`),
  KEY `frS` (`frS`),
  KEY `stars` (`stars`),
  KEY `demons` (`demons`),
  KEY `coins` (`coins`),
  KEY `userCoins` (`userCoins`),
  KEY `gameVersion` (`gameVersion`),
  KEY `creatorPoints` (`creatorPoints`),
  KEY `isBanned` (`isBanned`),
  KEY `isCreatorBanned` (`isCreatorBanned`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `actions`
--

DROP TABLE IF EXISTS `actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actions` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `value` varchar(255) NOT NULL DEFAULT '0',
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `value2` varchar(255) NOT NULL DEFAULT '0',
  `value3` int(10) unsigned NOT NULL DEFAULT 0,
  `value4` int(10) unsigned NOT NULL DEFAULT 0,
  `account` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`),
  KEY `type` (`type`),
  KEY `value` (`value`),
  KEY `value2` (`value2`),
  KEY `timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `blocks`
--

DROP TABLE IF EXISTS `blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blocks` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `person1` int(10) unsigned NOT NULL,
  `person2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  KEY `person1` (`person1`),
  KEY `person2` (`person2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `accountID` int(10) unsigned NOT NULL,
  `userName` varchar(50) NOT NULL,
  `comment` longtext NOT NULL,
  `levelID` int(10) unsigned NOT NULL,
  `commentID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `isSpam` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`commentID`),
  KEY `levelID` (`levelID`),
  KEY `accountID` (`accountID`),
  KEY `likes` (`likes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `friendreqs`
--

DROP TABLE IF EXISTS `friendreqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friendreqs` (
  `accountID` int(10) unsigned NOT NULL,
  `toAccountID` int(10) unsigned NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `uploadDate` int(11) NOT NULL,
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `isNew` tinyint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`ID`),
  KEY `toAccountID` (`toAccountID`),
  KEY `accountID` (`accountID`),
  KEY `uploadDate` (`uploadDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `friendships`
--

DROP TABLE IF EXISTS `friendships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friendships` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `person1` int(10) unsigned NOT NULL,
  `person2` int(10) unsigned NOT NULL,
  `isNew1` tinyint(1) unsigned NOT NULL,
  `isNew2` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `person1` (`person1`),
  KEY `person2` (`person2`),
  KEY `isNew1` (`isNew1`),
  KEY `isNew2` (`isNew2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `levels`
--

DROP TABLE IF EXISTS `levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `levels` (
  `gameVersion` tinyint(2) unsigned NOT NULL,
  `binaryVersion` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `userName` mediumtext NOT NULL,
  `levelID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `levelName` varchar(255) NOT NULL,
  `levelDesc` mediumtext NOT NULL,
  `levelVersion` smallint(5) unsigned NOT NULL,
  `levelLength` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `audioTrack` tinyint(2) unsigned NOT NULL,
  `password` mediumint(7) unsigned NOT NULL,
  `original` int(10) unsigned NOT NULL,
  `twoPlayer` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `songID` int(10) unsigned NOT NULL DEFAULT 0,
  `objects` smallint(5) unsigned NOT NULL DEFAULT 0,
  `coins` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `requestedStars` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `levelString` longtext DEFAULT NULL,
  `levelInfo` mediumtext NOT NULL,
  `starDifficulty` tinyint(2) unsigned NOT NULL DEFAULT 0 COMMENT '0=N/A 10=EASY 20=NORMAL 30=HARD 40=HARDER 50=INSANE 50=AUTO 50=DEMON',
  `downloads` int(10) unsigned NOT NULL DEFAULT 0,
  `likes` int(11) NOT NULL DEFAULT -1,
  `starDemon` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `starAuto` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `starStars` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `uploadDate` bigint(20) unsigned NOT NULL,
  `updateDate` bigint(20) unsigned NOT NULL,
  `rateDate` bigint(20) unsigned NOT NULL DEFAULT 0,
  `starCoins` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `starFeatured` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `accountID` int(10) unsigned NOT NULL,
  `hostname` varchar(255) NOT NULL,
  PRIMARY KEY (`levelID`),
  KEY `levelID` (`levelID`),
  KEY `levelName` (`levelName`),
  KEY `starDifficulty` (`starDifficulty`),
  KEY `starFeatured` (`starFeatured`),
  KEY `accountID` (`accountID`),
  KEY `likes` (`likes`),
  KEY `downloads` (`downloads`),
  KEY `starStars` (`starStars`),
  KEY `songID` (`songID`),
  KEY `audioTrack` (`audioTrack`),
  KEY `levelLength` (`levelLength`),
  KEY `twoPlayer` (`twoPlayer`),
  KEY `starDemon` (`starDemon`),
  KEY `starAuto` (`starAuto`),
  KEY `uploadDate` (`uploadDate`),
  KEY `updateDate` (`updateDate`),
  KEY `starCoins` (`starCoins`),
  KEY `coins` (`coins`),
  KEY `password` (`password`),
  KEY `original` (`original`),
  KEY `gameVersion` (`gameVersion`),
  KEY `rateDate` (`rateDate`),
  KEY `objects` (`objects`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mappacks`
--

DROP TABLE IF EXISTS `mappacks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mappacks` (
  `ID` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `levels` varchar(512) NOT NULL COMMENT 'entered as "ID of level 1, ID of level 2, ID of level 3" for example "13,14,15" (without the "s)',
  `stars` tinyint(3) unsigned NOT NULL,
  `coins` tinyint(3) unsigned NOT NULL,
  `difficulty` tinyint(2) unsigned NOT NULL,
  `rgbcolors` varchar(11) NOT NULL COMMENT 'entered as R,G,B',
  `colors2` varchar(11) NOT NULL DEFAULT 'none',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `accountID` int(10) unsigned NOT NULL,
  `userName` varchar(50) NOT NULL,
  `body` longtext NOT NULL,
  `subject` longtext NOT NULL,
  `messageID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `toAccountID` int(10) unsigned NOT NULL,
  `timestamp` int(11) NOT NULL,
  `isNew` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`messageID`),
  KEY `toAccountID` (`toAccountID`),
  KEY `accountID` (`accountID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `modactions`
--

DROP TABLE IF EXISTS `modactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modactions` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `value` varchar(255) NOT NULL DEFAULT '0',
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `value2` varchar(255) NOT NULL DEFAULT '0',
  `value3` int(10) unsigned NOT NULL DEFAULT 0,
  `value4` varchar(255) NOT NULL DEFAULT '0',
  `value5` int(10) unsigned NOT NULL DEFAULT 0,
  `value6` int(10) unsigned NOT NULL DEFAULT 0,
  `account` int(10) unsigned NOT NULL DEFAULT 0,
  `value7` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `account` (`account`),
  KEY `type` (`type`),
  KEY `value3` (`value3`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `levelID` int(10) unsigned NOT NULL,
  `hostname` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `levelID` (`levelID`),
  KEY `hostname` (`hostname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `roleassign`
--

DROP TABLE IF EXISTS `roleassign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roleassign` (
  `assignID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `roleID` tinyint(3) unsigned NOT NULL,
  `accountID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`assignID`),
  KEY `roleID` (`roleID`),
  KEY `accountID` (`accountID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `roleID` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `priority` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `roleName` varchar(255) NOT NULL,
  `commandRate` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `commandFeature` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `commandVerifycoins` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `commandDelete` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `commandSetacc` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `commandRenameOwn` tinyint(1) unsigned NOT NULL DEFAULT 1,
  `commandRenameAll` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `commandPassOwn` tinyint(1) unsigned NOT NULL DEFAULT 1,
  `commandPassAll` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `commandDescriptionOwn` tinyint(1) unsigned NOT NULL DEFAULT 1,
  `commandDescriptionAll` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `commandSongOwn` tinyint(1) unsigned NOT NULL DEFAULT 1,
  `commandSongAll` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `actionRateStars` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `actionRequestMod` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `actionSuggestRating` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `toolLeaderboardsban` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `toolPackcreate` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `toolModactions` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `toolSuggestlist` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `isDefault` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`roleID`),
  KEY `priority` (`priority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `suggest`
--

DROP TABLE IF EXISTS `suggest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suggest` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `suggestBy` int(10) unsigned NOT NULL DEFAULT 0,
  `suggestLevelId` int(10) unsigned NOT NULL DEFAULT 0,
  `suggestDifficulty` tinyint(2) unsigned NOT NULL DEFAULT 0 COMMENT '0 - NA 10 - Easy 20 - Normal 30 - Hard 40 - Harder 50 - Insane/Demon/Auto',
  `suggestStars` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `suggestFeatured` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `suggestAuto` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `suggestDemon` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `timestamp` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-26 19:55:33
