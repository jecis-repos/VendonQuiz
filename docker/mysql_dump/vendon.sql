-- MySQL dump 10.13  Distrib 8.0.39, for Linux (x86_64)
--
-- Host: localhost    Database: vendon
-- ------------------------------------------------------
-- Server version	8.0.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `answers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question_id` int NOT NULL,
  `answer` text NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`),
  CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers`
--

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
INSERT INTO `answers` VALUES (24,9,'Elliptical',0),(25,9,'Spiral',1),(26,9,'Lenticular',0),(27,9,'Irregular',0),(28,10,'Andromeda A*',0),(29,10,'Sagittarius A*',1),(30,10,'Orion A*',0),(31,10,'Cygnus X-1',0),(32,11,'100 million',0),(33,11,'1 billion',0),(34,11,' 100 billion',1),(35,12,'Triangulum Galaxy',0),(36,12,'Large Magellanic Cloud',1),(37,12,'Small Magellanic Cloud',0),(38,12,'Andromeda Galaxy',0),(39,13,'Virgo Supercluster',0),(40,13,'Local Group',0),(41,13,'Coma Cluster',1),(42,13,'Hercules Cluster',0),(43,14,'Orion Arm',0),(44,14,'Perseus Arm',1),(45,14,'Sagittarius Arm',0),(46,14,'Cygnus Arm',0),(47,15,'Galaxy collision',0),(48,15,'Galaxy merger',0),(49,15,'Galaxy accretion',0),(50,15,'All of the above',1),(51,16,'Galileo Galilei',1),(52,16,'Isaac Newton',0),(53,16,'Edwin Hubble',0),(54,16,'Carl Sagan',0);
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quiz_id` int NOT NULL,
  `question` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_id` (`quiz_id`),
  CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (9,4,'What type of galaxy is the Milky Way?\n'),(10,4,'What is the name of the supermassive black hole at the center of the Milky Way?\n'),(11,4,'How many stars are estimated to be in the Milky Way?\n'),(12,4,'What is the name of the nearest major galaxy to the Milky Way?\n'),(13,4,'What is the name of the group of galaxies that the Milky Way belongs to?\n'),(14,4,'What is the name of the spiral arm in which our solar system is located?\n'),(15,5,'What is the name of the process by which the Milky Way is thought to have formed? '),(16,5,'What is the name of the astronomer who first observed the Milky Way with a telescope?\n');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quizes`
--

DROP TABLE IF EXISTS `quizes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quizes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quizes`
--

LOCK TABLES `quizes` WRITE;
/*!40000 ALTER TABLE `quizes` DISABLE KEYS */;
INSERT INTO `quizes` VALUES (4,'Milky Way Mania','Test your knowledge of our home galaxy, the Milky Way!'),(5,'Milky Way Mania Continued','Test your knowledge of our home galaxy, the Milky Way!');
/*!40000 ALTER TABLE `quizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scores`
--

DROP TABLE IF EXISTS `scores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `scores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `quiz_id` int NOT NULL,
  `score` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `quiz_id` (`quiz_id`)
) ENGINE=InnoDB AUTO_INCREMENT=225 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scores`
--

LOCK TABLES `scores` WRITE;
/*!40000 ALTER TABLE `scores` DISABLE KEYS */;
INSERT INTO `scores` VALUES (154,125,4,0),(155,126,4,4),(156,126,4,0),(157,127,5,2),(158,127,5,0),(159,127,5,0),(160,127,5,0),(161,127,5,0),(162,127,5,0),(163,127,5,0),(164,127,5,0),(165,128,0,0),(166,127,5,0),(167,128,0,0),(168,127,5,0),(169,127,5,0),(170,128,0,0),(171,127,5,0),(172,127,5,0),(173,128,0,0),(174,127,5,0),(175,127,5,0),(176,128,0,0),(177,127,5,0),(178,127,5,0),(179,128,0,0),(180,127,5,0),(181,127,5,0),(182,128,0,0),(183,127,5,0),(184,128,0,0),(185,127,5,0),(186,127,5,0),(187,128,0,0),(188,127,5,0),(189,127,5,0),(190,127,5,0),(191,127,5,0),(192,127,5,0),(193,127,5,0),(194,129,4,2),(195,129,4,0),(196,130,4,4),(197,130,4,0),(198,131,4,3),(199,131,4,0),(200,132,4,4),(201,132,4,0),(202,132,5,2),(203,132,5,0),(204,132,5,0),(205,132,5,0),(206,132,5,0),(207,132,5,0),(208,132,5,0),(209,133,4,6),(210,133,4,0),(211,134,4,4),(212,134,4,0),(213,135,4,4),(214,135,4,0),(215,136,4,4),(216,136,4,0),(217,137,4,0),(218,137,4,0),(219,137,5,1),(220,137,5,0),(221,128,0,0),(222,133,4,0),(223,133,4,0),(224,138,4,1);
/*!40000 ALTER TABLE `scores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `name_2` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (128,''),(136,'admin@admin.com'),(127,'asdfasdfg'),(138,'asdgfasdfg'),(133,'jecis_'),(134,'jecis@pm.me'),(132,'jecis@protonmail.com'),(135,'jekabsporietis@gmail.com'),(131,'sdgf'),(129,'segrWSZDFFGzsdfgh'),(130,'segrWSZDFFGzsdfghsdfrgha'),(137,'viper270497@gmail.com'),(126,'zdxfghszdrfhsrfgdh');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-10  3:33:59
