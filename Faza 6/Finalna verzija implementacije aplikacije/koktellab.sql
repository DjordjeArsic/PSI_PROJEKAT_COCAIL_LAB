-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: May 29, 2020 at 02:45 PM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koktellab`
--
CREATE DATABASE IF NOT EXISTS `koktellab` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `koktellab`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `idAdmina` int(11) NOT NULL,
  PRIMARY KEY (`idAdmina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`idAdmina`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `koktel`
--

DROP TABLE IF EXISTS `koktel`;
CREATE TABLE IF NOT EXISTS `koktel` (
  `idKoktela` int(11) NOT NULL AUTO_INCREMENT,
  `idKorisnika` int(11) NOT NULL,
  `naziv` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `opis` text NOT NULL,
  `slika` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `video` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `obrisan` tinyint(4) NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`idKoktela`),
  KEY `R_1` (`idKorisnika`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `koktel`
--

INSERT INTO `koktel` (`idKoktela`, `idKorisnika`, `naziv`, `opis`, `slika`, `video`, `obrisan`, `datum`) VALUES
(1, 1, 'Martini', 'Pomešajte vermut i džin sa kockicama leda i promućkajte. Sipajte u čašu i dodajte 2-3 masline.', 'vodka-martini-recipe.jpg', NULL, 0, '2020-05-10'),
(2, 2, 'Margarita', 'Ako koristite so, onda je sipajte u plitku posudu. Obod čaše natapkajte natopljenom maramicom, a potom ubacite u so. Napunite čašu ledom, dodajte tekilu, sok od limete i na kraju liker od pomorandže. Promešajte i poslužite odmah!', 'Mock-Margaritas-1.jpg', NULL, 0, '2020-05-10'),
(3, 2, 'Pina Colada', 'Napunite šejker ledom i dodajte sve sastojke. Izmućkajte i prespite u duboku čašu sa niskom stopom. Ovo piće zahteva i adekvatnu dekoraciju u vidu trougla ananasa i kišobrančića zabodenog u njega.', 'frozen-pina-colada-recipe-.jpg', NULL, 0, '2020-05-10'),
(4, 2, 'Cuba Libre', 'Napunite čašu kockicama leda, prelijte ga rumom, potom sokom od limete i na kraju coca-colom. Vaš koktel je spreman za serviranje!', 'cocktail-cuba-libre-vicky-wasik-1500x1125.jpg', NULL, 0, '2020-05-10'),
(5, 2, 'White Russian', 'Pomešajte čašicu votke, dve kašike likera od kafe i kašiku mleka (može i slatka pavlaka). Rezultat je ukusan i kremast koktel, uz koji ćete sigurno lepo provesti praznično veče.', 'Keto-White-Russian-1.jpg', NULL, 0, '2020-05-10'),
(6, 2, 'Mojito', 'Na dno čaše stavite kašiku smeđeg šećera, potom stavite mrvljeni led i  listove nane, a onda pospite rumom, sokom od limete i na kraju mineralnom vodom. Ukrasite čašu kolutovima limete.', '90739-5197-mx.jpg', NULL, 0, '2020-05-10');

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

DROP TABLE IF EXISTS `korisnik`;
CREATE TABLE IF NOT EXISTS `korisnik` (
  `idKorisnika` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`idKorisnika`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`idKorisnika`, `username`, `password`, `email`) VALUES
(1, 'admin', 'Admin123', 'admin@gmail.com'),
(2, 'PetarPet', 'peraABCD', 'petar@gmail.com'),
(3, 'AcaA', 'acaaca', 'aca@gmail.com'),
(4, 'MajaMaj', 'majaMaj', 'maja@gmail.com'),
(7, 'marko', 'marko', 'marko@gmail.com'),
(8, 'milica', 'milica', 'milica@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `prijava`
--

DROP TABLE IF EXISTS `prijava`;
CREATE TABLE IF NOT EXISTS `prijava` (
  `idKoktela` int(11) NOT NULL,
  `datum` date NOT NULL,
  `idRegistrovanog` int(11) NOT NULL,
  `obrisanaPrijava` tinyint(4) NOT NULL,
  PRIMARY KEY (`idKoktela`,`idRegistrovanog`),
  KEY `R_10` (`idRegistrovanog`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `razlog`
--

DROP TABLE IF EXISTS `razlog`;
CREATE TABLE IF NOT EXISTS `razlog` (
  `idRazloga` int(11) NOT NULL AUTO_INCREMENT,
  `opisRazloga` varchar(100) NOT NULL,
  PRIMARY KEY (`idRazloga`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `razlog`
--

INSERT INTO `razlog` (`idRazloga`, `opisRazloga`) VALUES
(1, 'Recept nije tačan.'),
(2, 'Postoji sadržaj recepta koji nije vezan sa koktelom.'),
(3, 'Recept je duplikat drugog recepta.');

-- --------------------------------------------------------

--
-- Table structure for table `razloziprijave`
--

DROP TABLE IF EXISTS `razloziprijave`;
CREATE TABLE IF NOT EXISTS `razloziprijave` (
  `idRazloga` int(11) NOT NULL,
  `idKoktela` int(11) NOT NULL,
  `idRegistrovanog` int(11) NOT NULL,
  `duplikat` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idRazloga`,`idKoktela`,`idRegistrovanog`),
  KEY `R_13` (`idKoktela`,`idRegistrovanog`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `registrovani`
--

DROP TABLE IF EXISTS `registrovani`;
CREATE TABLE IF NOT EXISTS `registrovani` (
  `idRegistrovanog` int(11) NOT NULL,
  `obrisanNalog` tinyint(4) NOT NULL,
  PRIMARY KEY (`idRegistrovanog`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `registrovani`
--

INSERT INTO `registrovani` (`idRegistrovanog`, `obrisanNalog`) VALUES
(2, 0),
(3, 0),
(4, 0),
(7, 0),
(8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sadrzineobavezno`
--

DROP TABLE IF EXISTS `sadrzineobavezno`;
CREATE TABLE IF NOT EXISTS `sadrzineobavezno` (
  `kolicina` varchar(50) NOT NULL,
  `idKoktela` int(11) NOT NULL,
  `idSastojka` int(11) NOT NULL,
  PRIMARY KEY (`idKoktela`,`idSastojka`),
  KEY `R_16` (`idSastojka`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sadrzineobavezno`
--

INSERT INTO `sadrzineobavezno` (`kolicina`, `idKoktela`, `idSastojka`) VALUES
('2-3 komada', 1, 3),
('malo', 2, 7),
('15 ml', 5, 14);

-- --------------------------------------------------------

--
-- Table structure for table `sadrziobavezno`
--

DROP TABLE IF EXISTS `sadrziobavezno`;
CREATE TABLE IF NOT EXISTS `sadrziobavezno` (
  `idKoktela` int(11) NOT NULL,
  `idSastojka` int(11) NOT NULL,
  `kolicina` varchar(50) NOT NULL,
  PRIMARY KEY (`idKoktela`,`idSastojka`),
  KEY `R_3` (`idSastojka`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sadrziobavezno`
--

INSERT INTO `sadrziobavezno` (`idKoktela`, `idSastojka`, `kolicina`) VALUES
(1, 1, '60ml'),
(1, 2, '15 ml'),
(2, 4, '60 ml'),
(2, 5, '15 ml'),
(2, 6, '30 ml'),
(3, 8, '60 ml'),
(3, 9, '60 ml'),
(3, 10, '120 ml'),
(4, 6, 'isceđeno pola voćke'),
(4, 8, '50 ml'),
(4, 11, '100 ml'),
(5, 12, '2 kašike'),
(5, 13, 'pola šolje'),
(5, 18, '60 ml'),
(6, 8, '60 ml'),
(6, 15, '3 komada'),
(6, 16, '2 kašike'),
(6, 17, '100 ml');

-- --------------------------------------------------------

--
-- Table structure for table `sastojak`
--

DROP TABLE IF EXISTS `sastojak`;
CREATE TABLE IF NOT EXISTS `sastojak` (
  `idSastojka` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(50) NOT NULL,
  PRIMARY KEY (`idSastojka`),
  UNIQUE KEY `naziv_UNIQUE` (`naziv`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sastojak`
--

INSERT INTO `sastojak` (`idSastojka`, `naziv`) VALUES
(11, 'coca-cola'),
(1, 'džin'),
(9, 'kokosovo mleko'),
(12, 'liker od kafe'),
(5, 'liker od pomorandže'),
(15, 'listovi sveže nane'),
(3, 'masline'),
(17, 'mineralna voda'),
(13, 'mleko'),
(8, 'rum'),
(14, 'slatka pavlaka'),
(7, 'so'),
(10, 'sok od ananasa'),
(6, 'sok od limete'),
(4, 'tekila'),
(2, 'vermut'),
(18, 'votka'),
(16, 'žuti šećer');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `R_8` FOREIGN KEY (`idAdmina`) REFERENCES `korisnik` (`idKorisnika`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `koktel`
--
ALTER TABLE `koktel`
  ADD CONSTRAINT `R_1` FOREIGN KEY (`idKorisnika`) REFERENCES `korisnik` (`idKorisnika`) ON UPDATE CASCADE;

--
-- Constraints for table `prijava`
--
ALTER TABLE `prijava`
  ADD CONSTRAINT `R_10` FOREIGN KEY (`idRegistrovanog`) REFERENCES `registrovani` (`idRegistrovanog`) ON UPDATE CASCADE,
  ADD CONSTRAINT `R_5` FOREIGN KEY (`idKoktela`) REFERENCES `koktel` (`idKoktela`) ON UPDATE CASCADE;

--
-- Constraints for table `razloziprijave`
--
ALTER TABLE `razloziprijave`
  ADD CONSTRAINT `R_12` FOREIGN KEY (`idRazloga`) REFERENCES `razlog` (`idRazloga`) ON UPDATE CASCADE,
  ADD CONSTRAINT `R_13` FOREIGN KEY (`idKoktela`,`idRegistrovanog`) REFERENCES `prijava` (`idKoktela`, `idRegistrovanog`) ON UPDATE CASCADE;

--
-- Constraints for table `registrovani`
--
ALTER TABLE `registrovani`
  ADD CONSTRAINT `R_9` FOREIGN KEY (`idRegistrovanog`) REFERENCES `korisnik` (`idKorisnika`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
