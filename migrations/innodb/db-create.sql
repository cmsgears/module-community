SET FOREIGN_KEY_CHECKS=0;

--
-- Table structure for table `cmg_cmn_friend`
--

DROP TABLE IF EXISTS `cmg_cmn_friend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cmn_friend` (
  `userId` bigint(20) NOT NULL,
  `friendId` bigint(20) NOT NULL,
  `createdAt` datetime DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT 0,
  PRIMARY KEY (`userId`,`friendId`),
  KEY `fk_cmn_friend_1` (`userId`),
  KEY `fk_cmn_friend_2` (`friendId`),
  CONSTRAINT `fk_cmn_friend_1` FOREIGN KEY (`userId`) REFERENCES `cmg_user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cmn_friend_2` FOREIGN KEY (`friendId`) REFERENCES `cmg_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cmn_message`
--

DROP TABLE IF EXISTS `cmg_cmn_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cmn_message` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `senderId` bigint(20) NOT NULL,
  `recipientId` bigint(20) NOT NULL,
  `type` smallint(6) NOT NULL,
  `content` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `read` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_cmn_message_1` (`senderId`),
  KEY `fk_cmn_message_2` (`recipientId`),
  CONSTRAINT `fk_cmn_message_1` FOREIGN KEY (`senderId`) REFERENCES `cmg_user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cmn_message_2` FOREIGN KEY (`recipientId`) REFERENCES `cmg_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cmn_group`
--

DROP TABLE IF EXISTS `cmg_cmn_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cmn_group` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ownerId` bigint(20) DEFAULT NULL,
  `avatarId` bigint(20) DEFAULT NULL,
  `bannerId` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` smallint(6) DEFAULT 0,
  `status` smallint(6) DEFAULT 0,
  `visibility` smallint(6) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_group_slug` (`slug`),
  KEY `fk_cmn_group_1` (`ownerId`),
  KEY `fk_cmn_group_2` (`avatarId`),
  KEY `fk_cmn_group_3` (`bannerId`),
  CONSTRAINT `fk_cmn_group_1` FOREIGN KEY (`ownerId`) REFERENCES `cmg_user` (`id`),
  CONSTRAINT `fk_cmn_group_2` FOREIGN KEY (`avatarId`) REFERENCES `cmg_file` (`id`),
  CONSTRAINT `fk_cmn_group_3` FOREIGN KEY (`bannerId`) REFERENCES `cmg_file` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cmn_group_meta`
--

DROP TABLE IF EXISTS `cmg_cmn_group_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cmn_group_meta` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `groupId` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cmn_group_meta_1` (`groupId`),
  CONSTRAINT `fk_cmn_group_meta_1` FOREIGN KEY (`groupId`) REFERENCES `cmg_cmn_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cmn_group_category`
--

DROP TABLE IF EXISTS `cmg_cmn_group_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cmn_group_category` (
  `groupId` bigint(20) NOT NULL,
  `categoryId` bigint(20) NOT NULL,
  PRIMARY KEY (`groupId`,`categoryId`),
  KEY `fk_cmn_group_category_1` (`groupId`),
  KEY `fk_cmn_group_category_2` (`categoryId`),
  CONSTRAINT `fk_cmn_group_category_1` FOREIGN KEY (`groupId`) REFERENCES `cmg_cmn_group` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cmn_group_category_2` FOREIGN KEY (`categoryId`) REFERENCES `cmg_category` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cmn_group_member`
--

DROP TABLE IF EXISTS `cmg_cmn_group_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cmn_group_member` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `groupId` bigint(20) NOT NULL,
  `memberId` bigint(20) NOT NULL,
  `roleId` bigint(20) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT 0,
  `joinedAt` datetime DEFAULT NULL,
  `syncedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cmn_group_member_1` (`groupId`),
  KEY `fk_cmn_group_member_2` (`memberId`),
  KEY `fk_cmn_group_member_3` (`roleId`),
  CONSTRAINT `fk_cmn_group_member_1` FOREIGN KEY (`groupId`) REFERENCES `cmg_cmn_group` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cmn_group_member_2` FOREIGN KEY (`memberId`) REFERENCES `cmg_user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cmn_group_member_3` FOREIGN KEY (`roleId`) REFERENCES `cmg_role` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cmn_group_message`
--

DROP TABLE IF EXISTS `cmg_cmn_group_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cmn_group_message` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `groupId` bigint(20) NOT NULL,
  `memberId` bigint(20) NOT NULL,
  `visibility` smallint(6) NOT NULL DEFAULT 0,
  `content` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cmn_group_message_1` (`groupId`),
  KEY `fk_cmn_group_message_2` (`memberId`),
  CONSTRAINT `fk_cmn_group_message_1` FOREIGN KEY (`groupId`) REFERENCES `cmg_cmn_group` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cmn_group_message_2` FOREIGN KEY (`memberId`) REFERENCES `cmg_cmn_group_member` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET FOREIGN_KEY_CHECKS=1;