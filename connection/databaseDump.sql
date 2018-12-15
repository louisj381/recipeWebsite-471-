CREATE DATABASE  IF NOT EXISTS `Project_Database` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `Project_Database`;
-- MySQL dump 10.13  Distrib 8.0.13, for macos10.14 (x86_64)
--
-- Host: cpsc471-project-instance.ceecwhryx0kc.us-east-2.rds.amazonaws.com    Database: Project_Database
-- ------------------------------------------------------
-- Server version	5.6.41-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ALLERGY`
--

DROP TABLE IF EXISTS `ALLERGY`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `ALLERGY` (
  `User_Id` int(11) NOT NULL DEFAULT '0',
  `Dep_name` varchar(45) NOT NULL DEFAULT '',
  `Allergy` varchar(45) NOT NULL DEFAULT '',
  `Severity` float DEFAULT NULL,
  PRIMARY KEY (`User_Id`,`Allergy`,`Dep_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ALLERGY`
--

LOCK TABLES `ALLERGY` WRITE;
/*!40000 ALTER TABLE `ALLERGY` DISABLE KEYS */;
INSERT INTO `ALLERGY` (`User_Id`, `Dep_name`, `Allergy`, `Severity`) VALUES (1,'Rae','Cheese',3),(1,'Keenan','oranges',9),(1,'Rae','Peanuts',8),(1,'Keenan','Plastic',4);
/*!40000 ALTER TABLE `ALLERGY` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CHANNEL`
--

DROP TABLE IF EXISTS `CHANNEL`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `CHANNEL` (
  `Name` varchar(20) NOT NULL,
  `User_Id` int(11) NOT NULL,
  PRIMARY KEY (`Name`),
  KEY `ChannelUser_Id` (`User_Id`),
  CONSTRAINT `ChannelUser_Id` FOREIGN KEY (`User_Id`) REFERENCES `CURATOR` (`User_Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CHANNEL`
--

LOCK TABLES `CHANNEL` WRITE;
/*!40000 ALTER TABLE `CHANNEL` DISABLE KEYS */;
/*!40000 ALTER TABLE `CHANNEL` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CHANNEL_CONTAINS`
--

DROP TABLE IF EXISTS `CHANNEL_CONTAINS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `CHANNEL_CONTAINS` (
  `MealPlanID` int(11) NOT NULL,
  `ChannelName` varchar(20) NOT NULL,
  PRIMARY KEY (`MealPlanID`,`ChannelName`),
  KEY `ChannelContainsName_idx` (`ChannelName`),
  CONSTRAINT `ChannelContainsName` FOREIGN KEY (`ChannelName`) REFERENCES `CHANNEL` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `MealPlanChID` FOREIGN KEY (`MealPlanID`) REFERENCES `MEAL_PLAN` (`MealPlan_Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CHANNEL_CONTAINS`
--

LOCK TABLES `CHANNEL_CONTAINS` WRITE;
/*!40000 ALTER TABLE `CHANNEL_CONTAINS` DISABLE KEYS */;
/*!40000 ALTER TABLE `CHANNEL_CONTAINS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CHANNEL_TAGS`
--

DROP TABLE IF EXISTS `CHANNEL_TAGS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `CHANNEL_TAGS` (
  `Channel_Name` varchar(20) NOT NULL,
  `Tag` varchar(15) NOT NULL,
  PRIMARY KEY (`Channel_Name`,`Tag`),
  CONSTRAINT `channelTag` FOREIGN KEY (`Channel_Name`) REFERENCES `CHANNEL` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CHANNEL_TAGS`
--

LOCK TABLES `CHANNEL_TAGS` WRITE;
/*!40000 ALTER TABLE `CHANNEL_TAGS` DISABLE KEYS */;
/*!40000 ALTER TABLE `CHANNEL_TAGS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CURATOR`
--

DROP TABLE IF EXISTS `CURATOR`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `CURATOR` (
  `User_Id` int(11) NOT NULL,
  `Credit_Card` int(19) DEFAULT NULL,
  `Exp_Date` varchar(10) DEFAULT NULL,
  `Sec_Num` int(3) DEFAULT NULL,
  PRIMARY KEY (`User_Id`),
  UNIQUE KEY `User_Id_UNIQUE` (`User_Id`),
  CONSTRAINT `User_Id` FOREIGN KEY (`User_Id`) REFERENCES `END_USER` (`User_Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CURATOR`
--

LOCK TABLES `CURATOR` WRITE;
/*!40000 ALTER TABLE `CURATOR` DISABLE KEYS */;
INSERT INTO `CURATOR` (`User_Id`, `Credit_Card`, `Exp_Date`, `Sec_Num`) VALUES (49,0,'0000-00-00',0),(50,0,'0000-00-00',0),(53,2147483647,'0000-00-00',236),(54,1234567,'0000-00-00',255),(55,0,'0000-00-00',0);
/*!40000 ALTER TABLE `CURATOR` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `DEPENDANTS`
--

DROP TABLE IF EXISTS `DEPENDANTS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `DEPENDANTS` (
  `User_Id` int(11) NOT NULL,
  `Name` varchar(45) NOT NULL,
  `Relationship` varchar(45) DEFAULT NULL,
  `No-of_allergies` int(11) DEFAULT NULL,
  PRIMARY KEY (`User_Id`,`Name`),
  KEY `DependantsAllergies` (`Name`),
  CONSTRAINT `ParentUser_Id` FOREIGN KEY (`User_Id`) REFERENCES `STD_USER` (`User_Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DEPENDANTS`
--

LOCK TABLES `DEPENDANTS` WRITE;
/*!40000 ALTER TABLE `DEPENDANTS` DISABLE KEYS */;
INSERT INTO `DEPENDANTS` (`User_Id`, `Name`, `Relationship`, `No-of_allergies`) VALUES (1,'Keenan','Dad',2),(1,'Rae','Friend',2);
/*!40000 ALTER TABLE `DEPENDANTS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `END_USER`
--

DROP TABLE IF EXISTS `END_USER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `END_USER` (
  `User_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Email_Address` varchar(30) NOT NULL,
  `Screen_Name` varchar(30) NOT NULL,
  `Hashed_Password` char(64) NOT NULL,
  `Curator_Flag` tinyint(1) NOT NULL,
  PRIMARY KEY (`User_Id`),
  UNIQUE KEY `Email_Address` (`Email_Address`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `END_USER`
--

LOCK TABLES `END_USER` WRITE;
/*!40000 ALTER TABLE `END_USER` DISABLE KEYS */;
INSERT INTO `END_USER` (`User_Id`, `Email_Address`, `Screen_Name`, `Hashed_Password`, `Curator_Flag`) VALUES (1,'hey@email.com','happy_dude123','ef92b778bafe771e89245b89ecbc08a44a4e166c06659911881f383d4473e94f',0),(2,'you@email.com','sad_dude123','8f27f432fcbaa4b5180a1cc7a8fa166a93cda3c1bce6f19922dd519d02f4bb39',0),(3,'guys@email.com','angry_dude123','65f4893447c083662611cb6c88a78e8f15bb5e5f2a008939dd153e095730c090',0),(4,'ahhh@email.com','happy_dude123','47ca5c6e306042a395b590e9bfefa31c4e3503ee53f704a0fda9a15fc14b7786',0),(7,'funny@me.com','Keenan','d9ead33aa023f7084c9c0a2c152d1647807cd2a026cbf781d468dc8361307993',0),(8,'louisj123@me.ca','louisj','yes',0),(48,'s','s','043a718774c572bd8a25adbeb1bfcd5c0256ae11cecf9f9c3f925d0e52beaf89',0),(49,'x','x','2d711642b726b04401627ca9fbac32f5c8530fb1903cc4db02258717921a4881',1),(50,'w','w','50e721e49c013f00c62cf59f2163542a9d8df02464efeb615d31051b0fddc326',1),(51,'raeyay@me.ca','mcFearMe','03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',0),(52,'keenan@example.com','keenan21','07307784035fdc5cb2e003cb3d905a4782d034858b6a4699bf26c9804a378cae',0),(53,'louis@example.com','louis_is_cool','7730f039d1ca6788da35b585d05f58797ee243990eb0ea9226cc761bf9236e08',1),(54,'jhgfds@hi.com','abcd','de70fa60cac227cbc13270a26ccde291af94df086959f0958122aedf154d90b5',1),(55,'asdf','pdf','fd391f56b2f26cb0b0acd8ac420dba860bf542e1b49ff6bc84d1eaceaffc0d52',1),(56,'dsafads@me.com','asfgsda','6b8dca09e851a987050463c9c60603e9ad797ba09117056fc2e0c07bcac66e43',0),(57,'kjhgfafsdfasdfsda','fds','f0e4c2f76c58916ec258f246851bea091d14d4247a2fc3e18694461b1816e13b',0);
/*!40000 ALTER TABLE `END_USER` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `HOSTS`
--

DROP TABLE IF EXISTS `HOSTS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `HOSTS` (
  `Channel_name` varchar(20) NOT NULL,
  `MealPlanId` int(11) NOT NULL,
  PRIMARY KEY (`Channel_name`,`MealPlanId`),
  KEY `MealPlanIdHost_idx` (`MealPlanId`),
  CONSTRAINT `ChannelNameHost` FOREIGN KEY (`Channel_name`) REFERENCES `CHANNEL` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `MealPlanIdHost` FOREIGN KEY (`MealPlanId`) REFERENCES `MEAL_PLAN` (`MealPlan_Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `HOSTS`
--

LOCK TABLES `HOSTS` WRITE;
/*!40000 ALTER TABLE `HOSTS` DISABLE KEYS */;
/*!40000 ALTER TABLE `HOSTS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `INGREDIENT`
--

DROP TABLE IF EXISTS `INGREDIENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `INGREDIENT` (
  `Name` varchar(20) NOT NULL,
  `Cal/g` float DEFAULT NULL,
  PRIMARY KEY (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `INGREDIENT`
--

LOCK TABLES `INGREDIENT` WRITE;
/*!40000 ALTER TABLE `INGREDIENT` DISABLE KEYS */;
INSERT INTO `INGREDIENT` (`Name`, `Cal/g`) VALUES ('',0),('bacon',10),('banana',4),('bread',1),('brown bread',6),('butter',4),('cheese',2),('chocolate',10),('coco',15),('cucumber',1),('egg',5),('eggplant',12),('flour',4),('icing',20),('lettuce',1),('milk',4),('orange',3),('potato',3),('steak',7),('strawberry',3),('sugar',15),('tomatoe',1),('yum',3);
/*!40000 ALTER TABLE `INGREDIENT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MEAL`
--

DROP TABLE IF EXISTS `MEAL`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `MEAL` (
  `Meal_Id` int(11) NOT NULL,
  `Meal_type` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`Meal_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MEAL`
--

LOCK TABLES `MEAL` WRITE;
/*!40000 ALTER TABLE `MEAL` DISABLE KEYS */;
INSERT INTO `MEAL` (`Meal_Id`, `Meal_type`) VALUES (1,'eggs and toast'),(2,'steak and potatos'),(3,'fondue night');
/*!40000 ALTER TABLE `MEAL` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MEAL_CONTAINS`
--

DROP TABLE IF EXISTS `MEAL_CONTAINS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `MEAL_CONTAINS` (
  `Meal_Id` int(11) NOT NULL,
  `Recipe_Id` int(11) NOT NULL,
  PRIMARY KEY (`Meal_Id`,`Recipe_Id`),
  KEY `recipeContains_idx` (`Recipe_Id`),
  CONSTRAINT `mealContains` FOREIGN KEY (`Meal_Id`) REFERENCES `MEAL` (`Meal_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `recipeContains` FOREIGN KEY (`Recipe_Id`) REFERENCES `RECIPE` (`Recipe_Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MEAL_CONTAINS`
--

LOCK TABLES `MEAL_CONTAINS` WRITE;
/*!40000 ALTER TABLE `MEAL_CONTAINS` DISABLE KEYS */;
INSERT INTO `MEAL_CONTAINS` (`Meal_Id`, `Recipe_Id`) VALUES (1,6),(1,7),(2,8),(2,9),(3,10),(3,11),(2,12),(3,12);
/*!40000 ALTER TABLE `MEAL_CONTAINS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MEAL_PLAN`
--

DROP TABLE IF EXISTS `MEAL_PLAN`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `MEAL_PLAN` (
  `MealPlan_Id` int(11) NOT NULL,
  `Name` varchar(45) DEFAULT 'Delicious meals',
  `NumberOfMeals` int(11) DEFAULT NULL,
  `Creator` int(11) DEFAULT NULL,
  PRIMARY KEY (`MealPlan_Id`),
  KEY `Creator_idx` (`Creator`),
  CONSTRAINT `Creator` FOREIGN KEY (`Creator`) REFERENCES `END_USER` (`User_Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MEAL_PLAN`
--

LOCK TABLES `MEAL_PLAN` WRITE;
/*!40000 ALTER TABLE `MEAL_PLAN` DISABLE KEYS */;
/*!40000 ALTER TABLE `MEAL_PLAN` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MEAL_PLAN_CONTAINS`
--

DROP TABLE IF EXISTS `MEAL_PLAN_CONTAINS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `MEAL_PLAN_CONTAINS` (
  `MealPlan_Id` int(11) NOT NULL,
  `Meal_Id` int(11) NOT NULL,
  `Date_Time` datetime DEFAULT NULL,
  `User_Id` int(11) DEFAULT NULL,
  `Dependent_Name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`MealPlan_Id`,`Meal_Id`),
  KEY `MealID_idx` (`Meal_Id`),
  KEY `MealPlanUser_idx` (`User_Id`),
  KEY `DepName_idx` (`Dependent_Name`),
  CONSTRAINT `DepName` FOREIGN KEY (`Dependent_Name`) REFERENCES `DEPENDANTS` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `MealID` FOREIGN KEY (`Meal_Id`) REFERENCES `MEAL` (`Meal_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `MealPlanContains` FOREIGN KEY (`MealPlan_Id`) REFERENCES `MEAL_PLAN` (`MealPlan_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `MealPlanUser` FOREIGN KEY (`User_Id`) REFERENCES `STD_USER` (`User_Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MEAL_PLAN_CONTAINS`
--

LOCK TABLES `MEAL_PLAN_CONTAINS` WRITE;
/*!40000 ALTER TABLE `MEAL_PLAN_CONTAINS` DISABLE KEYS */;
/*!40000 ALTER TABLE `MEAL_PLAN_CONTAINS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MEAL_TAGS`
--

DROP TABLE IF EXISTS `MEAL_TAGS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `MEAL_TAGS` (
  `Meal_Id` int(11) NOT NULL,
  `Tags` varchar(15) NOT NULL,
  PRIMARY KEY (`Meal_Id`,`Tags`),
  CONSTRAINT `mealTag` FOREIGN KEY (`Meal_Id`) REFERENCES `MEAL` (`Meal_Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MEAL_TAGS`
--

LOCK TABLES `MEAL_TAGS` WRITE;
/*!40000 ALTER TABLE `MEAL_TAGS` DISABLE KEYS */;
INSERT INTO `MEAL_TAGS` (`Meal_Id`, `Tags`) VALUES (1,'breakfast'),(2,'dinner'),(3,'dinner'),(3,'party');
/*!40000 ALTER TABLE `MEAL_TAGS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RECIPE`
--

DROP TABLE IF EXISTS `RECIPE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `RECIPE` (
  `Recipe_Id` int(11) NOT NULL,
  `Name` varchar(45) DEFAULT NULL,
  `PrepTime` varchar(15) DEFAULT NULL,
  `CookTime` varchar(15) DEFAULT NULL,
  `Rating` float DEFAULT NULL,
  `Instructions` text,
  `creator` varchar(45) NOT NULL DEFAULT 'Louis'' Mom',
  PRIMARY KEY (`Recipe_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RECIPE`
--

LOCK TABLES `RECIPE` WRITE;
/*!40000 ALTER TABLE `RECIPE` DISABLE KEYS */;
INSERT INTO `RECIPE` (`Recipe_Id`, `Name`, `PrepTime`, `CookTime`, `Rating`, `Instructions`, `creator`) VALUES (1,'grilled cheese','5','5',5,'cheese goes on bread, butter each side of bread, place in pan and fry until cheese melts and bread gets crispy','Louis\' Mom'),(2,'pancake','10','20',4,'make batter, fry','Louis\' Mom'),(3,'german pancake','5','45',5,'make batter, bake','Louis\' Mom'),(4,'BLT','5','0',3,'assemble ingredients between bread, add sauces','Louis\' Mom'),(5,'chocolate cupcake','15','30',5,'make batter, bake, ice, enjoy','Louis\' Mom'),(6,'fried egg','2','15',3,'heat greased pan, crack egg, fry egg over medium heat ','Grant'),(7,'toast','1','3',4,'Put bread in toaster, toast it, top with copious amounts of butter','Rae'),(8,'steak','50','20',5,'Marinate, fire up grill, cook steaks evenly','George'),(9,'boiled potatoes','5','20',4,'Add washed potatoes to boiling water, remove when done','Jane'),(10,'cheese fondue','25','10',5,'Cut up bread, heat the cheese','Nicole'),(11,'chocolate fondue','15','15',5,'Cut up fruit and heat chocolate until melted','Mike'),(12,'garden salad','15','0',2,'Cut up veggies and serve in large bowl with olive oil and vinegar','Olivia');
/*!40000 ALTER TABLE `RECIPE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RECIPE_CONTAINS`
--

DROP TABLE IF EXISTS `RECIPE_CONTAINS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `RECIPE_CONTAINS` (
  `Recipe_Id` int(11) NOT NULL,
  `Ingredient` varchar(25) NOT NULL,
  `Quantity` float DEFAULT NULL,
  `Unit` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`Recipe_Id`,`Ingredient`),
  KEY `RecipeIngredient_idx` (`Ingredient`),
  CONSTRAINT `RecipeIdContains` FOREIGN KEY (`Recipe_Id`) REFERENCES `RECIPE` (`Recipe_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `RecipeIngredient` FOREIGN KEY (`Ingredient`) REFERENCES `INGREDIENT` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RECIPE_CONTAINS`
--

LOCK TABLES `RECIPE_CONTAINS` WRITE;
/*!40000 ALTER TABLE `RECIPE_CONTAINS` DISABLE KEYS */;
INSERT INTO `RECIPE_CONTAINS` (`Recipe_Id`, `Ingredient`, `Quantity`, `Unit`) VALUES (1,'bread',2,'slices'),(1,'butter',1,'dollup'),(2,'butter',3,'tbsp'),(2,'flour',1,'cup'),(2,'milk',1,'1/2 cup'),(3,'egg',6,'eggs'),(3,'flour',1,'1/2 cup'),(3,'milk',1,'cup'),(4,'bacon',2,'slice'),(4,'bread',2,'slices'),(4,'lettuce',2,'leaves'),(4,'tomatoe',2,'thick slices'),(5,'coco',2,'cups'),(5,'flour',1,'cup'),(5,'icing',1,'can'),(5,'sugar',2,'cup'),(6,'egg',2,'eggs'),(7,'bread',1,'slice'),(7,'butter',1,'dollup'),(8,'steak',4,'steaks'),(9,'potato',1,'bag'),(10,'bread',2,'loaves'),(10,'cheese',3,'pounds'),(11,'banana',2,'bunches'),(11,'chocolate',15,'bars'),(11,'strawberry',1,'pound');
/*!40000 ALTER TABLE `RECIPE_CONTAINS` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Dumping data for table `RECIPE_REQUIRES_EQUIPT`
--

LOCK TABLES `RECIPE_REQUIRES_EQUIPT` WRITE;
/*!40000 ALTER TABLE `RECIPE_REQUIRES_EQUIPT` DISABLE KEYS */;
/*!40000 ALTER TABLE `RECIPE_REQUIRES_EQUIPT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RECIPE_TAGS`
--

DROP TABLE IF EXISTS `RECIPE_TAGS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `RECIPE_TAGS` (
  `Recipe_Id` int(11) NOT NULL,
  `Tag` varchar(45) NOT NULL,
  PRIMARY KEY (`Recipe_Id`,`Tag`),
  CONSTRAINT `RecipeTag` FOREIGN KEY (`Recipe_Id`) REFERENCES `RECIPE` (`Recipe_Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RECIPE_TAGS`
--

LOCK TABLES `RECIPE_TAGS` WRITE;
/*!40000 ALTER TABLE `RECIPE_TAGS` DISABLE KEYS */;
INSERT INTO `RECIPE_TAGS` (`Recipe_Id`, `Tag`) VALUES (1,'sandwich'),(2,'pancake'),(3,'german'),(3,'pancake'),(4,'sandwitch'),(5,'chocolate'),(5,'party');
/*!40000 ALTER TABLE `RECIPE_TAGS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `STD_USER`
--

DROP TABLE IF EXISTS `STD_USER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `STD_USER` (
  `User_Id` int(11) NOT NULL,
  `First_Name` varchar(30) DEFAULT NULL,
  `Last_Name` varchar(30) DEFAULT NULL,
  `Num_Allergies` int(11) DEFAULT NULL,
  PRIMARY KEY (`User_Id`),
  KEY `User_IdAllergy` (`First_Name`),
  CONSTRAINT `User_IdSTD` FOREIGN KEY (`User_Id`) REFERENCES `END_USER` (`User_Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `STD_USER`
--

LOCK TABLES `STD_USER` WRITE;
/*!40000 ALTER TABLE `STD_USER` DISABLE KEYS */;
INSERT INTO `STD_USER` (`User_Id`, `First_Name`, `Last_Name`, `Num_Allergies`) VALUES (1,'Keen','Sparkles',1),(48,'s','s',0),(51,'Rae','McPhail',0),(52,'Keenan','Gaudio',0),(56,'qwert','trewq',0),(57,'sgsadf','sdafdasfsad',0);
/*!40000 ALTER TABLE `STD_USER` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SUBSCRIPTIONS`
--

DROP TABLE IF EXISTS `SUBSCRIPTIONS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `SUBSCRIPTIONS` (
  `User_Id` int(11) NOT NULL,
  `Channel` varchar(45) NOT NULL,
  PRIMARY KEY (`User_Id`,`Channel`),
  KEY `ChannelSub_idx` (`Channel`),
  CONSTRAINT `ChannelSub` FOREIGN KEY (`Channel`) REFERENCES `CHANNEL` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `endUserSub` FOREIGN KEY (`User_Id`) REFERENCES `END_USER` (`User_Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SUBSCRIPTIONS`
--

LOCK TABLES `SUBSCRIPTIONS` WRITE;
/*!40000 ALTER TABLE `SUBSCRIPTIONS` DISABLE KEYS */;
/*!40000 ALTER TABLE `SUBSCRIPTIONS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SUBSTITUTE`
--

DROP TABLE IF EXISTS `SUBSTITUTE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `SUBSTITUTE` (
  `Name` varchar(20) NOT NULL,
  `ReplacementName` varchar(20) NOT NULL,
  PRIMARY KEY (`Name`,`ReplacementName`),
  KEY `RelpName_idx` (`ReplacementName`),
  CONSTRAINT `RelpName` FOREIGN KEY (`ReplacementName`) REFERENCES `INGREDIENT` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `SubName` FOREIGN KEY (`Name`) REFERENCES `INGREDIENT` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SUBSTITUTE`
--

LOCK TABLES `SUBSTITUTE` WRITE;
/*!40000 ALTER TABLE `SUBSTITUTE` DISABLE KEYS */;
/*!40000 ALTER TABLE `SUBSTITUTE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `USER_INGREDIENTS`
--

DROP TABLE IF EXISTS `USER_INGREDIENTS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `USER_INGREDIENTS` (
  `User_Id` int(11) NOT NULL,
  `Ingredient` varchar(20) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `unit` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`User_Id`,`Ingredient`),
  KEY `IngredientUser_idx` (`Ingredient`),
  CONSTRAINT `IngredientUser` FOREIGN KEY (`Ingredient`) REFERENCES `INGREDIENT` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `UserIDSTD` FOREIGN KEY (`User_Id`) REFERENCES `STD_USER` (`User_Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `USER_INGREDIENTS`
--

LOCK TABLES `USER_INGREDIENTS` WRITE;
/*!40000 ALTER TABLE `USER_INGREDIENTS` DISABLE KEYS */;
INSERT INTO `USER_INGREDIENTS` (`User_Id`, `Ingredient`, `count`, `unit`) VALUES (1,'bread',1,'loaf'),(1,'butter',6,'sticks'),(1,'cheese',1,'kg'),(51,'bread',4,'slices'),(51,'coco',7,'cups'),(51,'eggplant',6,'item'),(51,'orange',4,'item');
/*!40000 ALTER TABLE `USER_INGREDIENTS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `USER_MEALS`
--

DROP TABLE IF EXISTS `USER_MEALS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `USER_MEALS` (
  `User_Id` int(11) NOT NULL,
  `Meal_Id` int(11) NOT NULL,
  PRIMARY KEY (`User_Id`,`Meal_Id`),
  KEY `MealID_idx` (`Meal_Id`),
  CONSTRAINT `UserMealID` FOREIGN KEY (`User_Id`) REFERENCES `END_USER` (`User_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `UserMealsID` FOREIGN KEY (`Meal_Id`) REFERENCES `MEAL` (`Meal_Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `USER_MEALS`
--

LOCK TABLES `USER_MEALS` WRITE;
/*!40000 ALTER TABLE `USER_MEALS` DISABLE KEYS */;
/*!40000 ALTER TABLE `USER_MEALS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `USER_MEAL_PLANS`
--

DROP TABLE IF EXISTS `USER_MEAL_PLANS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `USER_MEAL_PLANS` (
  `User_Id` int(11) NOT NULL,
  `MealPlan_Id` int(11) NOT NULL,
  PRIMARY KEY (`User_Id`,`MealPlan_Id`),
  KEY `MealPlanID_idx` (`MealPlan_Id`),
  CONSTRAINT `UserMealPlanID` FOREIGN KEY (`User_Id`) REFERENCES `END_USER` (`User_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `UserMealPlansID` FOREIGN KEY (`MealPlan_Id`) REFERENCES `MEAL_PLAN` (`MealPlan_Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `USER_MEAL_PLANS`
--

LOCK TABLES `USER_MEAL_PLANS` WRITE;
/*!40000 ALTER TABLE `USER_MEAL_PLANS` DISABLE KEYS */;
/*!40000 ALTER TABLE `USER_MEAL_PLANS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `USER_RECIPES`
--

DROP TABLE IF EXISTS `USER_RECIPES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `USER_RECIPES` (
  `User_Id` int(11) NOT NULL,
  `Recipe_Id` int(11) NOT NULL,
  PRIMARY KEY (`User_Id`,`Recipe_Id`),
  KEY `Recipe_Id_idx` (`Recipe_Id`),
  CONSTRAINT `Recipe_Id` FOREIGN KEY (`Recipe_Id`) REFERENCES `RECIPE` (`Recipe_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `User` FOREIGN KEY (`User_Id`) REFERENCES `STD_USER` (`User_Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `USER_RECIPES`
--

LOCK TABLES `USER_RECIPES` WRITE;
/*!40000 ALTER TABLE `USER_RECIPES` DISABLE KEYS */;
INSERT INTO `USER_RECIPES` (`User_Id`, `Recipe_Id`) VALUES (1,1),(1,5);
/*!40000 ALTER TABLE `USER_RECIPES` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-06 13:53:55
