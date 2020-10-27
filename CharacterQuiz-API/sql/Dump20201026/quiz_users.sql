-- MySQL dump 10.13  Distrib 8.0.21, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: quiz
-- ------------------------------------------------------
-- Server version	8.0.21

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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `password` text NOT NULL,
  `nick` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'matthieuktran@gmail.com','$2y$10$FNDQkV2Hsts4Ygng3FS1zuoyJQXCvFuWCcjHNUwjdRwLTZ31fwxqW','Matthieu'),(4,'matthieuktran3@gmail.com','$2y$10$spuuMvKRhBHd4xU31/YDDu2vXnrgDauCwLPycFY.de9mcDF/m5Teq','Matthieu3'),(14,'mathieuktran@gmail.com','$2y$10$8zAghLe6IZEKav1sFXIslu3c59ixvdhgzvI/xeuKKjADiLeFuG4bC','mathieu'),(15,'mahieuktran@gmail.com','$2y$10$uTQsJScdbOD.w3FSq500L.yyoXZ.LWqwQdjTHDWMjQo2eVWoU5xva','mahieu'),(16,'matthieuktran5@gmail.com','$2y$10$ksq2RcJeOv7IvuRN4RL3fuNhXWGomoygEYx1t.2FY7/5IVlwezAbe','matthieuT'),(17,'matthieuktran6@gmail.com','$2y$10$JQnJvpNTDGjHAvkVKn0BO.a1UeSbh6INkxFM6Q3JswKnGJ8puxriG','matthieuTT'),(18,'mhieuktran@gmail.com','$2y$10$wGxYlb7m4yHhkAXPu8IshuFcANXPdaqmeEXFfHHaPaK5E5rZfR0jy','mhieu'),(19,'matthieuktran7@gmail.com','$2y$10$0LGrtICw1lYMvkZagWB9Vue6MpjcbvHJ5UJO66/HHU4IMzGfex0HO','matthieuTTT'),(20,'bryanho@gmail.com','$2y$10$iCYzSEUiH8b0N4jc0RLV8uXg/WnFGRoCLo1/WXu4NAmBGMOUpmEye','Bryan'),(21,'hieuktran@gmail.com','$2y$10$Chq2laFfMk19Vz2tDS8eMufJNSzbBmUu252WZ4Vnhrf9QWFVg3hVq','hieu');
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

-- Dump completed on 2020-10-26 23:35:47
