USE `cmgdemo`;

SET FOREIGN_KEY_CHECKS=0;

/* ============================= CMS Gears Community ============================================== */

--
-- Table structure for table `cmg_cmn_message`
--

DROP TABLE IF EXISTS `cmg_cmn_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cmn_message` (
  `message_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `message_owner` bigint(20) NOT NULL,
  `message_recipient` bigint(20) NOT NULL,
  `message_type` smallint(6) NOT NULL,
  `message_content` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message_created_on` datetime DEFAULT NULL,
  `message_consumed` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`message_id`),
  KEY `fk_message_1` (`message_owner`),
  KEY `fk_message_2` (`message_recipient`),
  CONSTRAINT `fk_message_1` FOREIGN KEY (`message_owner`) REFERENCES `cmg_user` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_message_2` FOREIGN KEY (`message_recipient`) REFERENCES `cmg_user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cmn_group`
--

DROP TABLE IF EXISTS `cmg_cmn_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cmn_group` (
  `group_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `group_owner` bigint(20) DEFAULT NULL,
  `group_avatar` bigint(20) DEFAULT NULL,
  `group_banner` bigint(20) DEFAULT NULL,
  `group_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_content` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_status` smallint(6) DEFAULT NULL,
  `group_visibility` smallint(6) DEFAULT NULL,
  `group_created_on` datetime DEFAULT NULL,
  `group_updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `group_slug_unique` (`group_slug`),
  KEY `fk_group_1` (`group_owner`),
  KEY `fk_group_2` (`group_avatar`),
  KEY `fk_group_3` (`group_banner`),
  CONSTRAINT `fk_group_1` FOREIGN KEY (`group_owner`) REFERENCES `cmg_user` (`user_id`),
  CONSTRAINT `fk_group_2` FOREIGN KEY (`group_avatar`) REFERENCES `cmg_file` (`file_id`),
  CONSTRAINT `fk_group_3` FOREIGN KEY (`group_banner`) REFERENCES `cmg_file` (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cmn_group_category`
--

DROP TABLE IF EXISTS `cmg_cmn_group_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cmn_group_category` (
  `group_id` bigint(20) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  PRIMARY KEY (`group_id`,`category_id`),
  KEY `fk_group_category_1` (`group_id`),
  KEY `fk_group_category_2` (`category_id`),
  CONSTRAINT `fk_group_category_1` FOREIGN KEY (`group_id`) REFERENCES `cmg_cmn_group` (`group_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_group_category_2` FOREIGN KEY (`category_id`) REFERENCES `cmg_category` (`category_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cmn_group_member`
--

DROP TABLE IF EXISTS `cmg_cmn_group_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cmn_group_member` (
  `member_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_group` bigint(20) NOT NULL,
  `member_user` bigint(20) NOT NULL,
  `member_role` bigint(20) DEFAULT NULL,
  `member_status` smallint(6) NOT NULL DEFAULT 0,
  `member_joined_on` datetime DEFAULT NULL,
  `member_synced_on` datetime DEFAULT NULL,
  PRIMARY KEY (`member_id`),
  KEY `fk_group_member_1` (`member_group`),
  KEY `fk_group_member_2` (`member_user`),
  KEY `fk_group_member_3` (`member_role`),
  CONSTRAINT `fk_group_member_1` FOREIGN KEY (`member_group`) REFERENCES `cmg_cmn_group` (`group_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_group_member_2` FOREIGN KEY (`member_user`) REFERENCES `cmg_user` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_group_member_3` FOREIGN KEY (`member_role`) REFERENCES `cmg_role` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cmn_group_message`
--

DROP TABLE IF EXISTS `cmg_cmn_group_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cmn_group_message` (
  `message_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `message_group` bigint(20) NOT NULL,
  `message_owner` bigint(20) NOT NULL,
  `message_visibility` smallint(6) NOT NULL DEFAULT 0,
  `message_content` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message_created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`message_id`),
  KEY `fk_group_message_1` (`message_group`),
  KEY `fk_group_message_2` (`message_owner`),
  CONSTRAINT `fk_group_message_1` FOREIGN KEY (`message_group`) REFERENCES `cmg_cmn_group` (`group_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_group_message_2` FOREIGN KEY (`message_owner`) REFERENCES `cmg_cmn_group_member` (`member_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET FOREIGN_KEY_CHECKS=1;