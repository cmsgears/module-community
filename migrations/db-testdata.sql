--
-- Dumping data for table `cmg_core_option`
--

INSERT INTO `cmg_core_option` (`categoryId`,`name`,`value`,`icon`) VALUES 
	(1,'group','Group Roles',NULL);

--
-- Dumping data for table `cmg_core_role`
--

INSERT INTO `cmg_core_role` VALUES 
	(1551,1,1,'Chat Manager','The role Chat Manager is limited to manage private chat sessions from admin.','/',0,'2014-10-11 14:22:54','2014-10-11 14:22:54',NULL),
	(1552,1,1,'Group Manager','The role Group Manager is limited to manage groups from admin.','/',0,'2014-10-11 14:22:54','2014-10-11 14:22:54',NULL),
	(1553,1,1,'Group Super Admin','The role Super Admin is limited to manage groups from website. Admin has full rights to create, read, update or delete Group and to manage Group Settings. Group Admin can also manage Group Members and change their roles.','/',1552,'2014-10-11 14:22:54','2014-10-11 14:22:54',NULL),
	(1554,1,1,'Group Admin','The role Admin is limited to manage groups from website. Admin has full rights to update Group Profile. Group Admin can also manage Group Members, change their roles with less privileges than Admin.','/',1552,'2014-10-11 14:22:54','2014-10-11 14:22:54',NULL),
	(1555,1,1,'Group Moderator','The role Moderator is limited to manage groups from website. Moderators can update or delete Group Messages and change Group Status Message.','/',1552,'2014-10-11 14:22:54','2014-10-11 14:22:54',NULL),
	(1556,1,1,'Group Member','The role Member is limited to site users from website. Members can post on group, invite friends to join groups, share group on facebook wall, tweet about group on twitter.','/',1552,'2014-10-11 14:22:54','2014-10-11 14:22:54',NULL);

--
-- Dumping data for table `cmg_core_permission`
--

INSERT INTO `cmg_core_permission` VALUES 
	(1551,1,1,'community','The permission community is to manage community module from admin.','2014-10-11 14:22:54','2014-10-11 14:22:54',NULL),
	(1552,1,1,'community-chat','The permission community-chat is to manage user private offline and online chat messages from admin.','2014-10-11 14:22:54','2014-10-11 14:22:54',NULL),
	(1553,1,1,'community-group','The permission community-group is to manage community groups, group members and messages from admin.','2014-10-11 14:22:54','2014-10-11 14:22:54',NULL),
	(1554,1,1,'group-create','The permission group-create is to create group from website.','2014-10-11 14:22:54','2014-10-11 14:22:54',NULL),
	(1555,1,1,'group-delete','The permission group-delete is to delete group from website.','2014-10-11 14:22:54','2014-10-11 14:22:54',NULL),
	(1556,1,1,'group-update-settings','The permission group-update-settings is to update group settings from website.','2014-10-11 14:22:54','2014-10-11 14:22:54',NULL),
	(1557,1,1,'group-update-profile','The permission group-update-profile is to update group profile from website.','2014-10-11 14:22:54','2014-10-11 14:22:54',NULL),
	(1558,1,1,'group-member-role','The permission group-member-role is to manage member role from website.','2014-10-11 14:22:54','2014-10-11 14:22:54',NULL),
	(1559,1,1,'group-member-approve','The permission group-member-approve is to approve group member from website.','2014-10-11 14:22:54','2014-10-11 14:22:54',NULL),
	(1560,1,1,'group-member-block','The permission group-member-block is to block group member from website.','2014-10-11 14:22:54','2014-10-11 14:22:54',NULL),
	(1561,1,1,'group-member-remove','The permission group-member-remove is to remove group member from website. It delete all member activity logs.','2014-10-11 14:22:54','2014-10-11 14:22:54',NULL),
	(1562,1,1,'group-status-message','The permission group-status-message is to update group status message from website.','2014-10-11 14:22:54','2014-10-11 14:22:54',NULL),
	(1563,1,1,'group-message-update','The permission group-message-update is to update group message from website. It allows to update message posted by all the group members.','2014-10-11 14:22:54','2014-10-11 14:22:54',NULL),
	(1564,1,1,'group-message-delete','The permission group-message-delete is to delete group message from website. It allows to delete message posted by all the group members.','2014-10-11 14:22:54','2014-10-11 14:22:54',NULL);

--
-- Dumping data for table `cmg_core_role_permission`
--

INSERT INTO `cmg_core_role_permission` VALUES 
	(1,1551),(1,1552),(1,1553),
	(2,1551),(2,1552),(2,1553),
	(1551,1),(1551,2),(1551,1551),(1551,1552),
	(1552,1),(1552,2),(1552,1551),(1552,1553),
	(1553,1554),(1553,1555),(1553,1556),(1553,1557),(1553,1558),(1553,1559),(1553,1560),(1553,1561),(1553,1562),(1553,1563),(1553,1564),
	(1554,1556),(1554,1557),(1554,1558),(1554,1559),(1554,1560),(1554,1561),(1554,1562),(1554,1563),(1554,1564),
	(1555,1563),(1555,1564);