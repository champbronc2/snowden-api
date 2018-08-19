-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.17 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for snowden
CREATE DATABASE IF NOT EXISTS `snowden` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `snowden`;


-- Dumping structure for table snowden.conversations
CREATE TABLE IF NOT EXISTS `conversations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(50) NOT NULL DEFAULT 'starting',
  `name` varchar(50) NOT NULL,
  `expiration_date` timestamp NOT NULL,
  `start_distribution` float NOT NULL,
  `complete_distribution` float NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_conversations_user_id` (`user_id`),
  KEY `FK_conversations_recipient_id` (`recipient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table snowden.conversations: ~0 rows (approximately)
/*!40000 ALTER TABLE `conversations` DISABLE KEYS */;
/*!40000 ALTER TABLE `conversations` ENABLE KEYS */;


-- Dumping structure for table snowden.messages
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `content` varchar(1000) NOT NULL DEFAULT '""',
  `reported` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_messages_users` (`user_id`),
  KEY `FK_messages_conversations` (`conversation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table snowden.messages: ~3 rows (approximately)
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;


-- Dumping structure for table snowden.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '""',
  `profile_pic_url` varchar(200) NOT NULL DEFAULT '""',
  `eth_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table snowden.users: ~3 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
