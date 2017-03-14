-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2017 at 06:30 AM
-- Server version: 5.5.53-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `c9`
--

-- --------------------------------------------------------

--
-- Table structure for table `Ability`
--

CREATE TABLE IF NOT EXISTS `Ability` (
  `ID` int(11) NOT NULL,
  `APCost` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(500) NOT NULL,
  `ActivationType` int(11) NOT NULL,
  `Level` int(11) NOT NULL,
  `Cooldown` int(11) NOT NULL,
  `NoraCost` int(11) NOT NULL,
  `IconName` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`),
  FULLTEXT KEY `Name` (`Name`,`Description`),
  FULLTEXT KEY `Name_2` (`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `AbilitySet`
--

CREATE TABLE IF NOT EXISTS `AbilitySet` (
  `ChampID` int(11) NOT NULL,
  `SetNumber` int(11) NOT NULL,
  `DefaultAbility` int(11) NOT NULL,
  `AbilityID` int(11) NOT NULL,
  PRIMARY KEY (`ChampID`,`SetNumber`,`AbilityID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ChampAbility`
--

CREATE TABLE IF NOT EXISTS `ChampAbility` (
  `ChampID` int(11) NOT NULL,
  `AbilityID` int(11) NOT NULL,
  PRIMARY KEY (`ChampID`,`AbilityID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ChampClass`
--

CREATE TABLE IF NOT EXISTS `ChampClass` (
  `ChampID` int(11) NOT NULL,
  `ClassID` int(11) NOT NULL,
  PRIMARY KEY (`ChampID`,`ClassID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ChampFaction`
--

CREATE TABLE IF NOT EXISTS `ChampFaction` (
  `ChampID` int(11) NOT NULL,
  `FactionID` int(11) NOT NULL,
  PRIMARY KEY (`ChampID`,`FactionID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ChampRace`
--

CREATE TABLE IF NOT EXISTS `ChampRace` (
  `ChampID` int(11) NOT NULL,
  `RaceID` int(11) NOT NULL,
  PRIMARY KEY (`ChampID`,`RaceID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Champions`
--

CREATE TABLE IF NOT EXISTS `Champions` (
  `ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` varchar(500) NOT NULL,
  `MaxRng` int(11) NOT NULL,
  `MinRng` int(11) NOT NULL,
  `Defense` int(11) NOT NULL,
  `Speed` int(11) NOT NULL,
  `Damage` int(11) NOT NULL,
  `HitPoints` int(11) NOT NULL,
  `Size` varchar(11) NOT NULL,
  `Rarity` varchar(11) NOT NULL,
  `NoraCost` int(11) NOT NULL,
  `Hash` varchar(100) NOT NULL,
  `Artist` varchar(100) NOT NULL,
  `RuneSet` varchar(100) NOT NULL,
  `ForSale` int(11) NOT NULL,
  `Tradeable` int(11) NOT NULL,
  `AllowRanked` int(11) NOT NULL,
  `DeckLimit` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  FULLTEXT KEY `Name` (`Name`),
  FULLTEXT KEY `Description` (`Description`),
  FULLTEXT KEY `RuneSet` (`RuneSet`),
  FULLTEXT KEY `RuneSet_2` (`RuneSet`),
  FULLTEXT KEY `Artist` (`Artist`),
  FULLTEXT KEY `Rarity` (`Rarity`),
  FULLTEXT KEY `Name_2` (`Name`),
  FULLTEXT KEY `Name_3` (`Name`,`Description`,`Rarity`,`Artist`,`RuneSet`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Classes`
--

CREATE TABLE IF NOT EXISTS `Classes` (
  `ID` int(11) NOT NULL,
  `Class` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Conditions`
--

CREATE TABLE IF NOT EXISTS `Conditions` (
  `ID` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Identifier` varchar(30) NOT NULL,
  `Description` varchar(500) NOT NULL,
  PRIMARY KEY (`Identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Equipment`
--

CREATE TABLE IF NOT EXISTS `Equipment` (
  `ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` varchar(1000) NOT NULL,
  `FlavorText` varchar(1000) NOT NULL,
  `NoraCost` int(11) NOT NULL,
  `Artist` varchar(100) NOT NULL,
  `Rarity` varchar(100) NOT NULL,
  `RuneSet` varchar(100) NOT NULL,
  `ForSale` int(11) NOT NULL,
  `AllowRanked` int(11) NOT NULL,
  `Tradeable` int(11) NOT NULL,
  `Hash` varchar(100) NOT NULL,
  `DeckLimit` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  FULLTEXT KEY `Name` (`Name`,`Description`,`FlavorText`,`Artist`,`Rarity`,`RuneSet`),
  FULLTEXT KEY `Name_2` (`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `EquipmentFaction`
--

CREATE TABLE IF NOT EXISTS `EquipmentFaction` (
  `EquipmentID` int(11) NOT NULL,
  `FactionID` int(11) NOT NULL,
  PRIMARY KEY (`EquipmentID`,`FactionID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Factions`
--

CREATE TABLE IF NOT EXISTS `Factions` (
  `ID` int(11) NOT NULL,
  `Faction` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Mechanics`
--

CREATE TABLE IF NOT EXISTS `Mechanics` (
  `ID` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Identifier` varchar(30) NOT NULL,
  `Description` varchar(500) NOT NULL,
  PRIMARY KEY (`Identifier`),
  FULLTEXT KEY `Name` (`Name`,`Description`),
  FULLTEXT KEY `Name_2` (`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `PoxDB`
--

CREATE TABLE IF NOT EXISTS `PoxDB` (
  `LastUpdateID` int(11) NOT NULL,
  `LastUpdateTime` date NOT NULL,
  PRIMARY KEY (`LastUpdateID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Races`
--

CREATE TABLE IF NOT EXISTS `Races` (
  `ID` int(11) NOT NULL,
  `Race` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `RelicFaction`
--

CREATE TABLE IF NOT EXISTS `RelicFaction` (
  `RelicID` int(11) NOT NULL,
  `FactionID` int(11) NOT NULL,
  PRIMARY KEY (`RelicID`,`FactionID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Relics`
--

CREATE TABLE IF NOT EXISTS `Relics` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(1000) NOT NULL,
  `FlavorText` varchar(1000) NOT NULL,
  `NoraCost` int(11) NOT NULL,
  `Artist` varchar(100) NOT NULL,
  `Rarity` varchar(50) NOT NULL,
  `RuneSet` varchar(100) NOT NULL,
  `ForSale` int(11) NOT NULL,
  `AllowRanked` int(11) NOT NULL,
  `Tradeable` int(11) NOT NULL,
  `Defense` int(11) NOT NULL,
  `HitPoints` int(11) NOT NULL,
  `Size` varchar(10) NOT NULL,
  `Hash` varchar(100) NOT NULL,
  `DeckLimit` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  FULLTEXT KEY `Name` (`Name`,`Description`,`FlavorText`,`Artist`,`Rarity`,`RuneSet`),
  FULLTEXT KEY `Name_2` (`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `SpellFaction`
--

CREATE TABLE IF NOT EXISTS `SpellFaction` (
  `SpellID` int(11) NOT NULL,
  `FactionID` int(11) NOT NULL,
  PRIMARY KEY (`SpellID`,`FactionID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Spells`
--

CREATE TABLE IF NOT EXISTS `Spells` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(1000) NOT NULL,
  `FlavorText` varchar(1000) NOT NULL,
  `NoraCost` int(11) NOT NULL,
  `Artist` varchar(100) NOT NULL,
  `Rarity` varchar(50) NOT NULL,
  `Cooldown` int(11) NOT NULL,
  `RuneSet` varchar(100) NOT NULL,
  `ForSale` int(11) NOT NULL,
  `AllowRanked` int(11) NOT NULL,
  `Tradeable` int(11) NOT NULL,
  `Hash` varchar(100) NOT NULL,
  `DeckLimit` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  FULLTEXT KEY `Name` (`Name`,`Description`,`FlavorText`,`Artist`,`Rarity`,`RuneSet`),
  FULLTEXT KEY `Name_2` (`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `UserCollection`
--

CREATE TABLE IF NOT EXISTS `UserCollection` (
  `UserID` int(11) NOT NULL,
  `RuneID` int(11) NOT NULL,
  `Type` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Level` int(11) NOT NULL,
  PRIMARY KEY (`UserID`,`RuneID`,`Type`,`Level`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserData`
--

CREATE TABLE IF NOT EXISTS `UserData` (
  `UserID` int(11) NOT NULL,
  `Shards` int(11) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- Database: `user_accounts`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(249) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `verified` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `registered` int(10) unsigned NOT NULL,
  `last_login` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_confirmations`
--

CREATE TABLE IF NOT EXISTS `users_confirmations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(249) COLLATE utf8mb4_unicode_ci NOT NULL,
  `selector` varchar(16) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `email_expires` (`email`,`expires`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_remembered`
--

CREATE TABLE IF NOT EXISTS `users_remembered` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `selector` varchar(24) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_resets`
--

CREATE TABLE IF NOT EXISTS `users_resets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `selector` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `user_expires` (`user`,`expires`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_throttling`
--

CREATE TABLE IF NOT EXISTS `users_throttling` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `action_type` enum('login','register','confirm_email') COLLATE utf8mb4_unicode_ci NOT NULL,
  `selector` varchar(44) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `time_bucket` int(10) unsigned NOT NULL,
  `attempts` mediumint(8) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `action_type_selector_time_bucket` (`action_type`,`selector`,`time_bucket`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=25 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
