-- MySQL dump 10.11
--
-- Host: triagecms.triageconsulting.com    Database: triage_2010
-- ------------------------------------------------------
-- Server version	5.1.39-log

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `admin_id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `email` varchar(70) NOT NULL DEFAULT '',
  `password` varchar(15) NOT NULL DEFAULT '',
  `admin_lvl` tinyint(3) NOT NULL DEFAULT '0',
  `first_name` varchar(40) NOT NULL DEFAULT '',
  `last_name` varchar(40) NOT NULL DEFAULT '',
  `create_date` date NOT NULL DEFAULT '0000-00-00',
  `update_date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'sara@skyhighsoftware.com','saralee7',9,'Sara','Swafford','2008-01-29','2009-04-14'),(2,'admin','passw0rd',3,'Admin ','Admin','2009-07-27','2010-07-08'),(3,'arlene@agdesigngroup.net','passw0rd',9,'Arlene','Santos','2010-02-27','2010-02-27'),(4,'perlita@agdesigngroup.net','passw0rd',9,'Perlita','Sahaji','2010-07-08','2010-07-08');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_log`
--

DROP TABLE IF EXISTS `admin_log`;
CREATE TABLE `admin_log` (
  `log_id` int(7) NOT NULL AUTO_INCREMENT,
  `admin_id` tinyint(3) NOT NULL DEFAULT '0',
  `log_date` date NOT NULL DEFAULT '0000-00-00',
  `start_time` time NOT NULL DEFAULT '00:00:00',
  `exp_time` time NOT NULL DEFAULT '00:00:00',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=335 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_log`
--

--
-- Table structure for table `admin_lvls`
--

DROP TABLE IF EXISTS `admin_lvls`;
CREATE TABLE `admin_lvls` (
  `admin_lvl` tinyint(4) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`admin_lvl`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_lvls`
--

LOCK TABLES `admin_lvls` WRITE;
/*!40000 ALTER TABLE `admin_lvls` DISABLE KEYS */;
INSERT INTO `admin_lvls` VALUES (1,'Basic'),(3,'Master Admin'),(9,'Webmaster');
/*!40000 ALTER TABLE `admin_lvls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `campus`
--

DROP TABLE IF EXISTS `campus`;
CREATE TABLE `campus` (
  `campus_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image_file` varchar(255) DEFAULT NULL,
  `other` varchar(255) DEFAULT NULL,
  `create_date` date NOT NULL,
  `show_on_events` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`campus_id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `campus`
--

--
-- Table structure for table `case_studies`
--

DROP TABLE IF EXISTS `case_studies`;
CREATE TABLE `case_studies` (
  `case_study_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `post_date` date NOT NULL,
  `title` varchar(65) NOT NULL DEFAULT '',
  `objective` varchar(182) DEFAULT NULL,
  `client` varchar(182) DEFAULT NULL,
  `complete_text` text NOT NULL,
  `image_file` varchar(255) DEFAULT NULL,
  `pdf_file` varchar(255) DEFAULT NULL,
  `quote` text,
  `author` text,
  `author_title` text,
  `active` int(2) NOT NULL DEFAULT '1',
  `last_update` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`case_study_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `event_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `event_type` tinyint(2) DEFAULT '1',
  `event_name` varchar(100) DEFAULT NULL,
  `event_date` date NOT NULL DEFAULT '0000-00-00',
  `event_time` time DEFAULT NULL,
  `duration` time DEFAULT NULL,
  `place` varchar(50) DEFAULT NULL,
  `description` text,
  `course_id` int(3) DEFAULT NULL,
  `event_coordinator` int(5) DEFAULT '0',
  `event_cost` float DEFAULT NULL,
  `member_cost` float DEFAULT '0',
  `deadline` date DEFAULT NULL,
  `holes` tinyint(2) DEFAULT '2',
  `cart` tinyint(1) DEFAULT '0',
  `cart_cost` float DEFAULT NULL,
  `play_type` tinyint(2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `day_of_week` tinyint(2) DEFAULT NULL,
  `deadline_day` tinyint(1) DEFAULT NULL,
  `deadline_time` time DEFAULT NULL,
  `accept_late_reg` tinyint(1) DEFAULT '1',
  `update_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `spaces_avail` int(5) DEFAULT '0',
  `add_info` varchar(200) DEFAULT NULL,
  `start_show` date DEFAULT '0000-00-00',
  `stop_show` date DEFAULT '0000-00-00',
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs` (
  `faq_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `display_order` varchar(10) DEFAULT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `last_update` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`faq_id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `faqs`
--

--
-- Table structure for table `headers`
--

DROP TABLE IF EXISTS `headers`;
CREATE TABLE `headers` (
  `header_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `last_update` date NOT NULL,
  PRIMARY KEY (`header_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `headers`
--


--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `news_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `news_date` date NOT NULL,
  `title` varchar(65) NOT NULL DEFAULT '',
  `snippet` varchar(182) DEFAULT NULL,
  `complete_text` text NOT NULL,
  `image_file` varchar(255) DEFAULT NULL,
  `pdf_file` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `active` int(2) NOT NULL DEFAULT '1',
  `last_update` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`news_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news`
--



--
-- Table structure for table `organizations`
--

DROP TABLE IF EXISTS `organizations`;
CREATE TABLE `organizations` (
  `org_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `sort_by` varchar(4) DEFAULT NULL,
  `image_file` varchar(255) DEFAULT NULL COMMENT 'logo',
  `name` varchar(50) NOT NULL,
  `short_desc` varchar(255) DEFAULT NULL,
  `description` text,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `extra_1` varchar(255) DEFAULT NULL,
  `extra_2` varchar(255) DEFAULT NULL,
  `extra_3` varchar(255) DEFAULT NULL,
  `last_update` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`org_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `organizations`
--

LOCK TABLES `organizations` WRITE;
/*!40000 ALTER TABLE `organizations` DISABLE KEYS */;
/*!40000 ALTER TABLE `organizations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_types`
--

DROP TABLE IF EXISTS `page_types`;
CREATE TABLE `page_types` (
  `page_type_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `display_order` tinyint(4) NOT NULL DEFAULT '1',
  `title` varchar(55) NOT NULL,
  `description` text,
  `edit_page` varchar(50) NOT NULL DEFAULT 'page_edit.php',
  `display_page` varchar(50) NOT NULL,
  PRIMARY KEY (`page_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `page_types`
--

LOCK TABLES `page_types` WRITE;
/*!40000 ALTER TABLE `page_types` DISABLE KEYS */;
INSERT INTO `page_types` VALUES (71,71,'Sub Menu',NULL,'page_edit.php','page_text.php'),(2,4,'Text with Image',NULL,'page_edit.php','page_text.php'),(3,20,'Staff / Employee / People',NULL,'page_ppl.php','page_ppl.php'),(4,16,'Partners / Sponsors / Organizations',NULL,'page_orgs.php','page_orgs.php'),(5,8,'Text with Image, Quote',NULL,'page_edit.php','page_full.php'),(6,12,'ExpandableText  / FAQs',NULL,'page_faqs.php','page_faqs.php'),(7,11,'Events',NULL,'page_events.php','page_events.php'),(99,99,'Special Functions','Webmaster use only','page_edit.php','page_spec.php'),(8,14,'News','News, Press & Media Pages','page_news.php','press_media.php'),(10,18,'Resources','page for links, pdfs, docs, etc','page_resources.php','page_res.php'),(90,90,'Custom (Home)',NULL,'page_home.php','index.php'),(9,6,'Text with Video',NULL,'page_videos.php','page_videos.php'),(82,82,'Custom (Review Process)',NULL,'page_review.php','page_review.php'),(70,70,'Main Menu',NULL,'page_edit.php','page_text.php'),(81,81,'Custom (Client Map)',NULL,'page_map.php','page_map.php'),(11,9,'Case Studies',NULL,'page_case_studies.php','page_case_studies.php'),(12,10,'Contact',NULL,'page_contact.php','page_contact.php'),(83,83,'Custom (Employee Testimonials)',NULL,'page_employees.php','page_employees.php');
/*!40000 ALTER TABLE `page_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `page_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `left_nav_pos` tinyint(4) DEFAULT NULL,
  `alt_landing_page` int(11) DEFAULT NULL COMMENT 'when children present, alternate landing page other than this page',
  `page_type_id` int(11) NOT NULL,
  `header_id` tinyint(4) DEFAULT NULL,
  `footer` tinyint(1) DEFAULT NULL,
  `title` varchar(65) NOT NULL DEFAULT '',
  `sub_title` varchar(255) DEFAULT NULL,
  `sub_nav_title` varchar(65) NOT NULL,
  `snippet` varchar(255) DEFAULT NULL,
  `other` varchar(255) DEFAULT NULL,
  `other2` varchar(255) DEFAULT NULL,
  `complete_text` text,
  `image_file` varchar(255) DEFAULT NULL,
  `image_size` tinyint(4) DEFAULT NULL,
  `image_pos` tinyint(4) DEFAULT NULL COMMENT '1=left,2=right',
  `pdf_file` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `back_button` tinyint(1) DEFAULT NULL,
  `admin_lvls` varchar(255) NOT NULL DEFAULT '1,2,3,9',
  `last_update` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;


--
-- Table structure for table `people`
--

DROP TABLE IF EXISTS `people`;
CREATE TABLE `people` (
  `people_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `sort_by` varchar(20) DEFAULT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `middle_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `short_desc` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `desc_2` text,
  `desc_3` text,
  `desc_4` text,
  `desc_5` text,
  `table_1` varchar(255) DEFAULT NULL,
  `table_2` varchar(255) DEFAULT NULL,
  `other_1` varchar(255) DEFAULT NULL,
  `image_file` varchar(255) DEFAULT NULL,
  `last_update` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`people_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `people`
--

LOCK TABLES `people` WRITE;
/*!40000 ALTER TABLE `people` DISABLE KEYS */;
/*!40000 ALTER TABLE `people` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource_cats`
--

DROP TABLE IF EXISTS `resource_cats`;
CREATE TABLE `resource_cats` (
  `resource_cat_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`resource_cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `resource_cats`
--

LOCK TABLES `resource_cats` WRITE;
/*!40000 ALTER TABLE `resource_cats` DISABLE KEYS */;
INSERT INTO `resource_cats` VALUES (1,'General');
/*!40000 ALTER TABLE `resource_cats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resources`
--

DROP TABLE IF EXISTS `resources`;
CREATE TABLE `resources` (
  `resource_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `sort_by` varchar(20) DEFAULT NULL,
  `resource_cat_id` tinyint(4) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `short_desc` varchar(255) DEFAULT NULL,
  `resource_link` varchar(255) DEFAULT NULL,
  `resource_file` varchar(255) DEFAULT NULL,
  `last_update` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`resource_id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `resources`
--

LOCK TABLES `resources` WRITE;
/*!40000 ALTER TABLE `resources` DISABLE KEYS */;
/*!40000 ALTER TABLE `resources` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `searches`
--

DROP TABLE IF EXISTS `searches`;
CREATE TABLE `searches` (
  `search_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `create_date` datetime NOT NULL,
  `text` varchar(255) NOT NULL,
  `IP` varchar(25) NOT NULL,
  PRIMARY KEY (`search_id`)
) ENGINE=MyISAM AUTO_INCREMENT=249 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `searches`
--


--
-- Table structure for table `specials`
--

DROP TABLE IF EXISTS `specials`;
CREATE TABLE `specials` (
  `special_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `step1_title` varchar(255) NOT NULL,
  `step1_sub1_title` varchar(255) NOT NULL,
  `step1_sub1` varchar(255) NOT NULL,
  `step1_sub2_title` varchar(255) DEFAULT NULL,
  `step1_sub2` varchar(255) DEFAULT NULL,
  `step1_sub3_title` varchar(255) DEFAULT NULL,
  `step1_sub3` varchar(255) DEFAULT NULL,
  `step1_consider` text NOT NULL,
  `step2_title` varchar(255) NOT NULL,
  `step2_sub1_title` varchar(255) NOT NULL,
  `step2_sub1` varchar(255) NOT NULL,
  `step2_sub2_title` varchar(255) DEFAULT NULL,
  `step2_sub2` varchar(255) DEFAULT NULL,
  `step2_sub3_title` varchar(255) DEFAULT NULL,
  `step2_sub3` varchar(255) DEFAULT NULL,
  `step2_consider` text NOT NULL,
  `step3_title` varchar(255) NOT NULL,
  `step3_sub1_title` varchar(255) NOT NULL,
  `step3_sub1` varchar(255) NOT NULL,
  `step3_sub2_title` varchar(255) DEFAULT NULL,
  `step3_sub2` varchar(255) DEFAULT NULL,
  `step3_sub3_title` varchar(255) DEFAULT NULL,
  `step3_sub3` varchar(255) DEFAULT NULL,
  `step3_consider` text NOT NULL,
  `quick_links` text NOT NULL,
  `other1` text,
  `other2` text,
  `other3` text,
  `last_update` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`special_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `specials`
--

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `sort_by` varchar(20) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `middle_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `short_desc` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `desc_2` text,
  `desc_3` text,
  `desc_4` text,
  `desc_5` text,
  `table_1` varchar(255) DEFAULT NULL,
  `table_2` varchar(255) DEFAULT NULL,
  `other_1` varchar(255) DEFAULT NULL,
  `image_file` varchar(255) DEFAULT NULL,
  `last_update` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=MyISAM AUTO_INCREMENT=349 DEFAULT CHARSET=utf8;


--
-- Table structure for table `staff_types`
--

DROP TABLE IF EXISTS `staff_types`;
CREATE TABLE `staff_types` (
  `staff_type_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`staff_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `staff_types`
--

LOCK TABLES `staff_types` WRITE;
/*!40000 ALTER TABLE `staff_types` DISABLE KEYS */;
INSERT INTO `staff_types` VALUES (1,'Board'),(2,'Principal'),(3,'Manager'),(4,'Senior Associate'),(5,'Associate'),(6,'Recovery Service'),(7,'Administration');
/*!40000 ALTER TABLE `staff_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
CREATE TABLE `videos` (
  `video_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `display_order` varchar(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `swf` varchar(255) DEFAULT NULL,
  `flv` varchar(255) DEFAULT NULL,
  `other1` varchar(255) DEFAULT NULL,
  `other2` varchar(255) DEFAULT NULL,
  `other3` varchar(255) DEFAULT NULL,
  `other4` varchar(255) DEFAULT NULL,
  `last_update` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`video_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `videos`
--

