-- MySQL dump 10.13  Distrib 8.0.16, for Win64 (x86_64)
--
-- Host: scc-dev-mysql.mysql.database.azure.com    Database: apps
-- ------------------------------------------------------
-- Server version	5.6.39.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
SET NAMES utf8;
/*!40103 SET @OLD_TIME_ZONE = @@TIME_ZONE */;
/*!40103 SET TIME_ZONE = '+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;

--
-- Table structure for table `apis`
--

DROP TABLE IF EXISTS `apis`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `apis`
(
    `id`          int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name`        varchar(50)      NOT NULL,
    `ip_address`  varchar(39)      NOT NULL,
    `token`       varchar(256)     NOT NULL,
    `created_at`  timestamp        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified_at` timestamp        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `ip_address_token` (`ip_address`, `token`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `app_links`
--

DROP TABLE IF EXISTS `app_links`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `app_links`
(
    `id`            int(10) unsigned NOT NULL AUTO_INCREMENT,
    `app_id`        int(10) unsigned NOT NULL,
    `app_link_id`   int(10) unsigned          DEFAULT NULL,
    `permission_id` int(10) unsigned          DEFAULT NULL,
    `htmlid`        varchar(30)      NOT NULL,
    `title`         varchar(30)      NOT NULL,
    `destination`   varchar(120)     NOT NULL,
    `file_id`       int(10) unsigned          DEFAULT NULL,
    `sort`          int(10) unsigned NOT NULL DEFAULT '0',
    `created_at`    timestamp        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified_at`   timestamp        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `FK_app_links_apps` (`app_id`),
    KEY `FK_app_links_files` (`file_id`),
    KEY `FK_app_links_permissions` (`permission_id`),
    KEY `FK_app_links_app_links` (`app_link_id`),
    CONSTRAINT `FK_app_links_app_links` FOREIGN KEY (`app_link_id`) REFERENCES `app_links` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
    CONSTRAINT `FK_app_links_apps` FOREIGN KEY (`app_id`) REFERENCES `apps` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
    CONSTRAINT `FK_app_links_files` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
    CONSTRAINT `FK_app_links_permissions` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE = InnoDB
  AUTO_INCREMENT = 40
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `apps`
--

DROP TABLE IF EXISTS `apps`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `apps`
(
    `id`          int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name`        varchar(30)      NOT NULL,
    `cake_plugin` varchar(20)               DEFAULT NULL,
    `route`       varchar(80)               DEFAULT NULL,
    `sort`        int(10) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `environments`
--

DROP TABLE IF EXISTS `environments`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `environments`
(
    `id`            int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name`          varchar(50)      NOT NULL,
    `path`          varchar(100)     NOT NULL,
    `permission_id` int(10) unsigned          DEFAULT NULL,
    `created_at`    timestamp        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified_at`   timestamp        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `FK_environments_permissions` (`permission_id`),
    CONSTRAINT `FK_environments_permissions` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `files`
(
    `id`           int(10) unsigned                   NOT NULL AUTO_INCREMENT,
    `src`          enum ('google','onedrive','local') NOT NULL,
    `path`         varchar(200)                       NOT NULL,
    `mime_type_id` int(10) unsigned                            DEFAULT NULL,
    `name`         varchar(200)                       NOT NULL,
    `size`         int(10) unsigned                   NOT NULL,
    `width`        int(10) unsigned                            DEFAULT NULL,
    `height`       int(10) unsigned                            DEFAULT NULL,
    `user_id`      int(10) unsigned                            DEFAULT NULL,
    `created_at`   timestamp                          NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `accessed_at`  timestamp                          NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `FK_files_users` (`user_id`),
    KEY `FK_files_mime_types` (`mime_type_id`),
    CONSTRAINT `FK_files_mime_types` FOREIGN KEY (`mime_type_id`) REFERENCES `mime_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_files_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE = InnoDB
  AUTO_INCREMENT = 82
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `files_stores`
--

DROP TABLE IF EXISTS `files_stores`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files_stores`
(
    `file_id`  int(10) unsigned NOT NULL,
    `store_id` int(10) unsigned NOT NULL,
    PRIMARY KEY (`file_id`, `store_id`),
    KEY `FK_files_stores_file_id` (`file_id`),
    KEY `FK_files_stores_store_id` (`store_id`),
    CONSTRAINT `FK_files_stores_file_id` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_files_stores_store_id` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `location_time_zones`
--

DROP TABLE IF EXISTS `location_time_zones`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `location_time_zones`
(
    `id`           int(10) unsigned NOT NULL AUTO_INCREMENT,
    `location`     varchar(50) DEFAULT NULL,
    `time_zone_id` int(10) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    KEY `FK__time_zones` (`time_zone_id`),
    CONSTRAINT `FK__time_zones` FOREIGN KEY (`time_zone_id`) REFERENCES `time_zones` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE = InnoDB
  AUTO_INCREMENT = 17
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mime_types`
--

DROP TABLE IF EXISTS `mime_types`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `mime_types`
(
    `id`          int(10) unsigned  NOT NULL AUTO_INCREMENT,
    `name`        varchar(120)      NOT NULL,
    `image`       enum ('yes','no') NOT NULL,
    `resize`      enum ('yes','no') NOT NULL,
    `file_id`     int(10) unsigned              DEFAULT NULL COMMENT 'thumbnail image',
    `handler`     enum ('imagepng','pdfscript') DEFAULT NULL COMMENT 'special upload handler',
    `created_at`  timestamp         NOT NULL    DEFAULT CURRENT_TIMESTAMP,
    `modified_at` timestamp         NOT NULL    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `FK_mime_types_files` (`file_id`),
    CONSTRAINT `FK_mime_types_files` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB
  AUTO_INCREMENT = 22
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `option_stores`
--

DROP TABLE IF EXISTS `option_stores`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `option_stores`
(
    `id`             int(10) unsigned NOT NULL AUTO_INCREMENT,
    `option_id`      int(10) unsigned NOT NULL,
    `store_id`       int(10) unsigned NOT NULL,
    `environment_id` int(10) unsigned NOT NULL,
    `value`          varchar(120)     NOT NULL,
    `timestamp`      timestamp        NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `FK_option_stores_stores` (`store_id`),
    KEY `FK_option_stores_options` (`option_id`),
    KEY `FK_option_stores_environments` (`environment_id`),
    CONSTRAINT `FK_option_stores_environments` FOREIGN KEY (`environment_id`) REFERENCES `environments` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
    CONSTRAINT `FK_option_stores_options` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
    CONSTRAINT `FK_option_stores_stores` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `options`
(
    `id`        int(10) unsigned                                NOT NULL AUTO_INCREMENT,
    `name`      varchar(60)                                     NOT NULL,
    `type`      enum ('email','hexcolor','phone','text','file') NOT NULL,
    `value`     varchar(120)                                             DEFAULT NULL,
    `timestamp` timestamp                                       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 49
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `permission_groups`
--

DROP TABLE IF EXISTS `permission_groups`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `permission_groups`
(
    `id`   int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(30)      NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 8
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `permissions`
(
    `id`                  int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name`                varchar(100)     NOT NULL,
    `description`         varchar(100)     DEFAULT NULL,
    `permission_group_id` int(10) unsigned DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`),
    KEY `permission_group_id` (`permission_group_id`),
    CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`permission_group_id`) REFERENCES `permission_groups` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE = InnoDB
  AUTO_INCREMENT = 36
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `permissions_roles`
--

DROP TABLE IF EXISTS `permissions_roles`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `permissions_roles`
(
    `role_id`       int(10) unsigned NOT NULL,
    `permission_id` int(10) unsigned NOT NULL,
    PRIMARY KEY (`role_id`, `permission_id`),
    KEY `permissions_id` (`permission_id`),
    CONSTRAINT `permissions_roles_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `permissions_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `roles`
(
    `id`             int(10) unsigned  NOT NULL AUTO_INCREMENT,
    `name`           varchar(30)       NOT NULL,
    `manager_assign` enum ('yes','no') NOT NULL DEFAULT 'no',
    PRIMARY KEY (`id`),
    UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 11
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `roles_users`
--

DROP TABLE IF EXISTS `roles_users`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `roles_users`
(
    `role_id` int(10) unsigned NOT NULL,
    `user_id` int(10) unsigned NOT NULL,
    PRIMARY KEY (`role_id`, `user_id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `store_divisions`
--

DROP TABLE IF EXISTS `store_divisions`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `store_divisions`
(
    `id`                 int(10) unsigned NOT NULL AUTO_INCREMENT,
    `store_id`           int(10) unsigned DEFAULT NULL,
    `company_code`       varchar(3)       NOT NULL,
    `ar_division_number` varchar(2)       NOT NULL,
    PRIMARY KEY (`id`),
    KEY `store_id` (`store_id`),
    KEY `company_code` (`company_code`, `ar_division_number`),
    CONSTRAINT `store_divisions_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB
  AUTO_INCREMENT = 11
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `store_ip_maps`
--

DROP TABLE IF EXISTS `store_ip_maps`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `store_ip_maps`
(
    `id`             int(10) unsigned     NOT NULL AUTO_INCREMENT,
    `store_id`       int(10) unsigned     NOT NULL,
    `environment_id` int(10) unsigned     NOT NULL,
    `ip_address`     varchar(39)          NOT NULL,
    `port`           smallint(5) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    KEY `store_id` (`store_id`),
    KEY `ip_address` (`ip_address`, `port`),
    KEY `FK_store_ip_maps_environments` (`environment_id`),
    CONSTRAINT `FK_store_ip_maps_environments` FOREIGN KEY (`environment_id`) REFERENCES `environments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `store_ip_maps_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `store_returns`
--

DROP TABLE IF EXISTS `store_returns`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `store_returns`
(
    `id`                     int(10) unsigned NOT NULL AUTO_INCREMENT,
    `store_id`               int(10) unsigned DEFAULT NULL,
    `company_code`           varchar(3)       NOT NULL,
    `return_to_address_code` varchar(4)       NOT NULL,
    PRIMARY KEY (`id`),
    KEY `store_id` (`store_id`),
    KEY `company_code` (`company_code`, `return_to_address_code`),
    CONSTRAINT `store_returns_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB
  AUTO_INCREMENT = 13
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `store_sort_fields`
--

DROP TABLE IF EXISTS `store_sort_fields`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `store_sort_fields`
(
    `id`       int(10) unsigned NOT NULL AUTO_INCREMENT,
    `store_id` int(10) unsigned DEFAULT NULL,
    `sort`     varchar(10)      NOT NULL,
    PRIMARY KEY (`id`),
    KEY `store_id` (`store_id`),
    KEY `sort` (`sort`),
    CONSTRAINT `store_sort_fields_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB
  AUTO_INCREMENT = 2
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stores`
--

DROP TABLE IF EXISTS `stores`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `stores`
(
    `id`        int(10) unsigned  NOT NULL AUTO_INCREMENT,
    `name`      varchar(30)       NOT NULL,
    `active`    enum ('yes','no') NOT NULL,
    `parent_id` int(10) unsigned DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `name_UNIQUE` (`name`),
    KEY `parent_id` (`parent_id`),
    CONSTRAINT `stores_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `stores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB
  AUTO_INCREMENT = 15
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `time_zones`
--

DROP TABLE IF EXISTS `time_zones`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `time_zones`
(
    `id`   int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(50)      NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 5
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_contacts`
--

DROP TABLE IF EXISTS `user_contacts`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `user_contacts`
(
    `id`      int(10) unsigned                       NOT NULL AUTO_INCREMENT,
    `user_id` int(10) unsigned                       NOT NULL,
    `type`    enum ('Direct','Email','Ext','Mobile') NOT NULL,
    `contact` varchar(80)                            NOT NULL,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 11799
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_logins`
--

DROP TABLE IF EXISTS `user_logins`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `user_logins`
(
    `id`         int(10) unsigned NOT NULL AUTO_INCREMENT,
    `user_id`    int(10) unsigned NOT NULL,
    `ip_address` varchar(39)           DEFAULT NULL,
    `browser`    varchar(200)          DEFAULT NULL,
    `width`      smallint(5) unsigned  DEFAULT NULL,
    `height`     smallint(5) unsigned  DEFAULT NULL,
    `timestamp`  timestamp        NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `user_logins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB
  AUTO_INCREMENT = 911
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
SET character_set_client = utf8mb4;
CREATE TABLE `users`
(
    `id`           int(10) unsigned  NOT NULL AUTO_INCREMENT,
    `ldapid`       varchar(65)       NOT NULL,
    `username`     varchar(30)       NOT NULL,
    `display_name` varchar(50)       NOT NULL,
    `first_name`   varchar(30)       NOT NULL,
    `last_name`    varchar(60)      DEFAULT NULL,
    `email`        varchar(80)      DEFAULT NULL,
    `title`        varchar(50)      DEFAULT NULL,
    `department`   varchar(50)      DEFAULT NULL,
    `location`     varchar(50)      DEFAULT NULL,
    `time_zone_id` int(10) unsigned DEFAULT NULL,
    `manager_id`   int(10) unsigned DEFAULT NULL,
    `active`       enum ('yes','no') NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `ldapid` (`ldapid`),
    KEY `FK_users_users` (`manager_id`),
    KEY `FK_users_time_zones` (`time_zone_id`),
    CONSTRAINT `FK_users_time_zones` FOREIGN KEY (`time_zone_id`) REFERENCES `time_zones` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
    CONSTRAINT `FK_users_users` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE = InnoDB
  AUTO_INCREMENT = 892
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE = @OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE = @OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES = @OLD_SQL_NOTES */;

-- Dump completed on 2019-09-19 16:15:15
