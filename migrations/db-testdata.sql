USE `cmgdemo`;

/* ============================= CMS Gears Community ============================================== */

--
-- Dumping data for table `cmg_option`
--

INSERT INTO `cmg_option` VALUES 
	(2001,1,'Group','2001'),
	(2002,2,'Group','2001');

--
-- Dumping data for table `cmg_role`
--

INSERT INTO `cmg_role` VALUES 
	(2001,'Message Manager','The role Message Manager is limited to manage private chat sessions from admin.','/',0),
	(2002,'Group Manager','The role Group Manager is limited to manage groups from admin.','/',0),
	(2003,'Group Super Admin','The role Super Admin is limited to manage groups from website. Admin has full rights to create, read, update or delete Group and to manage Group Settings. Group Admin can also manage Group Members and change their roles.','/',10),
	(2004,'Group Admin','The role Admin is limited to manage groups from website. Admin has full rights to update Group Profile. Group Admin can also manage Group Members, change their roles with less privileges than Admin.','/',10),
	(2005,'Group Moderator','The role Moderator is limited to manage groups from website. Moderators can update or delete Group Messages and change Group Status Message.','/',10),
	(2006,'Group Member','The role Member is limited to site users from website. Members can post on group, invite friends to join groups, share group on facebook wall, tweet about group on twitter.','/',10);

--
-- Dumping data for table `cmg_permission`
--

INSERT INTO `cmg_permission` VALUES 
	(2001,'community','The permission community is to manage community module from admin.'),
	(2002,'community-message','The permission community-message is to manage user private offline and online chat messages from admin.'),
	(2003,'community-group','The permission community-group is to manage community groups, group members and messages from admin.'),
	(2004,'group-create','The permission group-create is to create group from website.'),
	(2005,'group-delete','The permission group-delete is to delete group from website.'),
	(2006,'group-update-settings','The permission group-update-settings is to update group settings from website.'),
	(2007,'group-update-profile','The permission group-update-profile is to update group profile from website.'),
	(2008,'group-member-role','The permission group-member-role is to manage member role from website.'),
	(2009,'group-member-approve','The permission group-member-approve is to approve group member from website.'),
	(2010,'group-member-block','The permission group-member-block is to block group member from website.'),
	(2011,'group-member-remove','The permission group-member-remove is to remove group member from website. It delete all member activity logs.'),
	(2012,'group-status-message','The permission group-status-message is to update group status message from website.'),
	(2013,'group-message-update','The permission group-message-update is to update group message from website. It allows to update message posted by all the group members.'),
	(2014,'group-message-delete','The permission group-message-delete is to delete group message from website. It allows to delete message posted by all the group members.');

--
-- Dumping data for table `cmg_role_permission`
--

INSERT INTO `cmg_role_permission` VALUES 
	(1,2001),(1,2002),(1,2003),
	(2,2001),(2,2002),(2,2003),
	(2001,1),(2001,2),(2001,2001),(2001,2002),
	(2002,1),(2002,2),(2002,2001),(2002,2003),
	(2003,2004),(2003,2005),(2003,2006),(2003,2007),(2003,2008),(2003,2009),(2003,2010),(2003,2011),(2003,2012),(2003,2013),(2003,2014),
	(2004,2006),(2004,2007),(2004,2008),(2004,2009),(2004,2010),(2004,2011),(2004,2012),(2004,2013),(2004,2014),
	(2005,2013),(2005,2014);

--
-- Dumping data for table `cmg_user`
--

INSERT INTO `cmg_user` VALUES 
	(2001,2001,NULL,NULL,NULL,10,'demochatmanager@cmsgears.org','demochatmanager','$2y$13$Ut5b2RskRpGA9Q0nKSO6Xe65eaBHdx/q8InO8Ln6Lt3HzOK4ECz8W','demo','user',NULL,NULL,1,NULL,NULL,'2014-10-11 14:22:54','2014-10-10 08:03:19',NULL,NULL,NULL,NULL),
	(2002,2002,NULL,NULL,NULL,10,'demogroupmanager@cmsgears.org','demogroupmanager','$2y$13$Ut5b2RskRpGA9Q0nKSO6Xe65eaBHdx/q8InO8Ln6Lt3HzOK4ECz8W','demo','user',NULL,NULL,1,NULL,NULL,'2014-10-11 14:22:54','2014-10-10 08:03:19',NULL,NULL,NULL,NULL);