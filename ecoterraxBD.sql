CREATE DATABASE  IF NOT EXISTS `EcoTerraX` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;
USE `EcoTerraX`;
-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: localhost    Database: EcoTerraX
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.26-MariaDB

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
-- Table structure for table `Huerto`
--

DROP TABLE IF EXISTS `Huerto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Huerto` (
  `idHuerto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `provincia` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `pais` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `superficie` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `descripción` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idHuerto`),
  UNIQUE KEY `idHuerto_UNIQUE` (`idHuerto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Huerto`
--

LOCK TABLES `Huerto` WRITE;
/*!40000 ALTER TABLE `Huerto` DISABLE KEYS */;
INSERT INTO `Huerto` VALUES (1,'Huerto CLPV','Valencia','España','10','Huerto del colegio La Purisima Franciscanas Valencia');
/*!40000 ALTER TABLE `Huerto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Medicion`
--

DROP TABLE IF EXISTS `Medicion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Medicion` (
  `idMedicion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idHuerto` int(11) NOT NULL,
  `tempAmb` double NOT NULL,
  `humAmb` double NOT NULL,
  `humTierra` double NOT NULL,
  `fecha` date NOT NULL,
  `hora` time(3) NOT NULL,
  `esRegado` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idMedicion`),
  KEY `fk_huerto_idx` (`idHuerto`),
  CONSTRAINT `fk_huerto` FOREIGN KEY (`idHuerto`) REFERENCES `Huerto` (`idHuerto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Medicion`
--

LOCK TABLES `Medicion` WRITE;
/*!40000 ALTER TABLE `Medicion` DISABLE KEYS */;
/*!40000 ALTER TABLE `Medicion` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-04 13:22:32
