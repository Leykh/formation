-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: formation
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

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
-- Table structure for table `formationinscrits`
--

DROP Database if exists formation;
CREATE Database formation;


USE formation;DROP TABLE IF EXISTS `formationinscrits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formationinscrits` (
  `idInscrit` int(11) NOT NULL AUTO_INCREMENT,
  `idFormation` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `dateDebut` datetime NOT NULL,
  `dateFin` datetime DEFAULT NULL,
  PRIMARY KEY (`idInscrit`,`idFormation`,`login`),
  KEY `formationInscrits_IDFormation_FOREIGN` (`idFormation`),
  KEY `formationInscrits_login_FOREIGN` (`login`),
  CONSTRAINT `formationInscrits_IDFormation_FOREIGN` FOREIGN KEY (`idFormation`) REFERENCES `formations` (`id`),
  CONSTRAINT `formationInscrits_login_FOREIGN` FOREIGN KEY (`login`) REFERENCES `utilisateur` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Dumping data for table `formationinscrits`
--

LOCK TABLES `formationinscrits` WRITE;
/*!40000 ALTER TABLE `formationinscrits` DISABLE KEYS */;
INSERT INTO `formationinscrits` VALUES (1, 2,'admin5','2023-02-16 20:42:05','2023-02-16 20:42:51'),(1, 1,'admin5','2023-02-16 20:44:53','2023-02-16 21:29:55'),(3, 1,'admin5','2023-02-16 21:41:34','2023-03-16 11:25:31');
/*!40000 ALTER TABLE `formationinscrits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formationmodules`
--

DROP TABLE IF EXISTS `formationmodules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formationmodules` (
  `idformation` int(11) NOT NULL,
  `idmodules` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `ressource` varchar(255) NOT NULL,
  PRIMARY KEY (`idmodules`),
  KEY `formationModules_IDFormation_FOREIGN` (`idformation`),
  CONSTRAINT `formationModules_IDFormation_FOREIGN` FOREIGN KEY (`IdFormation`) REFERENCES `formations` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formationmodules`
--

LOCK TABLES `formationmodules` WRITE;
/*!40000 ALTER TABLE `formationmodules` DISABLE KEYS */;
INSERT INTO `formationmodules` VALUES (4,1,'TEST','TEST.pdf'),(4,2,'Test2','Test2.jpg'),(4,3,'videotest','videotest.webm');
/*!40000 ALTER TABLE `formationmodules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formations`
--

DROP TABLE IF EXISTS `formations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `cout` double DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `createur` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `formations_login_FK` (`createur`),
  CONSTRAINT `formations_login_FK` FOREIGN KEY (`createur`) REFERENCES `utilisateur` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formations`
--

LOCK TABLES `formations` WRITE;
/*!40000 ALTER TABLE `formations` DISABLE KEYS */;
INSERT INTO `formations` VALUES (1,'Formation au Spatiale','Acquisition de connaissances et de compétences au service d\'un secteur en constante évolution ',1200,'astro.jpg','admin1'),(2,'Java programmation orientée objet','Cette spécialisation s\'adresse aux aspirants développeurs de logiciels ayant une certaine expérience de la programmation dans au moins un autre langage de programmation (par exemple, Python, C, JavaScript, etc.) qui souhaitent être en mesure de résoudre des problèmes plus complexes grâce à une conception orientée objet avec Java. En plus d\'apprendre Java, vous acquerrez de l\'expérience avec deux environnements de développement Java (BlueJ et Eclipse), vous apprendrez à programmer avec des interfaces graphiques et à concevoir des programmes capables de gérer de grandes quantités de données. Ces compétences en génie logiciel sont largement applicables dans un large éventail d\'industries.',2400,'javapoo.jpg','admin1'),(4,'Aide soignant','Une nouvelle formation',8888,'13302_caducee-coeur-aide-soignante-2020.jpg','admin1'),(9,'Developpement web','Apprendre les bases du Js/Html/Css',3939,'60924_web.jpg','admin5');
/*!40000 ALTER TABLE `formations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utilisateur` (
  `login` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `est_valide` int(11) DEFAULT NULL,
  `clef` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateur`
--

LOCK TABLES `utilisateur` WRITE;
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` VALUES ('admin1','$2y$10$.3.KIq5e8ZK1sBKYeMeLuu7ULG5lN8QoSvtQzXpPhw1rSUsWfWWIG','lheykh@gmail.com','administrateur','86136_web.jpg',1,'63db7ba9f4190'),('admin2','$2y$10$ZcgbgC8VAh6N056dr2aQtOpKpTKMLkKRNED40BQvn7FOiN7OPvvDG','lheykh@gmail.com','abonne','73326_caducee-coeur-aide-soignante-2020.jpg',1,'63ef5e65a4e15'),('admin5','$2y$10$g4anvhtWBFtZhE8rG/awXuPZNOk2bBkQxTNjEtjfJa/.1UDTQGLSG','lheykh@gmail.com','CFA','profils/profil.png',1,'63ea5b59a8840'),('test','$2y$10$mKs9OLV8ScClrffXme4xsuhPWwd2ZdTch8.HL4rMerjufrRBvOMTW','lheykh@gmail.com','abonne','profils/profil.png',0,'6413179f7f6c3');
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-19  1:35:32
