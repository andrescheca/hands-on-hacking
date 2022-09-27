-- MySQL dump 10.13  Distrib 8.0.16, for osx10.12 (x86_64)
--
-- Host: 127.0.0.1    Database: csrf
-- ------------------------------------------------------
-- Server version	8.0.20

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8mb4 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `posts`
--
DROP DATABASE IF EXISTS csrf;
CREATE DATABASE csrf;
USE csrf;

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
	`username` varchar(50) NOT NULL,
	`email` varchar(50) NOT NULL,
	`role` varchar(5) NOT NULL,
  `password` varchar(32) NOT NULL,
  `balance` float NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `messages`
--
DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
	`title` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '0',
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
-- admin password: HHby3zakdtMV6OzPK4vPkucfi54q4y2EIHlq2cCJ
-- user password: user
INSERT INTO `users` (`name`, `username`, `email`, `role`, `password`, `balance`) VALUES
  ('Administrator','admin','admin@example.com','admin','d4977d5d147877bcb52d08bd89f35cde', 1000000),
  ('User', 'user', 'user@example.com', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 10),
	('Alice','alice','alice@example.com','user','85591cd86d3fda6928217a0c91ea8c1c', 100),
	('Bob','bob','bob@example.com','user','a61cd47da2faa1dae230a30dda9720ab', 100),
	('Carol','carol','carol@example.com','user','07dd7056c72d3f0a9a9ecd546e7324ae', 100),
	('Dave','dave','dave@example.com','user','3a47aef7c9e56423460acb8c95a9e61d', 100),
	('Eve','eve','eve@example.com','user','19da28bbf993d07bf8276c98d33c896d', 100),
	('Faythe','faythe','faythe@example.com','user','c895515551b9a6101535d18073c69edd', 100),
	('Grace','grace','grace@example.com','user','c10872012e678d5e6fa356dea76ab0ba', 100),
	('Heidi','heidi','heidi@example.com','user','b82f8057405a7bf77697da4ac5aefd0d', 100),
	('Ivan','ivan','ivan@example.com','user','10d19b06090af453f78a1133abb7e1d4', 100),
	('Judy','judy','judy@example.com','user','3021c8313e5f1dbf230d6836d016d3ff', 100),
	('Mallory','mallory','mallory@example.com','user','e9b4490908220c138192dfca2faec6f9', 100),
	('Niaj','niaj','niaj@example.com','user','c3dd496218df24e69d279c6a319c8e4f', 100),
	('Olivia','olivia','olivia@example.com','user','e7bdf3c00000327a6bdbf885b16ff24d', 100),
	('Peggy','peggy','peggy@example.com','user','b864eea11fe1ccd4df63c1ea25cd5854', 100),
	('Ruppert','ruppert','ruppert@example.com','user','73f19d1ad521bb8241a093bc2c622465', 100),
	('Sybil','sybil','sybil@example.com','user','ac94c2811d5b936e66f5a5d1cdf6d2ba', 100),
	('Trent','trent','trent@example.com','user','86bf5ef8d0a0a5f089b894f7d983877e', 100),
	('Ursula','ursula','ursula@example.com','user','b769d8788e095dff42313563efae3c12', 100),
	('Victor','victor','victor@example.com','user','2d023e4ddaf1f08fe19e98b7474ee7e2', 100),
	('Walter','walter','walter@example.com','user','ad668e3850717cf411d95e510a34036c', 100),
	('Xavier','xavier','xavier@example.com','user','3a10d21632a6d5c7ad75f67e85f88358', 100),
	('Yvonne','yvonne','yvonne@example.com','user','3734db57a5e02405f6b9b78b9e471ca3', 100),
	('Zoe','zoe','zoe@example.com','user','4ef2ef91c558853e756e62188cdd72cc', 100);

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-09  0:47:19
