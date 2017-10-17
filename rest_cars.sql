-- MySQL dump 10.13  Distrib 5.1.66, for portbld-freebsd9.1 (i386)
--
-- Host: localhost    Database: user1
-- ------------------------------------------------------
-- Server version	5.1.66

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


--
-- Table structure for table `rest_cars`
--

DROP TABLE IF EXISTS `rest_cars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rest_cars` (
  `id_car` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(100) NOT NULL,
  `model` varchar(50) NOT NULL,
  `year` int(4) NOT NULL,
  `engine` int(4) NOT NULL,
  `color` varchar(30) NOT NULL,
  `speed` int(4) NOT NULL,
  `price` int(7) NOT NULL,
  PRIMARY KEY (`id_car`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rest_cars`
--

LOCK TABLES `rest_cars` WRITE;
/*!40000 ALTER TABLE `rest_cars` DISABLE KEYS */;
INSERT INTO `rest_cars` VALUES (1,'Bugatti','BG-6',2009,5702,'red',330,1800000),(2,'Bugatti','BG-7',2010,5801,'yellow',300,1900000),(3,'Bugatti','BG-8',2011,7995,'black',380,2500000),(4,'Rolls-Royce','ZM10',2010,5895,'white',240,1800000),(5,'Rolls-Royce','ZM11',2011,6592,'red',250,170000),(6,'Rolls-Royce','ZM12',2012,6992,'black',280,2300000),(7,'Jaguar','XF',2010,2396,'black',290,900000),(8,'Jaguar','XM',2011,2690,'red',275,130000),(9,'Jaguar','XL',2012,2993,'white',280,1700000),(10,'Chevrolet','CHE-L',2009,2793,'yellow',250,100000),(11,'Chevrolet','CHE-M',2011,2893,'black',245,800000),(12,'Chevrolet','CHE-H',2011,2993,'red',295,1400000);
/*!40000 ALTER TABLE `rest_cars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rest_orders`
--

DROP TABLE IF EXISTS `rest_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rest_orders` (
  `id_orders` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_car` int(11) NOT NULL,
  `payment` varchar(50) NOT NULL,
  PRIMARY KEY (`id_orders`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rest_orders`
--

LOCK TABLES `rest_orders` WRITE;
/*!40000 ALTER TABLE `rest_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `rest_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rest_users`
--

DROP TABLE IF EXISTS `rest_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rest_users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(15) NOT NULL,
  `password` varchar(250) NOT NULL,
  `hash` varchar(60) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rest_users`
--

LOCK TABLES `rest_users` WRITE;
/*!40000 ALTER TABLE `rest_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `rest_users` ENABLE KEYS */;
UNLOCK TABLES;


