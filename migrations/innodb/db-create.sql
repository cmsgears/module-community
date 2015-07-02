/* ============================= CMSGears Community ========================================= */

--
-- Table structure for table `cmg_cmn_friend`
--

DROP TABLE IF EXISTS `cmg_cmn_friend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cmn_friend` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) NOT NULL,
  `friendId` bigint(20) NOT NULL,
  `createdAt` datetime DEFAULT NULL,
  `modifiedAt` datetime DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_cmg_cmn_friend_1` (`userId`),
  KEY `fk_cmg_cmn_friend_2` (`friendId`)
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
  `recipientId` bigint(20) DEFAULT NULL,
  `visibility` smallint(6) NOT NULL,
  `content` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `modifiedAt` datetime DEFAULT NULL,
  `mark` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_cmg_cmn_message_1` (`senderId`),
  KEY `fk_cmg_cmn_message_2` (`recipientId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cmn_chat`
--

DROP TABLE IF EXISTS `cmg_cmn_chat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cmn_chat` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sessionId` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `modifiedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cmn_chat_member`
--

DROP TABLE IF EXISTS `cmg_cmn_chat_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cmn_chat_member` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `chatId` bigint(20) NOT NULL,
  `userId` bigint(20) NOT NULL,
  `createdAt` datetime DEFAULT NULL,
  `modifiedAt` datetime DEFAULT NULL,
  `syncedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cmg_cmn_chat_member_1` (`chatId`),
  KEY `fk_cmg_cmn_chat_member_2` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_cmn_chat_message`
--

DROP TABLE IF EXISTS `cmg_cmn_chat_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_cmn_chat_message` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `chatId` bigint(20) NOT NULL,
  `messageId` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cmg_cmn_chat_message_1` (`chatId`),
  KEY `fk_cmg_cmn_chat_message_2` (`messageId`)
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
  `avatarId` bigint(20) DEFAULT NULL,
  `createdBy` bigint(20) DEFAULT NULL,
  `modifiedBy` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) DEFAULT 0,
  `visibility` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cmg_cmn_group_1` (`avatarId`),
  KEY `fk_cmg_cmn_group_2` (`createdBy`),
  KEY `fk_cmg_cmn_group_3` (`modifiedBy`)
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
  `userId` bigint(20) NOT NULL,
  `roleId` bigint(20) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT 0,
  `createdAt` datetime DEFAULT NULL,
  `modifiedAt` datetime DEFAULT NULL,
  `syncedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cmg_cmn_group_member_1` (`groupId`),
  KEY `fk_cmg_cmn_group_member_2` (`userId`),
  KEY `fk_cmg_cmn_group_member_3` (`roleId`)
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
  `modifiedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cmg_cmn_group_message_1` (`groupId`),
  KEY `fk_cmg_cmn_group_message_2` (`memberId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET FOREIGN_KEY_CHECKS=0;

--
-- Constraints for table `cmg_cmn_friend`
--
ALTER TABLE `cmg_cmn_friend`
	ADD CONSTRAINT `fk_cmg_cmn_friend_1` FOREIGN KEY (`userId`) REFERENCES `cmg_core_user` (`id`) ON DELETE CASCADE,
  	ADD CONSTRAINT `fk_cmg_cmn_friend_2` FOREIGN KEY (`friendId`) REFERENCES `cmg_core_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cmg_cmn_message`
--
ALTER TABLE `cmg_cmn_message`
	ADD CONSTRAINT `fk_cmg_cmn_message_1` FOREIGN KEY (`senderId`) REFERENCES `cmg_core_user` (`id`) ON DELETE CASCADE,
	ADD CONSTRAINT `fk_cmg_cmn_message_2` FOREIGN KEY (`recipientId`) REFERENCES `cmg_core_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cmg_cmn_chat_member`
--
ALTER TABLE `cmg_cmn_chat_member`
	ADD CONSTRAINT `fk_cmg_cmn_chat_member_1` FOREIGN KEY (`chatId`) REFERENCES `cmg_cmn_chat` (`id`) ON DELETE CASCADE,
	ADD CONSTRAINT `fk_cmg_cmn_chat_member_2` FOREIGN KEY (`userId`) REFERENCES `cmg_core_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cmg_cmn_chat_message`
--
ALTER TABLE `cmg_cmn_chat_message`
	ADD CONSTRAINT `fk_cmg_cmn_chat_message_1` FOREIGN KEY (`chatId`) REFERENCES `cmg_cmn_chat` (`id`) ON DELETE CASCADE,
	ADD CONSTRAINT `fk_cmg_cmn_chat_message_2` FOREIGN KEY (`messageId`) REFERENCES `cmg_cmn_chat_message` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cmg_cmn_group`
--
ALTER TABLE `cmg_cmn_group`
	ADD CONSTRAINT `fk_cmg_cmn_group_1` FOREIGN KEY (`avatarId`) REFERENCES `cmg_core_file` (`id`),
	ADD CONSTRAINT `fk_cmg_cmn_group_2` FOREIGN KEY (`createdBy`) REFERENCES `cmg_core_user` (`id`),
	ADD CONSTRAINT `fk_cmg_cmn_group_3` FOREIGN KEY (`modifiedBy`) REFERENCES `cmg_core_user` (`id`);

--
-- Constraints for table `cmg_cmn_group_member`
--
ALTER TABLE `cmg_cmn_group_member`
	ADD CONSTRAINT `fk_cmg_cmn_group_member_1` FOREIGN KEY (`groupId`) REFERENCES `cmg_cmn_group` (`id`) ON DELETE CASCADE,
	ADD CONSTRAINT `fk_cmg_cmn_group_member_2` FOREIGN KEY (`userId`) REFERENCES `cmg_core_user` (`id`) ON DELETE CASCADE,
	ADD CONSTRAINT `fk_cmg_cmn_group_member_3` FOREIGN KEY (`roleId`) REFERENCES `cmg_core_role` (`id`);

--
-- Constraints for table `cmg_cmn_group_message`
--
ALTER TABLE `cmg_cmn_group_message`
	ADD CONSTRAINT `fk_cmg_cmn_group_message_1` FOREIGN KEY (`groupId`) REFERENCES `cmg_cmn_group` (`id`) ON DELETE CASCADE,
	ADD CONSTRAINT `fk_cmg_cmn_group_message_2` FOREIGN KEY (`memberId`) REFERENCES `cmg_cmn_group_member` (`id`) ON DELETE CASCADE;

SET FOREIGN_KEY_CHECKS=1;
