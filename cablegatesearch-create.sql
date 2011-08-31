-- MySQL dump 10.13  Distrib 5.1.49, for debian-linux-gnu (x86_64)
--

-- ------------------------------------------------------
-- Server version	5.1.49-1ubuntu8.1

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
-- Table structure for table `cablegate_classifications`
--

DROP TABLE IF EXISTS `cablegate_classifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cablegate_classifications` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `classification` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cablegate_origins`
--

DROP TABLE IF EXISTS `cablegate_origins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cablegate_origins` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `origin` tinytext NOT NULL,
  `country_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cablegate_countries`
--

DROP TABLE IF EXISTS `cablegate_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cablegate_countries` (
  `country_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `country` tinytext NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cablegate_cables`
--

DROP TABLE IF EXISTS `cablegate_cables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cablegate_cables` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `canonical_id` varchar(36) NOT NULL DEFAULT '',
  `classification_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `origin_id` mediumint(4) unsigned NOT NULL DEFAULT '0',
  `cable_time` int(11) NOT NULL DEFAULT '0',
  `release_time` int(11) NOT NULL DEFAULT '0',
  `change_time` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `subject` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `canonical_id` (`canonical_id`),
  KEY `cable_time` (`cable_time`),
  KEY `release_time` (`release_time`),
  KEY `change_time` (`change_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cablegate_contributors`
--

DROP TABLE IF EXISTS `cablegate_contributors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cablegate_contributors` (
  `sha1` char(40) NOT NULL,
  `who` tinytext NOT NULL,
  PRIMARY KEY (`sha1`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cablegate_tags`
--

DROP TABLE IF EXISTS `cablegate_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cablegate_tags` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `tag` tinytext NOT NULL,
  `definition` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cablegate_tagassoc`
--

DROP TABLE IF EXISTS `cablegate_tagassoc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cablegate_tagassoc` (
  `tag_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `cable_id` mediumint(6) unsigned NOT NULL,
  KEY `tag_id` (`tag_id`),
  KEY `cable_id` (`cable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cablegate_terms`
--

DROP TABLE IF EXISTS `cablegate_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cablegate_terms` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `term` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `term` (`term`(4))
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cablegate_termassoc`
--

DROP TABLE IF EXISTS `cablegate_termassoc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cablegate_termassoc` (
  `term_id` mediumint(6) unsigned NOT NULL,
  `cable_id` mediumint(6) unsigned NOT NULL,
  KEY `term_id` (`term_id`),
  KEY `cable_id` (`cable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cablegate_contents`
--

DROP TABLE IF EXISTS `cablegate_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cablegate_contents` (
  `id` mediumint(8) unsigned NOT NULL,
  `hash` varbinary(16) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `tokenized` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cablegate_changes`
--

DROP TABLE IF EXISTS `cablegate_changes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cablegate_changes` (
  `release_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `cable_id` mediumint(6) NOT NULL,
  `change` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `diff` blob NOT NULL,
  PRIMARY KEY (`release_id`,`cable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cablegate_releases`
--

DROP TABLE IF EXISTS `cablegate_releases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cablegate_releases` (
  `release_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `release_time` int(11) NOT NULL DEFAULT '0',
  `magnet` tinytext NOT NULL,
  PRIMARY KEY (`release_id`),
  KEY `release_time` (`release_time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cablegate_ucables`
--

DROP TABLE IF EXISTS `cablegate_ucables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cablegate_ucables` (
  `ucable_id` mediumint(8) unsigned NOT NULL,
  `cable_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `cable_time` int(11) NOT NULL DEFAULT '0',
  `origin_id` smallint(3) unsigned NOT NULL DEFAULT '0',
  `tags` text NOT NULL,
  PRIMARY KEY (`ucable_id`),
  KEY `cable_time` (`cable_time`),
  KEY `origin_id` (`origin_id`),
  KEY `cable_id` (`cable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cablegate_urls`
--

DROP TABLE IF EXISTS `cablegate_urls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cablegate_urls` (
  `url_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `httpcode` smallint(6) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `title` blob,
  `content` mediumblob,
  PRIMARY KEY (`url_id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cablegate_urlassoc`
--

DROP TABLE IF EXISTS `cablegate_urlassoc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cablegate_urlassoc` (
  `cable_id` mediumint(6) unsigned NOT NULL,
  `url_id` smallint(5) unsigned NOT NULL,
  `flags` tinyint(3) unsigned NOT NULL DEFAULT '0',
  KEY `cable_id` (`cable_id`),
  KEY `url_id` (`url_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-08-31 12:30:41
