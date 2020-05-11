CREATE DATABASE  IF NOT EXISTS `psibaza` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `psibaza`;
-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: psibaza
-- ------------------------------------------------------
-- Server version	8.0.19

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
  `idAdmina` int NOT NULL,
  PRIMARY KEY (`idAdmina`),
  CONSTRAINT `R_8` FOREIGN KEY (`idAdmina`) REFERENCES `korisnik` (`idKorisnika`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
  `idKoktela` int NOT NULL AUTO_INCREMENT,
  `idKorisnika` int NOT NULL,
  `naziv` varchar(50) NOT NULL,
  `opis` text NOT NULL,
  `slika` varchar(100) DEFAULT NULL,
  `video` varchar(100) DEFAULT NULL,
  `obrisan` tinyint NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`idKoktela`),
  KEY `R_1` (`idKorisnika`),
  CONSTRAINT `R_1` FOREIGN KEY (`idKorisnika`) REFERENCES `korisnik` (`idKorisnika`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `koktel`
--

LOCK TABLES `koktel` WRITE;
/*!40000 ALTER TABLE `koktel` DISABLE KEYS */;
INSERT INTO `koktel` VALUES (1,1,'Martini','Pomešajte vermouth i džin sa kockicama leda i promućkajte. Sipajte u čašu i dodajte 2-3 masline.',NULL,NULL,0,'2020-05-10'),(2,2,'Margarita','Ako koristite so, onda je sipajte u plitku posudu. Obod čaše natapkajte natopljenom maramicom, a potom ubacite u so. Napunite čašu ledom, dodajte tekilu, sok od limete i na kraju liker od pomorandže. Promešajte i poslužite odmah!',NULL,NULL,0,'2020-05-10'),(3,2,'Pina Colada','Napunite šejker ledom i dodajte sve sastojke. Izmućkajte i prespite u duboku čašu sa niskom stopom. Ovo piće zahteva i adekvatnu dekoraciju u vidu trougla ananasa i kušobrančića zabodenog u njega.',NULL,NULL,0,'2020-05-10'),(4,2,'Cuba Libre','Napunite čašu kockicama leda, prelijte ga rumom, potom sokom od limetei na kraju Coca–Colom. Vaš koktel je spreman za serviranje!',NULL,NULL,0,'2020-05-10'),(5,2,'White Russian','Pomešajte čašicu votke, dve kašike likera od kafe i kašiku mleka (može i slatka pavlaka). Rezultat je ukusan i kremast koktel, uz koji ćete sigurno lepo provesti praznično veče.',NULL,NULL,0,'2020-05-10'),(6,2,'Mojito','Na dno čaše stavite kašiku smeđeg šećera, potom stavite mrvljeni led i  listove nane a onda pospite rumom, sokom od limete i na kraju mineralnom vodom. Ukrasite čašu kolutovima limete.',NULL,NULL,0,'2020-05-10');
/*!40000 ALTER TABLE `koktel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `korisnik`
--

DROP TABLE IF EXISTS `korisnik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `korisnik` (
  `idKorisnika` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`idKorisnika`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `korisnik`
--

LOCK TABLES `korisnik` WRITE;
/*!40000 ALTER TABLE `korisnik` DISABLE KEYS */;
INSERT INTO `korisnik` VALUES (1,'admin','Admin123','admin@gmail.com'),(2,'PetarPet','peraABCD','petar@gmail.com');
/*!40000 ALTER TABLE `korisnik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prijava`
--

DROP TABLE IF EXISTS `prijava`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prijava` (
  `idKoktela` int NOT NULL,
  `datum` date NOT NULL,
  `idRegistrovanog` int NOT NULL,
  `obrisanaPrijava` tinyint NOT NULL,
  PRIMARY KEY (`idKoktela`,`idRegistrovanog`),
  KEY `R_10` (`idRegistrovanog`),
  CONSTRAINT `R_10` FOREIGN KEY (`idRegistrovanog`) REFERENCES `registrovani` (`idRegistrovanog`) ON UPDATE CASCADE,
  CONSTRAINT `R_5` FOREIGN KEY (`idKoktela`) REFERENCES `koktel` (`idKoktela`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
  `idRazloga` int NOT NULL AUTO_INCREMENT,
  `opisRazloga` varchar(100) NOT NULL,
  PRIMARY KEY (`idRazloga`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `razlog`
--

LOCK TABLES `razlog` WRITE;
/*!40000 ALTER TABLE `razlog` DISABLE KEYS */;
INSERT INTO `razlog` VALUES (1,'Recept nije tačan.'),(2,'Recept je duplikat drugog recepta.'),(3,'Postoji sadržaj recepta koji nije vezan sa koktelom.');
/*!40000 ALTER TABLE `razlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `razloziprijave`
--

DROP TABLE IF EXISTS `razloziprijave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `razloziprijave` (
  `idRazloga` int NOT NULL,
  `idKoktela` int NOT NULL,
  `idRegistrovanog` int NOT NULL,
  `duplikat` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idRazloga`,`idKoktela`,`idRegistrovanog`),
  KEY `R_13` (`idKoktela`,`idRegistrovanog`),
  CONSTRAINT `R_12` FOREIGN KEY (`idRazloga`) REFERENCES `razlog` (`idRazloga`) ON UPDATE CASCADE,
  CONSTRAINT `R_13` FOREIGN KEY (`idKoktela`, `idRegistrovanog`) REFERENCES `prijava` (`idKoktela`, `idRegistrovanog`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
  `idRegistrovanog` int NOT NULL,
  `obrisanNalog` tinyint NOT NULL,
  PRIMARY KEY (`idRegistrovanog`),
  CONSTRAINT `R_9` FOREIGN KEY (`idRegistrovanog`) REFERENCES `korisnik` (`idKorisnika`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registrovani`
--

LOCK TABLES `registrovani` WRITE;
/*!40000 ALTER TABLE `registrovani` DISABLE KEYS */;
INSERT INTO `registrovani` VALUES (2,0);
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
  `idKoktela` int NOT NULL,
  `idSastojka` int NOT NULL,
  PRIMARY KEY (`idKoktela`,`idSastojka`),
  KEY `R_16` (`idSastojka`),
  CONSTRAINT `R_15` FOREIGN KEY (`idKoktela`) REFERENCES `koktel` (`idKoktela`) ON UPDATE CASCADE,
  CONSTRAINT `R_16` FOREIGN KEY (`idSastojka`) REFERENCES `sastojak` (`idSastojka`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
  `idKoktela` int NOT NULL,
  `idSastojka` int NOT NULL,
  `kolicina` varchar(50) NOT NULL,
  PRIMARY KEY (`idKoktela`,`idSastojka`),
  KEY `R_3` (`idSastojka`),
  CONSTRAINT `R_2` FOREIGN KEY (`idKoktela`) REFERENCES `koktel` (`idKoktela`) ON UPDATE CASCADE,
  CONSTRAINT `R_3` FOREIGN KEY (`idSastojka`) REFERENCES `sastojak` (`idSastojka`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sadrziobavezno`
--

LOCK TABLES `sadrziobavezno` WRITE;
/*!40000 ALTER TABLE `sadrziobavezno` DISABLE KEYS */;
INSERT INTO `sadrziobavezno` VALUES (1,1,'60ml'),(1,2,'15 ml'),(2,4,'60 ml'),(2,5,'15 ml'),(2,6,'30 ml'),(3,8,'60 ml'),(3,9,'60 ml'),(3,10,'120 ml'),(4,6,'isceđeno pola voćke'),(4,8,'50 ml'),(4,11,'100 ml'),(5,12,'2 kašike'),(5,13,'pola šolje'),(5,18,'60 ml'),(6,8,'60 ml'),(6,15,'3 komada'),(6,16,'2 kašike'),(6,17,'100 ml');
/*!40000 ALTER TABLE `sadrziobavezno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sastojak`
--

DROP TABLE IF EXISTS `sastojak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sastojak` (
  `idSastojka` int NOT NULL AUTO_INCREMENT,
  `naziv` varchar(50) NOT NULL,
  PRIMARY KEY (`idSastojka`),
  UNIQUE KEY `naziv_UNIQUE` (`naziv`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sastojak`
--

LOCK TABLES `sastojak` WRITE;
/*!40000 ALTER TABLE `sastojak` DISABLE KEYS */;
INSERT INTO `sastojak` VALUES (11,'coca cola'),(1,'džin'),(9,'kokosovo mleko'),(12,'liker od kafe'),(5,'liker od pomorandže'),(15,'listovi sveže nane'),(3,'masline'),(17,'mineralna voda'),(13,'mleko'),(8,'rum'),(14,'slatka pavlaka'),(7,'so'),(10,'sok od ananasa'),(6,'sok od limete'),(4,'tekila'),(2,'vermouth'),(18,'vodka'),(16,'žuti šečer');
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

-- Dump completed on 2020-05-11 15:05:20
