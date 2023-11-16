-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: localhost    Database: carrent
-- ------------------------------------------------------
-- Server version	8.0.33
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!50503 SET NAMES utf8 */
;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */
;
/*!40103 SET TIME_ZONE='+00:00' */
;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */
;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */
;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */
;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */
;
--
-- Table structure for table `caragency_login`
--
DROP TABLE IF EXISTS `caragency_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `caragency_login` (
  `UID` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`UID`),
  UNIQUE KEY `UID_UNIQUE` (`UID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `caragency_login`
--
LOCK TABLES `caragency_login` WRITE;
/*!40000 ALTER TABLE `caragency_login` DISABLE KEYS */
;
INSERT INTO `caragency_login`
VALUES (
    '6520cf0727452',
    'Prajjwal Pratap Shah',
    'prajjwalpratapshah.2404@gmail.com',
    '$2y$10$X9uGdd32OYKNWS3oLBYvcePQgEHqjmgt9zGGk9rhYKlpDp.ODC.KC'
  ),
(
    '6521514e914d4',
    'Tata Motors',
    'tata@gmail.com',
    '$2y$10$d7ucepSGccZzW/HD0l.pMe.raUnFnD688E7VjlKPFGGzUwA0XddFC'
  );
/*!40000 ALTER TABLE `caragency_login` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `cars`
--
DROP TABLE IF EXISTS `cars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `cars` (
  `CarID` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Model` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Seating` int NOT NULL,
  `Rent` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `AgencyID` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`CarID`),
  UNIQUE KEY `CarID_UNIQUE` (`CarID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `cars`
--
LOCK TABLES `cars` WRITE;
/*!40000 ALTER TABLE `cars` DISABLE KEYS */
;
INSERT INTO `cars`
VALUES (
    '6520fd7259f81',
    'Activa 5g 2015',
    'UP32JW2114',
    2,
    '150.60',
    '6520cf0727452'
  ),
(
    '652100551c40f',
    'Swift 2019',
    'UP32JW2441',
    5,
    '600',
    '6520cf0727452'
  ),
(
    '6521518e71ccb',
    'Safari 2023',
    'MH12AC5875',
    7,
    '1200.50',
    '6521514e914d4'
  );
/*!40000 ALTER TABLE `cars` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `customer_login`
--
DROP TABLE IF EXISTS `customer_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `customer_login` (
  `UID` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`UID`),
  UNIQUE KEY `UID_UNIQUE` (`UID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `customer_login`
--
LOCK TABLES `customer_login` WRITE;
/*!40000 ALTER TABLE `customer_login` DISABLE KEYS */
;
INSERT INTO `customer_login`
VALUES (
    '651e45f66986e',
    'Prajjwal Pratap Shah',
    'prajjwal@gmail.com',
    '$2y$10$d/Mpj2X/89Q1JjT.iiWp/.uf2nJ3T55BGbbx0ryEhKaUblFkx0SjS'
  ),
(
    '651e528a98f5a',
    'Madhvendra',
    'madhv@gmail.com',
    '$2y$10$Rncd86oKJgQObk/SySoMbeqDdo7xO56hOrxI1dlUlOHERfiGBs98i'
  ),
(
    '651e52aa84eae',
    'Madhv',
    'mad@gmail.com',
    '$2y$10$DNWIcw0oTGbK36KJjsTzzu6rMYAhxIV9or/80BrBEXZLB4SUOUo0.'
  );
/*!40000 ALTER TABLE `customer_login` ENABLE KEYS */
;
UNLOCK TABLES;
--
-- Table structure for table `rented`
--
DROP TABLE IF EXISTS `rented`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `rented` (
  `SNo` int NOT NULL AUTO_INCREMENT,
  `CarID` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `AgencyID` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `UID` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `Days` int NOT NULL,
  `Date` date NOT NULL,
  PRIMARY KEY (`SNo`),
  UNIQUE KEY `CarID_UNIQUE` (`SNo`)
) ENGINE = InnoDB AUTO_INCREMENT = 13 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `rented`
--
LOCK TABLES `rented` WRITE;
/*!40000 ALTER TABLE `rented` DISABLE KEYS */
;
INSERT INTO `rented`
VALUES (
    6,
    '6520fd7259f81',
    '6520cf0727452',
    '651e45f66986e',
    5,
    '2023-12-19'
  ),
(
    7,
    '652100551c40f',
    '6520cf0727452',
    '651e45f66986e',
    5,
    '2023-10-14'
  ),
(
    8,
    '6520fd7259f81',
    '6520cf0727452',
    '651e45f66986e',
    4,
    '2023-10-07'
  ),
(
    9,
    '652100551c40f',
    '6520cf0727452',
    '651e45f66986e',
    4,
    '2023-11-07'
  ),
(
    10,
    '652100551c40f',
    '6520cf0727452',
    '651e528a98f5a',
    6,
    '2023-09-05'
  ),
(
    11,
    '6520fd7259f81',
    '6520cf0727452',
    '651e528a98f5a',
    4,
    '2024-01-07'
  ),
(
    12,
    '6521518e71ccb',
    '6521514e914d4',
    '651e45f66986e',
    5,
    '2023-10-18'
  );
/*!40000 ALTER TABLE `rented` ENABLE KEYS */
;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */
;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */
;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */
;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */
;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */
;
-- Dump completed on 2023-10-07 21:11:54