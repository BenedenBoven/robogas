-- mysqldump-php https://github.com/ifsnop/mysqldump-php
--
-- Host: mysql	Database: appdb
-- ------------------------------------------------------
-- Server version 	10.9.3-MariaDB-1:10.9.3+maria~ubu2204
-- Date: Wed, 01 May 2024 16:16:18 +0200

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40101 SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `atom_media_gallery`
--

DROP TABLE IF EXISTS `atom_media_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_media_gallery` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `media_id` bigint(20) unsigned NOT NULL,
  `gallery_id` bigint(20) unsigned NOT NULL,
  `prio` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `media_id` (`media_id`),
  KEY `gallery_id` (`gallery_id`),
  CONSTRAINT `atom_media_gallery_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `atom_media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `atom_media_gallery_ibfk_2` FOREIGN KEY (`gallery_id`) REFERENCES `atom_galleries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_media_gallery`
--

LOCK TABLES `atom_media_gallery` WRITE;
/*!40000 ALTER TABLE `atom_media_gallery` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `atom_media_gallery` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_media_gallery` with 0 row(s)
--

--
-- Table structure for table `atom_users`
--

DROP TABLE IF EXISTS `atom_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_users`
--

LOCK TABLES `atom_users` WRITE;
/*!40000 ALTER TABLE `atom_users` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `atom_users` VALUES (1,'ronald@benedenboven.nl','$2y$10$UX4vQeKa5YDXOdiFv6c1Pu0ZGUrKtJ2t4o1ySh1CKiDXexr4q3jKi',NULL,'2024-05-01 16:15:56','Ronald','Jesse','/administrator/assets/images/BB-elevator.jpg',NULL,'2024-05-01 14:15:56'),(2,'matthew@benedenboven.nl','$2y$10$VlS8INq7q2uynsj80qJ5EuI/vWotXXhGEvkKJBidv0PfyzKQ7LxF2',NULL,'2018-07-02 10:31:10','Matthew','van Dijk','/administrator/assets/images/BB-elevator.jpg',NULL,'2018-07-02 07:31:10'),(3,'mart@benedenboven.nl','$2y$10$zmbP4QEaJ8N8o/nuoHIrh.yB5S7SvrRSkgUDRPyq0XDBd1d9kScJC',NULL,'2018-10-25 16:24:53','Mart','Knibbe','/administrator/assets/images/BB-elevator.jpg',NULL,'2018-10-25 13:24:53'),(4,'emiel@benedenboven.nl','$2y$10$qj30vApaopumYfaeOz3EVeG3WpiZft9yeUXaL1XHb8V2O4GsMxxKO',NULL,'2019-06-04 04:51:03','Emiel','Brunekreef','/uploads/media/cache/bb-elevator-5ba230298e662.jpg','2018-09-19 08:16:57','2019-06-04 03:51:03'),(5,'bart@benedenboven.nl','$2y$10$L4zTfB0WnKY.hi8Kp/AciuLRR2Sq4xsSjB4XdT/p6kcphN84FxAN6',NULL,'2019-07-24 08:47:13','Bart','van de Glind',NULL,'2019-07-24 05:45:40','2019-07-24 05:47:13');
/*!40000 ALTER TABLE `atom_users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_users` with 5 row(s)
--

--
-- Table structure for table `atom_spider`
--

DROP TABLE IF EXISTS `atom_spider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_spider` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_spider`
--

LOCK TABLES `atom_spider` WRITE;
/*!40000 ALTER TABLE `atom_spider` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `atom_spider` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_spider` with 0 row(s)
--

--
-- Table structure for table `atom_meta`
--

DROP TABLE IF EXISTS `atom_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_meta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `taxonomy_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `taxonomy_id` (`taxonomy_id`),
  CONSTRAINT `atom_meta_ibfk_1` FOREIGN KEY (`taxonomy_id`) REFERENCES `atom_taxonomies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_meta`
--

LOCK TABLES `atom_meta` WRITE;
/*!40000 ALTER TABLE `atom_meta` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `atom_meta` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_meta` with 0 row(s)
--

--
-- Table structure for table `atom_redirects`
--

DROP TABLE IF EXISTS `atom_redirects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_redirects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `from` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_redirects`
--

LOCK TABLES `atom_redirects` WRITE;
/*!40000 ALTER TABLE `atom_redirects` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `atom_redirects` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_redirects` with 0 row(s)
--

--
-- Table structure for table `atom_activations`
--

DROP TABLE IF EXISTS `atom_activations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_activations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `completed_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `atom_activations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `atom_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_activations`
--

LOCK TABLES `atom_activations` WRITE;
/*!40000 ALTER TABLE `atom_activations` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `atom_activations` VALUES (1,1,'rq70PxyyBSi9P5ASlxk2DFrirNh6hOyI',1,'2018-02-14 11:41:05','2018-02-14 09:41:05',NULL),(2,2,'q1e3Y04xmv4Vocj5vj2oKqV7MajakAMi',1,'2018-02-14 11:41:05','2018-02-14 09:41:05',NULL),(3,3,'Ljgw4D6gm0LCHAAAkBNihbRcuxkCt0JL',1,'2018-02-14 11:41:05','2018-02-14 09:41:05',NULL),(4,4,'8PeHa3Ye5YSPk13IcOsOtmxtCoU6QIgF',1,'2018-09-19 11:16:57','2018-09-19 10:16:57',NULL),(5,5,'dUTprrXZAjiwMdwqQLLHe0M7e7sOZ6zs',1,'2019-07-24 08:45:40','2019-07-24 07:45:40',NULL);
/*!40000 ALTER TABLE `atom_activations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_activations` with 5 row(s)
--

--
-- Table structure for table `atom_media`
--

DROP TABLE IF EXISTS `atom_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resizeable` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mimetype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'image',
  `size` int(11) DEFAULT NULL,
  `crop_info` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `model_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `prio` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `polymorphic_index` (`model_type`,`model_id`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_media`
--

LOCK TABLES `atom_media` WRITE;
/*!40000 ALTER TABLE `atom_media` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `atom_media` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_media` with 0 row(s)
--

--
-- Table structure for table `atom_throttle`
--

DROP TABLE IF EXISTS `atom_throttle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_throttle` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `throttle_user_id_index` (`user_id`),
  KEY `type_ip_index` (`type`,`ip`),
  CONSTRAINT `atom_throttle_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `atom_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_throttle`
--

LOCK TABLES `atom_throttle` WRITE;
/*!40000 ALTER TABLE `atom_throttle` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `atom_throttle` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_throttle` with 0 row(s)
--

--
-- Table structure for table `atom_pages`
--

DROP TABLE IF EXISTS `atom_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `long_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `visible_as_page` tinyint(1) NOT NULL DEFAULT 1,
  `header_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_pages`
--

LOCK TABLES `atom_pages` WRITE;
/*!40000 ALTER TABLE `atom_pages` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `atom_pages` VALUES (1,'404 Pagina niet gevonden','404 Pagina niet gevonden','<p>De pagina waar u naar op zoek bent kan niet (meer) worden gevonden.</p>\r\n<p><a href=\"/\">Klik hier</a> om terug naar de homepage te gaan.</p>',1,1,NULL,'2024-05-01 14:05:41','2024-05-01 14:05:41'),(2,'Home','Home','<p>Home</p>',1,1,NULL,'2024-05-01 14:05:41','2024-05-01 14:05:41');
/*!40000 ALTER TABLE `atom_pages` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_pages` with 2 row(s)
--

--
-- Table structure for table `atom_imports`
--

DROP TABLE IF EXISTS `atom_imports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_imports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_imports`
--

LOCK TABLES `atom_imports` WRITE;
/*!40000 ALTER TABLE `atom_imports` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `atom_imports` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_imports` with 0 row(s)
--

--
-- Table structure for table `atom_admin_navigation`
--

DROP TABLE IF EXISTS `atom_admin_navigation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_admin_navigation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prio` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_admin_navigation`
--

LOCK TABLES `atom_admin_navigation` WRITE;
/*!40000 ALTER TABLE `atom_admin_navigation` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `atom_admin_navigation` VALUES (1,0,'Content',0,'2024-05-01 14:16:11','2024-05-01 14:16:11'),(2,2,'',1,'2024-05-01 14:16:11','2024-05-01 14:16:11'),(3,7,'',2,'2024-05-01 14:16:11','2024-05-01 14:16:11'),(4,0,'Gebruikers',3,'2024-05-01 14:16:11','2024-05-01 14:16:11'),(5,5,'',4,'2024-05-01 14:16:11','2024-05-01 14:16:11'),(6,9,'',5,'2024-05-01 14:16:11','2024-05-01 14:16:11');
/*!40000 ALTER TABLE `atom_admin_navigation` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_admin_navigation` with 6 row(s)
--

--
-- Table structure for table `atom_model_autosaves`
--

DROP TABLE IF EXISTS `atom_model_autosaves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_model_autosaves` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  `saved_values` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_model_autosaves`
--

LOCK TABLES `atom_model_autosaves` WRITE;
/*!40000 ALTER TABLE `atom_model_autosaves` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `atom_model_autosaves` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_model_autosaves` with 0 row(s)
--

--
-- Table structure for table `atom_migrations`
--

DROP TABLE IF EXISTS `atom_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_migrations`
--

LOCK TABLES `atom_migrations` WRITE;
/*!40000 ALTER TABLE `atom_migrations` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `atom_migrations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_migrations` with 0 row(s)
--

--
-- Table structure for table `atom_taxonomies`
--

DROP TABLE IF EXISTS `atom_taxonomies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_taxonomies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `published` tinyint(1) NOT NULL,
  `deletable` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `prio` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `polymorphic_index` (`model_type`,`model_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_taxonomies`
--

LOCK TABLES `atom_taxonomies` WRITE;
/*!40000 ALTER TABLE `atom_taxonomies` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `atom_taxonomies` VALUES (1,'/404-pagina-niet-gevonden','App\\Domains\\Page\\Models\\Page',1,0,1,1,'2024-05-01 14:05:41','2024-05-01 14:05:41',0),(2,'/','App\\Domains\\Page\\Models\\Page',2,0,1,1,'2024-05-01 14:05:41','2024-05-01 14:05:41',0);
/*!40000 ALTER TABLE `atom_taxonomies` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_taxonomies` with 2 row(s)
--

--
-- Table structure for table `atom_navigation_items`
--

DROP TABLE IF EXISTS `atom_navigation_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_navigation_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `navigation_id` bigint(20) unsigned NOT NULL,
  `taxonomy_id` bigint(20) unsigned NOT NULL,
  `parent_id` bigint(20) unsigned NOT NULL,
  `prio` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `navigation_id` (`navigation_id`),
  KEY `taxonomy_id` (`taxonomy_id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `atom_navigation_items_ibfk_1` FOREIGN KEY (`navigation_id`) REFERENCES `atom_navigation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `atom_navigation_items_ibfk_2` FOREIGN KEY (`taxonomy_id`) REFERENCES `atom_taxonomies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `atom_navigation_items_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `atom_navigation_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_navigation_items`
--

LOCK TABLES `atom_navigation_items` WRITE;
/*!40000 ALTER TABLE `atom_navigation_items` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `atom_navigation_items` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_navigation_items` with 0 row(s)
--

--
-- Table structure for table `atom_persistences`
--

DROP TABLE IF EXISTS `atom_persistences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_persistences` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `persistences_code_unique` (`code`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `atom_persistences_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `atom_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_persistences`
--

LOCK TABLES `atom_persistences` WRITE;
/*!40000 ALTER TABLE `atom_persistences` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `atom_persistences` VALUES (1,1,'LHUNRc0jBImT3yUNXzz0zxJED3PecDXd','2024-05-01 14:15:56','2024-05-01 14:15:56');
/*!40000 ALTER TABLE `atom_persistences` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_persistences` with 1 row(s)
--

--
-- Table structure for table `atom_role_users`
--

DROP TABLE IF EXISTS `atom_role_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_role_users` (
  `user_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `atom_role_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `atom_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `atom_role_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `atom_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_role_users`
--

LOCK TABLES `atom_role_users` WRITE;
/*!40000 ALTER TABLE `atom_role_users` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `atom_role_users` VALUES (1,1,NULL,NULL),(2,1,NULL,NULL),(3,1,NULL,NULL),(4,1,NULL,NULL),(5,1,NULL,NULL);
/*!40000 ALTER TABLE `atom_role_users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_role_users` with 5 row(s)
--

--
-- Table structure for table `atom_galleries`
--

DROP TABLE IF EXISTS `atom_galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_galleries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `shortcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_galleries`
--

LOCK TABLES `atom_galleries` WRITE;
/*!40000 ALTER TABLE `atom_galleries` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `atom_galleries` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_galleries` with 0 row(s)
--

--
-- Table structure for table `atom_navigation`
--

DROP TABLE IF EXISTS `atom_navigation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_navigation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_navigation`
--

LOCK TABLES `atom_navigation` WRITE;
/*!40000 ALTER TABLE `atom_navigation` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `atom_navigation` VALUES (1,'default','Default','2024-05-01 14:05:41',NULL);
/*!40000 ALTER TABLE `atom_navigation` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_navigation` with 1 row(s)
--

--
-- Table structure for table `atom_messages_users`
--

DROP TABLE IF EXISTS `atom_messages_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_messages_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `message_id` (`message_id`),
  CONSTRAINT `atom_messages_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `atom_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `atom_messages_users_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `atom_messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_messages_users`
--

LOCK TABLES `atom_messages_users` WRITE;
/*!40000 ALTER TABLE `atom_messages_users` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `atom_messages_users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_messages_users` with 0 row(s)
--

--
-- Table structure for table `atom_reminders`
--

DROP TABLE IF EXISTS `atom_reminders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_reminders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `completed_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `atom_reminders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `atom_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_reminders`
--

LOCK TABLES `atom_reminders` WRITE;
/*!40000 ALTER TABLE `atom_reminders` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `atom_reminders` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_reminders` with 0 row(s)
--

--
-- Table structure for table `atom_settings`
--

DROP TABLE IF EXISTS `atom_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_settings`
--

LOCK TABLES `atom_settings` WRITE;
/*!40000 ALTER TABLE `atom_settings` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `atom_settings` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_settings` with 0 row(s)
--

--
-- Table structure for table `atom_roles`
--

DROP TABLE IF EXISTS `atom_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_roles`
--

LOCK TABLES `atom_roles` WRITE;
/*!40000 ALTER TABLE `atom_roles` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `atom_roles` VALUES (1,'benedenboven','BenedenBoven',NULL,NULL,NULL),(2,'administrator','Administrator',NULL,NULL,NULL);
/*!40000 ALTER TABLE `atom_roles` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_roles` with 2 row(s)
--

--
-- Table structure for table `atom_modules`
--

DROP TABLE IF EXISTS `atom_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_modules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creates_taxonomy` int(11) NOT NULL DEFAULT 1,
  `title_singular` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_plural` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `allow_children` int(11) NOT NULL DEFAULT 0,
  `default_parent_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `controller` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blade_folder` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `in_menu` tinyint(1) NOT NULL DEFAULT 1,
  `organizable` int(11) DEFAULT 0,
  `publishable` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_modules`
--

LOCK TABLES `atom_modules` WRITE;
/*!40000 ALTER TABLE `atom_modules` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `atom_modules` VALUES (2,'paginas',1,'Pagina','Pagina\'s','App\\Domains\\Page\\Models\\Page',1,'0','GenericController','generic','mi-art-track',1,0,1,'0000-00-00 00:00:00',NULL),(3,'inbox',1,'Mail','Inbox','BenedenBoven\\Atom\\Modules\\Mail\\Models\\Mail',0,'0','MailController','mail','icon-mail-read',0,0,1,NULL,NULL),(5,'gebruikers',1,'Gebruiker','Gebruikers','BenedenBoven\\Atom\\Modules\\User\\Models\\User',0,'0','UserController','users','mi-group-add',1,0,1,NULL,NULL),(7,'navigatie',1,'Navigatie','Navigatie','BenedenBoven\\Atom\\Modules\\Navigation\\Models\\Navigation',0,'0','NavigationController','navigation','mi-clear-all',1,0,1,NULL,NULL),(8,'logs',1,'Log','Logs','',0,'0','LogController','logs','mi-info-outline',0,0,1,NULL,NULL),(9,'gebruiker-groepen',1,'Gebruikergroep','Gebruikergroepen','BenedenBoven\\Atom\\Modules\\UserRole\\Models\\UserRole',0,'0','UserRoleController','roles','mi-lock-outline',1,0,1,NULL,NULL),(10,'csv-imports',1,'CSV-import','CSV-imports','BenedenBoven\\Atom\\Modules\\Import\\Models\\Import',0,'0','ImportController','imports','mi-import-export',0,0,1,NULL,NULL);
/*!40000 ALTER TABLE `atom_modules` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_modules` with 7 row(s)
--

--
-- Table structure for table `atom_openingtimes`
--

DROP TABLE IF EXISTS `atom_openingtimes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_openingtimes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `establishment` enum('kantoor') COLLATE utf8mb4_unicode_ci DEFAULT 'kantoor',
  `days` set('monday','tuesday','wednesday','thursday','friday','saturday') COLLATE utf8mb4_unicode_ci DEFAULT 'monday',
  `times` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_openingtimes`
--

LOCK TABLES `atom_openingtimes` WRITE;
/*!40000 ALTER TABLE `atom_openingtimes` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `atom_openingtimes` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_openingtimes` with 0 row(s)
--

--
-- Table structure for table `atom_messages`
--

DROP TABLE IF EXISTS `atom_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_messages`
--

LOCK TABLES `atom_messages` WRITE;
/*!40000 ALTER TABLE `atom_messages` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `atom_messages` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_messages` with 0 row(s)
--

--
-- Table structure for table `atom_mails`
--

DROP TABLE IF EXISTS `atom_mails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_mails` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `from_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_mails`
--

LOCK TABLES `atom_mails` WRITE;
/*!40000 ALTER TABLE `atom_mails` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `atom_mails` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_mails` with 0 row(s)
--

--
-- Table structure for table `atom_openingtime_exceptions`
--

DROP TABLE IF EXISTS `atom_openingtime_exceptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atom_openingtime_exceptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `establishment` enum('default') COLLATE utf8mb4_unicode_ci DEFAULT 'default',
  `day` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `open_time` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `close_time` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atom_openingtime_exceptions`
--

LOCK TABLES `atom_openingtime_exceptions` WRITE;
/*!40000 ALTER TABLE `atom_openingtime_exceptions` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `atom_openingtime_exceptions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `atom_openingtime_exceptions` with 0 row(s)
--

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET AUTOCOMMIT=@OLD_AUTOCOMMIT */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on: Wed, 01 May 2024 16:16:18 +0200
