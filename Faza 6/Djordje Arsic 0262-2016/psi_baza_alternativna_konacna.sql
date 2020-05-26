CREATE DATABASE  IF NOT EXISTS `psibaza2` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `psibaza2`;
-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: psibaza2
-- ------------------------------------------------------
-- Server version	8.0.18

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `idAdmina` int(11) NOT NULL,
  PRIMARY KEY (`idAdmina`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `koktel`
--

DROP TABLE IF EXISTS `koktel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `koktel` (
  `idKoktela` int(11) NOT NULL AUTO_INCREMENT,
  `idKorisnika` int(11) NOT NULL,
  `naziv` varchar(50) NOT NULL,
  `opis` text NOT NULL,
  `slika` varchar(100) DEFAULT NULL,
  `video` varchar(100) DEFAULT NULL,
  `obrisan` tinyint(4) NOT NULL,
  `datum` timestamp NOT NULL,
  PRIMARY KEY (`idKoktela`),
  KEY `R_1` (`idKorisnika`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `koktel`
--

LOCK TABLES `koktel` WRITE;
/*!40000 ALTER TABLE `koktel` DISABLE KEYS */;
INSERT INTO `koktel` VALUES (1,1,'Martini','Pomešajte vermouth i džin sa kockicama leda i promućkajte. Sipajte u čašu i dodajte 2-3 masline.','martini.jpg','https://www.youtube.com/embed/1Jq4tPutdGQ',0,'2020-05-09 22:00:00'),(2,2,'Margarita','Ako koristite so, onda je sipajte u plitku posudu. Obod čaše natapkajte natopljenom maramicom, a potom ubacite u so. Napunite čašu ledom, dodajte tekilu, sok od limete i na kraju liker od pomorandže. Promešajte i poslužite odmah!','margarita.jpg','https://www.youtube.com/embed/rNsJMY6cP_Q',0,'2020-05-09 22:00:00'),(3,2,'Pina Colada','Napunite šejker ledom i dodajte sve sastojke. Izmućkajte i prespite u duboku čašu sa niskom stopom. Ovo piće zahteva i adekvatnu dekoraciju u vidu trougla ananasa i kušobrančića zabodenog u njega.','pina colada.jpg','https://www.youtube.com/embed/YaQEaf92z00',0,'2020-05-09 22:00:00'),(4,2,'Cuba Libre','Napunite čašu kockicama leda, prelijte ga rumom, potom sokom od limetei na kraju Coca–Colom. Vaš koktel je spreman za serviranje!','cuba libre.jpg','https://www.youtube.com/embed/wQwt_5FhPo',0,'2020-05-09 22:00:00'),(5,2,'White Russian','Pomešajte čašicu votke, dve kašike likera od kafe i kašiku mleka (može i slatka pavlaka). Rezultat je ukusan i kremast koktel, uz koji ćete sigurno lepo provesti praznično veče.','white russian.jpg','https://www.youtube.com/embed/P97PuL0hLOg',0,'2020-05-09 22:00:00'),(6,2,'Mojito','Na dno čaše stavite kašiku smeđeg šećera, potom stavite mrvljeni led i  listove nane a onda pospite rumom, sokom od limete i na kraju mineralnom vodom. Ukrasite čašu kolutovima limete.','mojito.jpg','https://www.youtube.com/embed/3jLhyNpRAp8',0,'2020-05-09 22:00:00');
/*!40000 ALTER TABLE `koktel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `korisnik`
--

DROP TABLE IF EXISTS `korisnik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `korisnik` (
  `idKorisnika` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`idKorisnika`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `korisnik`
--

LOCK TABLES `korisnik` WRITE;
/*!40000 ALTER TABLE `korisnik` DISABLE KEYS */;
INSERT INTO `korisnik` VALUES (1,'admin','Admin123','admin@gmail.com'),(2,'PetarPet','peraABCD','petar@gmail.com'),(3,'AcaA','acaaca','aca@gmaill.com'),(4,'MajaMaj','majaMaj','maja@gmail.com'),(5,'NikolaN','Ninja1','nikola@gmail.com');
/*!40000 ALTER TABLE `korisnik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prijava`
--

DROP TABLE IF EXISTS `prijava`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prijava` (
  `idKoktela` int(11) NOT NULL,
  `datum` timestamp NOT NULL,
  `idRegistrovanog` int(11) NOT NULL,
  `obrisanaPrijava` tinyint(4) NOT NULL,
  PRIMARY KEY (`idKoktela`,`idRegistrovanog`,`datum`),
  KEY `R_10` (`idRegistrovanog`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prijava`
--

LOCK TABLES `prijava` WRITE;
/*!40000 ALTER TABLE `prijava` DISABLE KEYS */;
/*!40000 ALTER TABLE `prijava` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `razlog`
--

DROP TABLE IF EXISTS `razlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `razlog` (
  `idRazloga` int(11) NOT NULL AUTO_INCREMENT,
  `opisRazloga` varchar(100) NOT NULL,
  PRIMARY KEY (`idRazloga`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `razlog`
--

LOCK TABLES `razlog` WRITE;
/*!40000 ALTER TABLE `razlog` DISABLE KEYS */;
INSERT INTO `razlog` VALUES (2,'Postoji sadržaj recepta koji nije vezan sa koktelom.'),(1,'Recept nije tačan.'),(3,'Recept je duplikat drugog recepta.');
/*!40000 ALTER TABLE `razlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `razloziprijave`
--

DROP TABLE IF EXISTS `razloziprijave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `razloziprijave` (
  `idRazloga` int(11) NOT NULL,
  `idKoktela` int(11) NOT NULL,
  `idRegistrovanog` int(11) NOT NULL,
  `duplikat` varchar(100) DEFAULT NULL,
  `datum` timestamp NOT NULL,
  PRIMARY KEY (`idRazloga`,`idKoktela`,`idRegistrovanog`,`datum`),
  KEY `R_13` (`idKoktela`,`idRegistrovanog`,`datum`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `razloziprijave`
--

LOCK TABLES `razloziprijave` WRITE;
/*!40000 ALTER TABLE `razloziprijave` DISABLE KEYS */;
/*!40000 ALTER TABLE `razloziprijave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registrovani`
--

DROP TABLE IF EXISTS `registrovani`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registrovani` (
  `idRegistrovanog` int(11) NOT NULL,
  `obrisanNalog` tinyint(4) NOT NULL,
  PRIMARY KEY (`idRegistrovanog`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registrovani`
--

LOCK TABLES `registrovani` WRITE;
/*!40000 ALTER TABLE `registrovani` DISABLE KEYS */;
INSERT INTO `registrovani` VALUES (3,0),(2,0),(4,0),(5,0);
/*!40000 ALTER TABLE `registrovani` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sadrzineobavezno`
--

DROP TABLE IF EXISTS `sadrzineobavezno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sadrzineobavezno` (
  `kolicina` varchar(50) NOT NULL,
  `idKoktela` int(11) NOT NULL,
  `idSastojka` int(11) NOT NULL,
  PRIMARY KEY (`idKoktela`,`idSastojka`),
  KEY `R_16` (`idSastojka`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sadrzineobavezno`
--

LOCK TABLES `sadrzineobavezno` WRITE;
/*!40000 ALTER TABLE `sadrzineobavezno` DISABLE KEYS */;
INSERT INTO `sadrzineobavezno` VALUES ('1 komad',1,3),('malo',2,7),('15 ml',5,14);
/*!40000 ALTER TABLE `sadrzineobavezno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sadrziobavezno`
--

DROP TABLE IF EXISTS `sadrziobavezno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sadrziobavezno` (
  `idKoktela` int(11) NOT NULL,
  `idSastojka` int(11) NOT NULL,
  `kolicina` varchar(50) NOT NULL,
  PRIMARY KEY (`idKoktela`,`idSastojka`),
  KEY `R_3` (`idSastojka`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sadrziobavezno`
--

LOCK TABLES `sadrziobavezno` WRITE;
/*!40000 ALTER TABLE `sadrziobavezno` DISABLE KEYS */;
INSERT INTO `sadrziobavezno` VALUES (1,1,'60 ml'),(1,2,'15 ml'),(2,4,'60 ml'),(2,5,'15 ml'),(2,6,'30 ml (isceđeno)'),(3,8,'60 ml'),(3,9,'60 ml'),(3,10,'120 ml'),(4,6,'pola voćke (isceđeno)'),(4,8,'50 ml'),(4,11,'100 ml'),(5,12,'2 kašike'),(5,13,'pola šolje'),(5,18,'60 ml'),(6,8,'60 ml'),(6,15,'3 komada'),(6,16,'2 kašike'),(6,17,'100 ml');
/*!40000 ALTER TABLE `sadrziobavezno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sastojak`
--

DROP TABLE IF EXISTS `sastojak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sastojak` (
  `idSastojka` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(20) NOT NULL,
  PRIMARY KEY (`idSastojka`),
  UNIQUE KEY `naziv_UNIQUE` (`naziv`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sastojak`
--

LOCK TABLES `sastojak` WRITE;
/*!40000 ALTER TABLE `sastojak` DISABLE KEYS */;
INSERT INTO `sastojak` VALUES (23,'belo vino'),(26,'brendi'),(11,'coca cola'),(42,'cvekla'),(1,'džin'),(37,'grenadin'),(24,'jaje'),(41,'kampari'),(9,'kokosovo mleko'),(46,'liker od breskve'),(12,'liker od kafe'),(5,'liker od pomorandže'),(15,'listovi sveže nane'),(47,'marakuja'),(3,'masline'),(49,'med'),(17,'mineralna voda'),(13,'mleko'),(48,'pivo'),(25,'pivo od đumbira'),(8,'rum'),(20,'šampanjac/penušavo v'),(38,'sirup (voda i šećer)'),(39,'sirup od javora'),(14,'slatka pavlaka'),(7,'so'),(10,'sok od ananasa'),(45,'sok od brusnice'),(50,'sok od crvene pomora'),(6,'sok od limete'),(22,'sok od limuna'),(40,'sok od paradaiza'),(21,'sok od pomorandže'),(4,'tekila'),(19,'tonik voda'),(2,'vermouth'),(43,'viski'),(44,'višnja'),(18,'vodka'),(16,'žuti šečer');
/*!40000 ALTER TABLE `sastojak` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-26  4:19:53
