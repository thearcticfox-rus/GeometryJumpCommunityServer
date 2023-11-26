-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 18, 2023 at 09:39 AM
-- Server version: 10.11.4-MariaDB-1~deb12u1
-- PHP Version: 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gjps`
--

-- --------------------------------------------------------

--
-- Table structure for table `acccomments`
--

CREATE TABLE `acccomments` (
  `userID` int(10) UNSIGNED NOT NULL,
  `userName` varchar(50) NOT NULL,
  `comment` longtext NOT NULL,
  `commentID` int(10) UNSIGNED NOT NULL,
  `timestamp` int(11) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `isSpam` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `userName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gjp2` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `accountID` int(10) UNSIGNED NOT NULL,
  `saveData` longtext DEFAULT NULL,
  `isAdmin` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `mS` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `frS` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `youtubeurl` varchar(255) NOT NULL DEFAULT '',
  `registerDate` int(11) NOT NULL DEFAULT 0,
  `friendsCount` smallint(5) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
  `ID` int(10) UNSIGNED NOT NULL,
  `type` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `value` varchar(255) NOT NULL DEFAULT '0',
  `timestamp` int(11) NOT NULL DEFAULT 0,
  `value2` varchar(255) NOT NULL DEFAULT '0',
  `value3` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `value4` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `account` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE `blocks` (
  `ID` int(10) UNSIGNED NOT NULL,
  `person1` int(10) UNSIGNED NOT NULL,
  `person2` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `userID` int(10) UNSIGNED NOT NULL,
  `userName` varchar(50) NOT NULL,
  `comment` longtext NOT NULL,
  `levelID` int(10) UNSIGNED NOT NULL,
  `commentID` int(10) UNSIGNED NOT NULL,
  `timestamp` int(11) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `isSpam` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cpshares`
--

CREATE TABLE `cpshares` (
  `shareID` int(10) UNSIGNED NOT NULL,
  `levelID` int(10) UNSIGNED NOT NULL,
  `userID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friendreqs`
--

CREATE TABLE `friendreqs` (
  `accountID` int(10) UNSIGNED NOT NULL,
  `toAccountID` int(10) UNSIGNED NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `uploadDate` int(11) NOT NULL,
  `ID` int(10) UNSIGNED NOT NULL,
  `isNew` tinyint(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friendships`
--

CREATE TABLE `friendships` (
  `ID` int(10) UNSIGNED NOT NULL,
  `person1` int(10) UNSIGNED NOT NULL,
  `person2` int(10) UNSIGNED NOT NULL,
  `isNew1` tinyint(1) UNSIGNED NOT NULL,
  `isNew2` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `gameVersion` tinyint(2) UNSIGNED NOT NULL,
  `binaryVersion` tinyint(2) UNSIGNED NOT NULL DEFAULT 0,
  `userName` mediumtext NOT NULL,
  `levelID` int(10) UNSIGNED NOT NULL,
  `levelName` varchar(255) NOT NULL,
  `levelDesc` mediumtext NOT NULL,
  `levelVersion` smallint(5) UNSIGNED NOT NULL,
  `levelLength` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `audioTrack` tinyint(2) UNSIGNED NOT NULL,
  `password` mediumint(7) UNSIGNED NOT NULL,
  `original` int(10) UNSIGNED NOT NULL,
  `twoPlayer` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `songID` int(11) NOT NULL DEFAULT 0,
  `objects` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `coins` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `requestedStars` tinyint(2) UNSIGNED NOT NULL DEFAULT 0,
  `levelString` longtext DEFAULT NULL,
  `levelInfo` mediumtext NOT NULL,
  `starDifficulty` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0=N/A 10=EASY 20=NORMAL 30=HARD 40=HARDER 50=INSANE 50=AUTO 50=DEMON',
  `downloads` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `likes` int(11) NOT NULL DEFAULT -1,
  `starDemon` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `starAuto` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `starStars` tinyint(2) UNSIGNED NOT NULL DEFAULT 0,
  `uploadDate` bigint(20) NOT NULL,
  `updateDate` bigint(20) NOT NULL,
  `rateDate` bigint(20) NOT NULL DEFAULT 0,
  `starCoins` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `starFeatured` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `userID` int(10) UNSIGNED NOT NULL,
  `extID` varchar(255) NOT NULL,
  `hostname` varchar(255) NOT NULL,
  `isCPShared` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mappacks`
--

CREATE TABLE `mappacks` (
  `ID` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `levels` varchar(512) NOT NULL COMMENT 'entered as "ID of level 1, ID of level 2, ID of level 3" for example "13,14,15" (without the "s)',
  `stars` tinyint(3) UNSIGNED NOT NULL,
  `coins` tinyint(3) UNSIGNED NOT NULL,
  `difficulty` tinyint(2) UNSIGNED NOT NULL,
  `rgbcolors` varchar(11) NOT NULL COMMENT 'entered as R,G,B',
  `colors2` varchar(11) NOT NULL DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `userID` int(10) UNSIGNED NOT NULL,
  `userName` varchar(50) NOT NULL,
  `body` longtext NOT NULL,
  `subject` longtext NOT NULL,
  `accID` int(10) UNSIGNED NOT NULL,
  `messageID` int(10) UNSIGNED NOT NULL,
  `toAccountID` int(10) UNSIGNED NOT NULL,
  `timestamp` int(11) NOT NULL,
  `isNew` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `ID` int(10) UNSIGNED NOT NULL,
  `levelID` int(10) UNSIGNED NOT NULL,
  `hostname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roleassign`
--

CREATE TABLE `roleassign` (
  `assignID` int(10) UNSIGNED NOT NULL,
  `roleID` tinyint(3) UNSIGNED NOT NULL,
  `accountID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `roleID` tinyint(3) UNSIGNED NOT NULL,
  `priority` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `roleName` varchar(255) NOT NULL,
  `commandRate` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `commandFeature` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `commandVerifycoins` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `commandDelete` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `commandSetacc` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `commandRenameOwn` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `commandRenameAll` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `commandPassOwn` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `commandPassAll` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `commandDescriptionOwn` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `commandDescriptionAll` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `commandSharecpOwn` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `commandSharecpAll` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `commandSongOwn` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `commandSongAll` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `actionRateStars` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `actionRequestMod` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `actionSuggestRating` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `actionDeleteComment` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `toolLeaderboardsban` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `toolPackcreate` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `toolModactions` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `toolSuggestlist` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `isDefault` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `ID` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `authorID` int(10) UNSIGNED NOT NULL,
  `authorName` varchar(100) NOT NULL,
  `size` varchar(100) NOT NULL,
  `download` varchar(1337) NOT NULL,
  `hash` varchar(256) NOT NULL DEFAULT '',
  `isDisabled` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `levelsCount` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `reuploadTime` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suggest`
--

CREATE TABLE `suggest` (
  `ID` int(10) UNSIGNED NOT NULL,
  `suggestBy` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `suggestLevelId` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `suggestDifficulty` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 - NA 10 - Easy 20 - Normal 30 - Hard 40 - Harder 50 - Insane/Demon/Auto',
  `suggestStars` tinyint(2) UNSIGNED NOT NULL DEFAULT 0,
  `suggestFeatured` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `suggestAuto` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `suggestDemon` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `timestamp` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `isRegistered` tinyint(1) UNSIGNED NOT NULL,
  `userID` int(10) UNSIGNED NOT NULL,
  `extID` varchar(100) NOT NULL,
  `userName` varchar(69) NOT NULL DEFAULT 'undefined',
  `stars` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `demons` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `icon` tinyint(2) UNSIGNED NOT NULL DEFAULT 0,
  `color1` tinyint(2) UNSIGNED NOT NULL DEFAULT 0,
  `color2` tinyint(2) UNSIGNED NOT NULL DEFAULT 3,
  `iconType` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `coins` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `userCoins` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `gameVersion` tinyint(2) UNSIGNED NOT NULL DEFAULT 0,
  `accIcon` tinyint(2) UNSIGNED NOT NULL DEFAULT 0,
  `accShip` tinyint(2) UNSIGNED NOT NULL DEFAULT 0,
  `accBall` tinyint(2) UNSIGNED NOT NULL DEFAULT 0,
  `accBird` tinyint(2) UNSIGNED NOT NULL DEFAULT 0,
  `accDart` tinyint(2) UNSIGNED NOT NULL DEFAULT 0,
  `accRobot` tinyint(1) UNSIGNED DEFAULT 0,
  `accGlow` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `creatorPoints` double NOT NULL DEFAULT 0,
  `IP` varchar(69) NOT NULL DEFAULT '127.0.0.1',
  `lastPlayed` int(11) NOT NULL DEFAULT 0,
  `isBanned` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `isCreatorBanned` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acccomments`
--
ALTER TABLE `acccomments`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `timestamp` (`timestamp`);

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`accountID`),
  ADD UNIQUE KEY `userName` (`userName`),
  ADD KEY `isAdmin` (`isAdmin`),
  ADD KEY `frS` (`frS`),
  ADD KEY `friendsCount` (`friendsCount`);

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `type` (`type`),
  ADD KEY `value` (`value`),
  ADD KEY `value2` (`value2`),
  ADD KEY `timestamp` (`timestamp`);

--
-- Indexes for table `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD KEY `person1` (`person1`),
  ADD KEY `person2` (`person2`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `levelID` (`levelID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `likes` (`likes`);

--
-- Indexes for table `cpshares`
--
ALTER TABLE `cpshares`
  ADD PRIMARY KEY (`shareID`),
  ADD KEY `levelID` (`levelID`);

--
-- Indexes for table `friendreqs`
--
ALTER TABLE `friendreqs`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `toAccountID` (`toAccountID`),
  ADD KEY `accountID` (`accountID`),
  ADD KEY `uploadDate` (`uploadDate`);

--
-- Indexes for table `friendships`
--
ALTER TABLE `friendships`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `person1` (`person1`),
  ADD KEY `person2` (`person2`),
  ADD KEY `isNew1` (`isNew1`),
  ADD KEY `isNew2` (`isNew2`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`levelID`),
  ADD KEY `levelID` (`levelID`),
  ADD KEY `levelName` (`levelName`),
  ADD KEY `starDifficulty` (`starDifficulty`),
  ADD KEY `starFeatured` (`starFeatured`),
  ADD KEY `userID` (`userID`),
  ADD KEY `likes` (`likes`),
  ADD KEY `downloads` (`downloads`),
  ADD KEY `starStars` (`starStars`),
  ADD KEY `songID` (`songID`),
  ADD KEY `audioTrack` (`audioTrack`),
  ADD KEY `levelLength` (`levelLength`),
  ADD KEY `twoPlayer` (`twoPlayer`),
  ADD KEY `starDemon` (`starDemon`),
  ADD KEY `starAuto` (`starAuto`),
  ADD KEY `extID` (`extID`),
  ADD KEY `uploadDate` (`uploadDate`),
  ADD KEY `updateDate` (`updateDate`),
  ADD KEY `starCoins` (`starCoins`),
  ADD KEY `coins` (`coins`),
  ADD KEY `password` (`password`),
  ADD KEY `original` (`original`),
  ADD KEY `isCPShared` (`isCPShared`),
  ADD KEY `gameVersion` (`gameVersion`),
  ADD KEY `rateDate` (`rateDate`),
  ADD KEY `objects` (`objects`);

--
-- Indexes for table `mappacks`
--
ALTER TABLE `mappacks`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageID`),
  ADD KEY `toAccountID` (`toAccountID`),
  ADD KEY `accID` (`accID`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `levelID` (`levelID`),
  ADD KEY `hostname` (`hostname`);

--
-- Indexes for table `roleassign`
--
ALTER TABLE `roleassign`
  ADD PRIMARY KEY (`assignID`),
  ADD KEY `roleID` (`roleID`),
  ADD KEY `accountID` (`accountID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`roleID`),
  ADD KEY `priority` (`priority`),
  ADD KEY `toolModactions` (`toolModactions`);

--
-- Indexes for table `suggest`
--
ALTER TABLE `suggest`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `timestamp` (`timestamp`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `userName` (`userName`),
  ADD KEY `stars` (`stars`),
  ADD KEY `demons` (`demons`),
  ADD KEY `coins` (`coins`),
  ADD KEY `userCoins` (`userCoins`),
  ADD KEY `gameVersion` (`gameVersion`),
  ADD KEY `creatorPoints` (`creatorPoints`),
  ADD KEY `isBanned` (`isBanned`),
  ADD KEY `isCreatorBanned` (`isCreatorBanned`),
  ADD KEY `extID` (`extID`),
  ADD KEY `IP` (`IP`),
  ADD KEY `isRegistered` (`isRegistered`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acccomments`
--
ALTER TABLE `acccomments`
  MODIFY `commentID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `accountID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cpshares`
--
ALTER TABLE `cpshares`
  MODIFY `shareID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friendreqs`
--
ALTER TABLE `friendreqs`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friendships`
--
ALTER TABLE `friendships`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `levelID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mappacks`
--
ALTER TABLE `mappacks`
  MODIFY `ID` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `messageID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roleassign`
--
ALTER TABLE `roleassign`
  MODIFY `assignID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `roleID` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suggest`
--
ALTER TABLE `suggest`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
